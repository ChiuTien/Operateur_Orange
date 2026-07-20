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

    public function client(): string
    {
        return view('login');
    }

    public function index() {
        return view('loginMain');
    }

    public function operator() {
        return view('loginOperator');
    }

    public function main() {
        return view('loginMain');
    }

    public function listOperation() {
        return view('operator/listOperation');
    }

    public function listPrefixe() {
        return view('operator/listPrefixe');
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
