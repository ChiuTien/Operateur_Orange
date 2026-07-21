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

    // Constructeur pour instancier les modèles une seule fois
    public function __construct() {
        $this->numeroModel    = new Numero();
        $this->operateurModel = new Operateur();
        $this->prefixModel    = new Prefix();
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
            
            // 1. On prend le numéro envoyer et on le scinde pour récupérer les 3 premiers chiffres (le préfixe)
            $prefixeSaisi = substr($numSaisi, 0, 3);

            // 2. Recherche du préfixe dans la base pour savoir de quelle opérateur il s'agit
            $prefixeInfo = $this->prefixModel->where('sequence', $prefixeSaisi)->first();

            $idOperateur = $prefixeInfo ? $prefixeInfo['idOperateur'] : null;

            // 3. Stockage des informations dans la session courante
            $sessionData = [
                'id_numero'    => $numeroExist['id'],
                'sequence'     => $numeroExist['sequence'],
                'id_operateur' => $idOperateur, // Stocke l'ID de l'opérateur identifié via les 3 premiers chiffres
                'prefixe'      => $prefixeSaisi, // Stocke la séquence de 3 chiffres
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

        // Récupération des données saisies dans le formulaire HTML
        $nomSaisi = $this->request->getPost('nom');
        $mdpSaisi = $this->request->getPost('mdp');

        // Recherche de l'opérateur dans la base de données via le modèle injecté
        $operateurExist = $this->operateurModel->where('nom', $nomSaisi)
                                                ->where('mdp', $mdpSaisi)
                                                ->first();

        if ($operateurExist) {
            
            $sessionData = [
                'id_operateur'  => $operateurExist['id'],
                'nom_operateur' => $operateurExist['nom'],
                'isOpeLoggedIn' => true,
            ];
            
            $session->set($sessionData);

            return redirect()->to('/operation'); 
        } else {
            $session->setFlashdata('error', 'Nom ou mot de passe incorrect.');
            return redirect()->to('/loginOperator');
        }
    }
}