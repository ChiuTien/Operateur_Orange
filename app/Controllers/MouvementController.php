<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Mouvement;
use App\Models\Bareme;

class MouvementController extends BaseController {
    protected $mouvement;
    protected $bareme;

    public function __construct() {
        $this->mouvement = new Mouvement();
        $this->bareme = new Bareme();
    }

    //Sous-Methodes
    public function getDataDepotRetrait() {
        $idNum = session()->get('id_numero');
        $montant = $this->request->getPost('montant');

        if (!$idNum) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }
        if (!$montant || $montant <= 0) {
            return redirect()->to('/accueil')->with('error', 'Veuillez insérer un montant valide.');
        }

        $data = [
            "idNum" => $idNum,
            "montant" => $montant
        ];
        return $data;
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

    //Methodes principaux
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
}
