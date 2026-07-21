<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Numero;
use App\Models\Operateur;
use App\Models\Prefix;

class LoginController extends BaseController
{
    protected $numeroModel;
    protected $operateurModel;
    protected $prefixModel;

    public function __construct() {
        $this->numeroModel    = new Numero();
        $this->operateurModel = new Operateur();
        $this->prefixModel    = new Prefix();
    }

    /*
        c'est de façon à ce que , lorsque l'user tape un montant , et il clique sur valider l'envoi , 
        la requête est vérifié si le numero du beneficiaire est du même operateur que le client connecté , 
        la strate je pense toujours au fait de scinder le numéro du beneficiaire , 
        je pense qu'en devrait faire une fonction dans loginController et l'appeler n'importe où tu crois pas
    */
    public function getOperateurByNumero($numero) {
        // La strate : scinder le numéro pour extraire les 3 premiers chiffres
        $prefixe = substr(trim($numero), 0, 3);
        
        // Recherche dans le modèle des préfixes
        $prefixeInfo = $this->prefixModel->where('sequence', $prefixe)->first();

        // Renvoie l'ID de l'opérateur s'il existe, sinon null
        return $prefixeInfo ? $prefixeInfo['idOperateur'] : null;
    }

    public function logout() {
        $session = session();
        $session->destroy();

        return redirect()->to('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    public function auth() {
        $session = session();
        $numSaisi = $this->request->getPost('numero');

        $numeroExist = $this->numeroModel->findBySequence($numSaisi);

        if ($numeroExist) {
            
            // Notre prochaine quête sera ceci , Envoi multiple vers plusieurs numéros ( divisé le montant pour chaque numéro)
            // même opérateur uniquement , mais pour mener à bien notre périple , je veux d'abord qu'à la connexion , on prend le numéro envoyer , on le scinde , on prend les 3 premiers chiffres pour savoir de quelle opérateur il s'agit .
            
            $idOperateur = $this->getOperateurByNumero($numSaisi);

            $sessionData = [
                'id_numero'    => $numeroExist['id'],
                'sequence'     => $numeroExist['sequence'],
                'id_operateur' => $idOperateur,
                'prefixe'      => substr($numSaisi, 0, 3),
                'isLoggedIn'   => true,
            ];
            $session->set($sessionData);

            return redirect()->to('/accueil');
        } else {
            $session->setFlashdata('error', 'Désolé, ce numéro n\'existe pas.');
            return redirect()->to('/');
        }
    }

    public function authOpe() {
        $session = session();

        $nomSaisi = $this->request->getPost('nom');
        $mdpSaisi = $this->request->getPost('mdp');

        $operateurExist = $this->operateurModel->where('nom', $nomSaisi)
                                                ->where('mdp', $mdpSaisi)
                                                ->first();

        if (!$operateurExist) {

            $session->setFlashdata('error', 'Nom ou mot de passe incorrect.');
            return redirect()->to('/operator');
        } 

        $sessionData = [
            'id_operateur'  => $operateurExist['id'],
            'nom_operateur' => $operateurExist['nom'],
            'isOpeLoggedIn' => true,
        ];
            
        $session->set($sessionData);
        return redirect()->to('/bareme'); 
    }
}