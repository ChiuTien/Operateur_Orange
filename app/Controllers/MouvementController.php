<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Mouvement;

class MouvementController extends BaseController {
    protected $mouvement;

    public function __construct() {
        $this->mouvement = new Mouvement();
    }

    public function index() {
        //
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

        if($solde >= $montant) {
            $donnee = [
                "idN1" => $idNum,
                "idOperation" => 2,
                "argent" => $montant
            ];
            $this->mouvement->save($donnee);
        } else {
            //Asion erreur
        }
    }

    public function getSolde($idNum) {

        $mouvement = new Mouvement();

        $resultat = $mouvement->select("
            SUM(
                CASE 
                    WHEN idOperation IN (1, 2) THEN -argent
                    ELSE argent                              
                END
            ) AS solde
        ")->where('idN1', $idNum)->first();
        return $resultat['solde'] ?? 0;
    }
}
