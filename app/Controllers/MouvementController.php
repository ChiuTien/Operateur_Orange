<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Mouvement;
use App\Models\Bareme;
use App\Models\Numero; 

class MouvementController extends BaseController {
    protected $mouvement;
    protected $bareme;
    protected $numeroModel; 

    public function __construct() {
        $this->mouvement = new Mouvement();
        $this->bareme = new Bareme();
        $this->numeroModel = new Numero();
    }

    // --- Sous-Méthodes ---
    public function getDataDepotRetrait() {
        $idNum = session()->get('id_numero');
        $montant = $this->request->getPost('montant');

        if (!$idNum) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }
        if (!$montant || $montant <= 0) {
            return redirect()->to('/accueil')->with('error', 'Veuillez insérer un montant valide.');
        }

        return [
            "idNum" => $idNum,
            "montant" => $montant
        ];
    }

    public function deductionFrais($montant, $idOperation) {
        $idOperateur = session()->get('id_operateur');
        
        if (!$idOperateur) {
            return $montant;
        }

        $ligne = $this->bareme->where('idOperateur', $idOperateur)
                             ->where('idOperation', $idOperation)
                             ->where("{$montant} BETWEEN min AND max")
                             ->first();

        $frais = $ligne['frais'] ?? 0;        
        return $montant + $frais;
    }
    public function getSolde($idNum) {
        $resultat = $this->mouvement->select("
            SUM(
                CASE 
                    WHEN idOperation IN (2, 3) THEN -argent
                    ELSE argent                              
                END
            ) AS solde
        ", false)->where('idN1', $idNum)->first();
        return $resultat['solde'] ?? 0;
    }

    // --- Méthodes Principales ---
    public function depot() {
        $data = $this->getDataDepotRetrait();

        if (!is_array($data)) {
            return $data; 
        }

        $idNum = $data['idNum'];
        $montant = $data['montant'];

        $montant = $this->deductionFrais($montant, 1);

        $donnee = [
            "idN1" => $idNum,
            "idOperateur" => session()->get('id_operateur'),
            "idOperation" => 1,
            "argent" => $montant
        ];

        $this->mouvement->save($donnee);
        return redirect()->to("/accueil");
    }

    public function retrait() {
        $data = $this->getDataDepotRetrait();

        if (!is_array($data)) {
            return $data; 
        }

        $idNum = $data['idNum'];
        $montantInitial = $data['montant'];

        $solde = $this->getSolde($idNum);
        
        $montantAvecFrais = $this->deductionFrais($montantInitial, 2);

        if ($solde < $montantAvecFrais) {
            $necessaire = $montantAvecFrais - $solde;
            return redirect()->to('/accueil')->with('error', "Solde insuffisant. Il vous manque {$necessaire} Ar pour couvrir le retrait et ses frais.");
        } 

        $donnee = [
            "idN1" => $idNum,
            "idOperateur" => session()->get('id_operateur'),
            "idOperation" => 2,
            "argent" => $montantAvecFrais
        ];
        $this->mouvement->save($donnee);
        return redirect()->to("/accueil");
    }

    public function transfert() {
        $data = $this->getDataDepotRetrait();
        if (!is_array($data)) {
            return $data;
        }

        $idExpediteur = $data['idNum'];
        $montantInitial = $data['montant'];
        
        $numSaisi = $this->request->getPost('beneficiaire');
        $beneficiaireData = $this->numeroModel->findBySequence($numSaisi); 
        
        if (!$beneficiaireData) {
            return redirect()->to('/accueil')->with('error', "Bénéficiaire introuvable.");
        }

        $idBeneficiaire = $beneficiaireData['id'];
        if ($idExpediteur == $idBeneficiaire) {
            return redirect()->to('/accueil')->with('error', "Vous ne pouvez pas vous envoyer de l'argent à vous-même.");
        }

        $montantAvecFrais = $this->deductionFrais($montantInitial, 3);
        $solde = $this->getSolde($idExpediteur);

        if ($solde < $montantAvecFrais) {
            $necessaire = $montantAvecFrais - $solde;
            return redirect()->to('/accueil')->with('error', "Solde insuffisant. Il vous manque {$necessaire} Ar.");
        }

        $donneeExpediteur = [
            "idN1"        => $idExpediteur,
            "idN2"        => $idBeneficiaire, 
            "idOperateur" => session()->get('id_operateur'),
            "idOperation" => 3, 
            "argent"      => $montantAvecFrais
        ];
        $this->mouvement->save($donneeExpediteur);

        $donneeBeneficiaire = [
            "idN1"        => $idBeneficiaire,
            "idN2"        => $idExpediteur,
            "idOperateur" => $beneficiaireData['idOperateur'],
            "idOperation" => 1, 
            "argent"      => $montantInitial
        ];
        $this->mouvement->save($donneeBeneficiaire);

        return redirect()->to("/accueil")->with('success', 'Transfert envoyé avec succès !');
    }

    public function historique() {
        $idNum = session()->get('id_numero');
        if (!$idNum) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $filtre = $this->request->getPost('filtre') ?? 'tout';
        $query = $this->mouvement->where('idN1', $idNum);

        switch ($filtre) {
            case 'depot':
                $query->where('idOperation', 1);
                break;
            case 'retrait':
                $query->where('idOperation', 2);
                break;
            case 'transfert':
                $query->where('idOperation', 3);
                break;
            default:
                break;
        }

        $listeMouvements = $query->orderBy('id', 'DESC')->findAll();

        return view('mouvements/historique_vue', [
            'mouvements'    => $listeMouvements,
            'filtreActuel'  => $filtre
        ]);
    }
    public function situationGainsGlobalises() {
        $gains = $this->mouvement
            ->select("
                mouvement.idOperateur,
                SUM(bareme.frais) AS total_gains
            ")
            ->join('bareme', '
                bareme.idOperateur = mouvement.idOperateur 
                AND bareme.idOperation = mouvement.idOperation 
                AND mouvement.argent BETWEEN bareme.min AND (bareme.max + bareme.frais)
            ', 'inner')
            ->whereIn('mouvement.idOperation', [2, 3])
            ->groupBy('mouvement.idOperateur')
            ->findAll();

        return $gains; 
    }
/**
 * Effectue un envoi multiple en divisant le montant total entre plusieurs numéros
 * Strictement limité aux numéros du même opérateur
 */
    public function transfertMultiple() {
        // 1. Récupération des données du formulaire
        $montantTotal = (float) $this->request->getPost('montant_total');
        $sequencesBeneficiaires = $this->request->getPost('numeros'); // Saisi sous forme de tableau ou chaîne séparée par des virgules
    
        if (is_string($sequencesBeneficiaires)) {
            $sequencesBeneficiaires = array_filter(array_map('trim', explode(',', $sequencesBeneficiaires)));
        }

        $nbBeneficiaires = count($sequencesBeneficiaires);
        if ($nbBeneficiaires === 0 || $montantTotal <= 0) {
            return redirect()->back()->with('error', 'Données d\'envoi invalides.');
        }

        // 2. Identification de l'expéditeur et de son opérateur
        $idOperateurExpediteur = session()->get('id_operateur');
        // On suppose que le numéro connecté est stocké en session (ex: id_numero)
        $idExpediteur = session()->get('id_numero'); 

        // Calcul du montant net par bénéficiaire
        $montantUnitaireNet = $montantTotal / $nbBeneficiaires;

        // 3. Vérification des bénéficiaires (existence et même opérateur)
        $idBeneficiairesValides = [];
        foreach ($sequencesBeneficiaires as $sequence) {
            $beneficiaire = $this->numeroModel
                ->where('sequence', $sequence)
                ->first();

            if (!$beneficiaire) {
                return redirect()->back()->with('error', "Le numéro {$sequence} n'existe pas.");
            }

            if ((int)$beneficiaire['idOperateur'] !== (int)$idOperateurExpediteur) {
                return redirect()->back()->with('error', "Le numéro {$sequence} n'appartient pas au même opérateur.");
            }

            $idBeneficiairesValides[] = [
                'id' => $beneficiaire['id'],
                'sequence' => $sequence
            ];
        }

        // 4. Recherche du barème pour l'opération de transfert (idOperation = 3)
        // On cherche les frais correspondants au montant unitaire net envoyé
        $tranche = $this->baremeModel
            ->where('idOperateur', $idOperateurExpediteur)
            ->where('idOperation', 3)
            ->where('min <=', $montantUnitaireNet)
            ->where('max >=', $montantUnitaireNet)
            ->first();

        if (!$tranche) {
            return redirect()->back()->with('error', 'Aucun barème trouvé pour ce montant unitaire.');
        }

        $fraisUnitaires = (float) $tranche['frais'];
        $coutUnitaireTotal = $montantUnitaireNet + $fraisUnitaires;
        $debitTotalExpediteur = $coutUnitaireTotal * $nbBeneficiaires;

        // 5. Vérification du solde de l'expéditeur
        // (En utilisant ta logique existante basée sur la somme des mouvements passés)
        $soldeActuel = $this->getSoldeDuNumero($idExpediteur); 
        if ($soldeActuel < $debitTotalExpediteur) {
            return redirect()->back()->with('error', "Solde insuffisant. Il vous faut au total {$debitTotalExpediteur} Ar (frais inclus).");
        }

        // 6. Enregistrement des mouvements en Base de Données
        // Idéalement à mettre dans une transaction SQLite/MySQL pour éviter les coupures partielles
        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($idBeneficiairesValides as $benef) {
            // A. Ligne de Débit pour l'expéditeur (idOperation = 3)
            // On enregistre le montant brut (net + frais) comme convenu précédemment
            $this->mouvementModel->save([
                "idN1"          => $idExpediteur,
                "idN2"          => $benef['id'],
                "idOperateur"   => $idOperateurExpediteur,
                "idOperation"   => 3,
                "argent"        => $coutUnitaireTotal
            ]);

            // B. Ligne de Crédit pour le bénéficiaire (idOperation = 1)
            // On enregistre le montant net reçu (sans les frais)
            $this->mouvementModel->save([
                "idN1"          => $benef['id'],
                "idN2"          => $idExpediteur,
                "idOperateur"   => $idOperateurExpediteur, // Même opérateur validé plus haut
                "idOperation"   => 1,
                "argent"        => $montantUnitaireNet
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors du transfert multiple.');
        }

        return redirect()->to('/dashboard')->with('success', "Envoi multiple réussi ! Chaque numéro a reçu {$montantUnitaireNet} Ar.");
    }

    /**
    * Fonction interne d'aide pour récupérer le solde d'un numéro spécifique
    */
    private function getSoldeDuNumero($idNumero) {
        $mouvements = $this->mouvementModel->where('idN1', $idNumero)->findAll();
        $solde = 0;
        foreach ($mouvements as $m) {
            if (in_array($m['idOperation'], [2, 3])) {
                $solde -= $m['argent'];
            } else {
                $solde += $m['argent'];
            }
        }
        return $solde;
    }
}