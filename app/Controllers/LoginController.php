<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Numero;

class LoginController extends BaseController
{
    public function auth() {
        $session = session();
        $model = new Numero();

        $numSaisi = $this->request->getPost('numero');

        $numeroExist = $model->findBySequence($numSaisi);

        if ($numeroExist) {
            
            $sessionData = [
                'id_numero'=> $numeroExist['id'],
                'sequence'=> $numeroExist['sequence'],
                'isLoggedIn'=> true,
            ];
            $session->set($sessionData);

            return redirect()->to('/accueil');
        } else {
            $session->setFlashdata('error', 'Désolé, ce numéro n\'existe pas.');
            return redirect()->to('/');
        }
    }

}

?>
