<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Mouvement;

class MouvementController extends BaseController {
    public function index() {
        //
    }

    public function depot($idNum, $montant) {
        $mouvement = new Mouvement();

        $donnee = [
            "idN1" => $idNum,
            "idOperation" => 1,
            "argent" => $montant
        ];

        $mouvement->save($donnee);

        return redirect()->to("/accueil");
    }

    public function retrait($idNum, $montant) {
        $mouvement = new Mouvement();

        $soldeData = $this->getSolde($idNum);
        $solde = $soldeData['solde'] ?? 0.0;

        if($solde >= $montant) {
            $donnee = [
                "idN1" => $idNum,
                "idOperation" => 2,
                "argent" => $montant
            ];
        }
    }

    public function getSolde($idNum) {
        $resultat = $model->select("
            SUM(
                CASE 
                    WHEN idOperation IN (1, 2) THEN -argent
                    ELSE argent                              
                END
            ) AS solde
        ")->where('idN1', $idNum)->first();
        return $resultat;
    }
}
