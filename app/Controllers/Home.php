<?php

namespace App\Controllers;

use App\Controllers\MouvementController;

class Home extends BaseController
{
    protected $mouvementController;

    public function index(): string
    {
        return view('login');
    }

    public function accueil(): string
    {
        $idNum = session()->get('id_numero');

        if (!$idNUm) {
            return redirect()->to('/')->with('error', 'Veuillez vous connectez');
        }

        $soldeData = $this->mouvementController->getSolde($idNum);        
        $soldeActuel = $soldeData['solde'] ?? 0; 

        $data = [
            'solde' => $soldeActuel
        ];

        return view('accueil', $data);
    }
}
