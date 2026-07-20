<?php

namespace App\Controllers;

use App\Controllers\MouvementController;

class Home extends BaseController
{
    protected $mouvementController;

    public function __construct()
    {
        $this->mouvementController = new MouvementController();
    }

    public function index(): string
    {
        return view('login');
    }

    public function operator() {
        return view('loginOperator');
    }

    public function main() {
        return view('loginMain');
    }

    public function accueil()
    {
        $idNum = session()->get('id_numero');

        if (!$idNum) {
            return redirect()->to('/')->with('error', 'Veuillez vous connectez');
        }

        $soldeData = $this->mouvementController->getSolde($idNum);        

        $data = [
            'solde' => $soldeData
        ];

        return view('accueil', $data);
    }
}
