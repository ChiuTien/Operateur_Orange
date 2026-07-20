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

    public function index() {
        //
    }

    public function deductionFrais($montant) {
        $ligne = $this->bareme->where("{$montant} BETWEEN min AND max")->first();
        $frais = $ligne['frais'] ?? 0;
        return $montant + $frais;
    }

    public function depot() {
        $idNum = session()->get('id_numero');
        $montant = $this->request->getPost('montant');

        if (!$idNum) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }
        if (!$montant || $montant <= 0) {
            return redirect()->to('/accueil')->with('error', 'Veuillez insérer un montant valide.');
        }

        $donnee = [
            "idN1" => $idNum,
            "idOperation" => 1,
            "argent" => $montant
        ];

        $this->mouvement->save($donnee);

        return redirect()->to("/accueil");
    }

    public function retrait() {
        $idNum = session()->get('id_numero');
        $montant = $this->request->getPost('montant');

        $solde = $this->getSolde($idNum);

        $montant = $this->deductionFrais($montant);

        if($solde < $montant) {
            $necessaire = $montant - $solde;
            //Message d'erreur + retour
        } 

        $donnee = [
            "idN1" => $idNum,
            "idOperation" => 2,
            "argent" => $montant
        ];
        $this->mouvement->save($donnee);
        return redirect()->to("/accueil");
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
}
