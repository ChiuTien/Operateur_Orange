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

    public function deductionFrais($montant) {
        $ligne = $this->bareme->where("{$montant} BETWEEN min AND max")->first();
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

        $donnee = [
            "idN1" => $idNum,
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
        $montant = $data['montant'];

        $solde = $this->getSolde($idNum);
        $montant = $this->deductionFrais($montant);

        if($solde < $montant) {
            $necessaire = $montant - $solde;
            return redirect()->to('/accueil')->with('error', "Solde insuffisant. Il vous manque {$necessaire} Ar pour couvrir le retrait et ses frais.");
        } 

        $donnee = [
            "idN1" => $idNum,
            "idOperation" => 2,
            "argent" => $montant
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
        
        $idBeneficiaire = $beneficiaireData['id'];
        if (!$idBeneficiaire || $idExpediteur == $idBeneficiaire) {
            return redirect()->to('/accueil')->with('error', "Bénéficiaire invalide.{$idBeneficiaire}");
        }

        $montantAvecFrais = $this->deductionFrais($montantInitial);
        $solde = $this->getSolde($idExpediteur);

        if ($solde < $montantAvecFrais) {
            $necessaire = $montantAvecFrais - $solde;
            return redirect()->to('/accueil')->with('error', "Solde insuffisant. Il vous manque {$necessaire} Ar.");
        }

        $donneeExpediteur = [
            "idN1"        => $idExpediteur,
            "idN2"        => $idBeneficiaire, 
            "idOperation" => 3, 
            "argent"      => $montantAvecFrais
        ];
        $this->mouvement->save($donneeExpediteur);

        $donneeBeneficiaire = [
            "idN1"        => $idBeneficiaire,
            "idN2"        => $idExpediteur,
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
            case 'tout':
                default:
                break;
        }

    $listeMouvements = $query->orderBy('id', 'DESC')->findAll();

    return view('mouvements/historique_vue', [
        'mouvements'    => $listeMouvements,
        'filtreActuel'  => $filtre
    ]);
}
}