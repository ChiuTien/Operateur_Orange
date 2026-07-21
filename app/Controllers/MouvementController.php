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
    protected $loginController; 

    public function __construct() {
        $this->mouvement = new Mouvement();
        $this->bareme = new Bareme();
        $this->numeroModel = new Numero();
        $this->loginController = new LoginController();
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

    if (!$ligne) {
        return $montant;
    }

    // Récupération du frais fixe et du pourcentage (par défaut 0 si non présent)
    $fraisFixe   = floatval($ligne['frais'] ?? 0);
    $pourcentage = floatval($ligne['pourcentage'] ?? 0);

    // Calcul de la commission en pourcentage
    $fraisPourcentage = $montant * ($pourcentage / 100);

    // Retourne le montant total avec les frais accumulés
    return $montant + $fraisFixe + $fraisPourcentage;
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
        
        $session = session();
        $idExpediteur = $session->get('id_numero');
        $idOperateurConnecte = $session->get('id_operateur');

        // Récupération des deux tableaux transmis par le formulaire de transfert
        $beneficiaires = $this->request->getPost('beneficiaires'); // Liste des numéros
        $montants      = $this->request->getPost('montants');      // Liste des montants correspondants

        if (empty($beneficiaires) || empty($montants)) {
            return redirect()->to('/accueil')->with('error', 'Veuillez renseigner au moins un bénéficiaire et un montant.');
        }

        // -------------------------------------------------------------
        // ÉTAPE 1 : VÉRIFICATIONS ET PRÉ-CALCULS DE SÉCURITÉ
        // -------------------------------------------------------------
        $montantTotalFraisInclus = 0;
        $donneesAExecuter = [];

        foreach ($beneficiaires as $index => $numSaisi) {
            $numClean = trim($numSaisi);
            $montant  = floatval($montants[$index]);

            if ($montant <= 0) {
                return redirect()->to('/accueil')->with('error', "Le montant pour le numéro {$numClean} doit être supérieur à 0.");
            }

            /*
                Vérification si le numéro du bénéficiaire est du même opérateur que le client connecté
                Utilisation de l'attribut de classe $this->loginController (instancié dans __construct)
            */
            $opeBeneficiaire = $this->loginController->getOperateurByNumero($numClean);

            if ($opeBeneficiaire === null || $opeBeneficiaire != $idOperateurConnecte) {
                return redirect()->to('/accueil')->with('error', "Le numéro {$numClean} n'appartient pas à votre opérateur.");
            }

            // Recherche en BDD pour récupérer les infos du bénéficiaire
            $beneficiaireData = $this->numeroModel->findBySequence($numClean);
            if (!$beneficiaireData) {
                return redirect()->to('/accueil')->with('error', "Bénéficiaire {$numClean} introuvable.");
            }

            $idBeneficiaire = $beneficiaireData['id'];
            if ($idExpediteur == $idBeneficiaire) {
                return redirect()->to('/accueil')->with('error', "Vous ne pouvez pas vous envoyer de l'argent à vous-même.");
            }

            // Calcul du montant avec frais retenus pour ce transfert spécifique (opération id 3)
            $montantAvecFrais = $this->deductionFrais($montant, 3);
            $montantTotalFraisInclus += $montantAvecFrais;

            // Préparation des données pour l'enregistrement
            $donneesAExecuter[] = [
                'idBeneficiaire'    => $idBeneficiaire,
                'idOperateurBen'    => $opeBeneficiaire,
                'montantInitial'    => $montant,
                'montantAvecFrais' => $montantAvecFrais
            ];
        }

        // -------------------------------------------------------------
        // ÉTAPE 2 : VÉRIFICATION DU SOLDE GLOBAL DE L'EXPÉDITEUR
        // -------------------------------------------------------------
        $soldeActuel = $this->getSolde($idExpediteur);

        if ($soldeActuel < $montantTotalFraisInclus) {
            $necessaire = $montantTotalFraisInclus - $soldeActuel;
            return redirect()->to('/accueil')->with('error', "Solde insuffisant pour effectuer l'ensemble des transferts. Il vous manque {$necessaire} Ar.");
        }

        // -------------------------------------------------------------
        // ÉTAPE 3 : EXÉCUTION DE TOUS LES TRANSFERTS DANS LA BDD
        // -------------------------------------------------------------
        foreach ($donneesAExecuter as $transfert) {
            // Enregistrement du débit de l'expéditeur
            $donneeExpediteur = [
                "idN1"        => $idExpediteur,
                "idN2"        => $transfert['idBeneficiaire'], 
                "idOperateur" => $idOperateurConnecte,
                "idOperation" => 3, 
                "argent"      => $transfert['montantAvecFrais']
            ];
            $this->mouvement->save($donneeExpediteur);

            // Enregistrement du crédit du bénéficiaire
            $donneeBeneficiaire = [
                "idN1"        => $transfert['idBeneficiaire'],
                "idN2"        => $idExpediteur,
                "idOperateur" => $transfert['idOperateurBen'],
                "idOperation" => 1, 
                "argent"      => $transfert['montantInitial']
            ];
            $this->mouvement->save($donneeBeneficiaire);
        }

        return redirect()->to("/accueil")->with('success', 'Tous vos transferts ont été envoyés avec succès !');
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
    /*
        SITUTATION GAINS
    */
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