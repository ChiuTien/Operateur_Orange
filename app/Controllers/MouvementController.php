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

    public function retrait() {
        $mouvement = new Mouvement();
    }

    public function getSolde($idNumero) {
        $resultat = $model->select("
            SUM(
                CASE 
                    WHEN idOperation IN (1, 2) THEN -argent
                    ELSE argent                              
                END
            ) AS solde_total
        ")->where('idN1', $numeroN1)->first();
    }
}
