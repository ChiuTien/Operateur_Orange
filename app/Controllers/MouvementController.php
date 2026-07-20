<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Mouvement;

class MouvementController extends BaseController {
    public function index() {
        //
    }

    public function deposer()
    {
        // 1. On récupère l'idNum caché dans la session actuelle
        $idNum = session()->get('id_numero');

        // 2. On récupère le montant tapé par l'utilisateur dans le formulaire
        $montant = $this->request->getPost('montant');

        // 3. Sécurité : On vérifie si l'utilisateur est bien connecté et a mis un montant
        if (!$idNum) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        if (!$montant || $montant <= 0) {
            return redirect()->to('/accueil')->with('error', 'Veuillez insérer un montant valide.');
        }

        // 4. On appelle la fonction "depot" que ton ami a créée
        // (Si sa fonction est dans ce même contrôleur, on utilise $this->depot)
        return $this->depot($idNum, $montant);
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
