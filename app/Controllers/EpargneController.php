<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Epargne;
class EpargneController extends BaseController
{
    public function index() {
        $epargne = new Epargne();
        $idNum = session()->get('id_numero');
        $epargne = $epargne->where('idN',$idNum);

        return view('epargne/ajout',['epa'=>$epargne]);
    }

    public function ajout() {
        $idNum = session()->get('id_numero');
        $taux = $this->request->getPost('taux');

        $data = [
            'idN' => $idNum,
            'taux' => $taux
        ];

        $epargne = new Epargne();

        $epargne->save($data);
        return redirect()->to('/accueil');
    }
}
