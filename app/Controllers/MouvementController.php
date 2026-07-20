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
    }
}
