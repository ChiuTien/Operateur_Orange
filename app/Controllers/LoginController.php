<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Numero;
use App\Models\Operateur;

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


    public function authOpe() {
        // 2. Initialisation de la session et du modèle Operateur
        $session = session();
        $model = new Operateur();

        // 3. Récupération des données saisies dans le formulaire HTML
        $nomSaisi = $this->request->getPost('nom');
        $mdpSaisi = $this->request->getPost('mdp');

        // 4. Recherche de l'opérateur dans la base de données
        $operateurExist = $model->where('nom', $nomSaisi)
                                ->where('mdp', $mdpSaisi)
                                ->first();

        // 5. Vérification si l'opérateur existe
        if ($operateurExist) {
            
            // 6. Préparation des données à sauvegarder en session
            $sessionData = [
                'id_operateur' => $operateurExist['id'],   // On stocke l'ID de l'opérateur ici
                'nom_operateur'=> $operateurExist['nom'],  // Optionnel : stocker le nom pour l'affichage
                'isOpeLoggedIn'=> true,
            ];
            
            // 7. Enregistrement des données dans la session courante
            $session->set($sessionData);

            // Redirection vers le tableau de bord ou l'adresse souhaitée
            return redirect()->to('/operator/listOperation'); 
        } else {
            // 8. Gestion de l'erreur si les identifiants sont incorrects
            $session->setFlashdata('error', 'Nom ou mot de passe incorrect.');
            return redirect()->to('/loginOperator'); // Remplace par l'URL de ta page de login opérateur
        }
    }
}

?>
