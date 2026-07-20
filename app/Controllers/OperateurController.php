<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Bareme;
use App\Models\Prefix;

class OperateurController extends BaseController {
    protected $bareme;
    protected $prefixe;

    public function __construct() {
        $this->bareme = new Bareme();
        $this->prefixe = new Prefix();
    }

    /* 
        GESTION DES BAREMES
    */
    public function getBaremeData() {
        $donnees = [
            'min'         => $this->request->getPost('min'),
            'max'         => $this->request->getPost('max'),
            'frais'       => $this->request->getPost('frais'),
            'idOperation' => $this->request->getPost('idOperation'),
            'idOperateur' => $this->request->getPost('idOperateur'),
        ];

        if (!is_numeric($donnees['min']) || !is_numeric($donnees['max']) || !is_numeric($donnees['frais'])) {
            return redirect()->back()->with('error', 'Veuillez remplir tous les champs numériques avec des valeurs valides.');
        }
        if ($donnees['min'] > $donnees['max']) {
            return redirect()->back()->with('error', 'Le montant minimum ne peut pas être supérieur au maximum.');
        }

        return $donnees;
    }

    public function getBareme() {
        $idOperateur = $this->request->getVar('idOperateur');
        $idOperation = $this->request->getVar('idOperation');

        if (!$idOperateur || !$idOperation) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Veuillez fournir idOperateur et idOperation.'
            ])->setStatusCode(400);
        }

        $listeBaremes = $this->bareme->where('idOperateur', $idOperateur)
                                     ->where('idOperation', $idOperation)
                                     ->orderBy('min', 'ASC')
                                     ->findAll();
        return $listeBaremes;
    }

    public function create() {
        $donnees = $this->getData();

        if (!is_array($donnees)) {
            return $donnees;
        }

        $this->bareme->save($donnees);
        return redirect()->back()->with('success', 'Tranche de barème ajoutée avec succès !');
    }

    public function update($id) {
        $tranche = $this->bareme->find($id);
        if (!$tranche) {
            return redirect()->back()->with('error', 'Cette tranche de barème n\'existe pas.');
        }

        $donnees = $this->getData();
        if (!is_array($donnees)) {
            return $donnees;
        }

        $donnees['id'] = $id;

        $this->bareme->save($donnees);
        return redirect()->back()->with('success', 'Tranche mise à jour avec succès.');
    }

    public function delete($id) {
        $tranche = $this->bareme->find($id);
        
        if (!$tranche) {
            return redirect()->back()->with('error', 'Cette tranche n\'existe pas.');
        }

        $this->bareme->delete($id);
        return redirect()->back()->with('success', 'Tranche supprimée avec succès.');
    }

    /* 
        GESTION DES PREFIXES
    */
    
    // 1. La fonction pour afficher la liste réarrangée
    public function listPrefixe() {
        $idOperateur = session()->get('id_operateur');
        
        if (!$idOperateur) {
            return redirect()->to('/loginOperator')->with('error', 'Veuillez vous connecter.');
        }

        // Récupère dynamiquement les préfixes appartenant à cet opérateur
        $listePrefixes = $this->prefixe->where('idOperateur', $idOperateur)->findAll();

        return view('operator/listPrefixe', ['prefixes' => $listePrefixes]);
    }

    public function getPrefixData() {
        $donnees = [
            'sequence'    => trim($this->request->getPost('sequence')),
            'idOperateur' => session()->get('id_operateur') // Sécurisé via la session directe
        ];

        if (empty($donnees['sequence']) || empty($donnees['idOperateur'])) {
            return redirect()->back()->with('error', 'La séquence du préfixe est requise.');
        }

        return $donnees;
    }

    public function createPrefixe() {
        $donnees = $this->getPrefixData();

        if (!is_array($donnees)) {
            return $donnees;
        }

        $existe = $this->prefixe->where('sequence', $donnees['sequence'])->first();
        if ($existe) {
            return redirect()->back()->with('error', 'Ce préfixe existe déjà.');
        }

        $this->prefixe->save($donnees);
        return redirect()->back()->with('success', 'Préfixe ajouté avec succès !');
    }

    public function updatePrefixe($id) {
        $prefixe = $this->prefixe->find($id);
        if (!$prefixe) {
            return redirect()->back()->with('error', 'Ce préfixe n\'existe pas.');
        }

        $donnees = $this->getPrefixData();
        if (!is_array($donnees)) {
            return $donnees;
        }

        $existe = $this->prefixe->where('sequence', $donnees['sequence'])
                                ->where('id !=', $id)
                                ->first();
        if ($existe) {
            return redirect()->back()->with('error', 'Ce préfixe est déjà utilisé par un autre opérateur.');
        }

        $donnees['id'] = $id;

        $this->prefixe->save($donnees);
        return redirect()->back()->with('success', 'Préfixe mis à jour avec succès.');
    }

    public function deletePrefixe($id) {
        $prefixe = $this->prefixe->find($id);

        if (!$prefixe) {
            return redirect()->back()->with('error', 'Ce préfixe n\'existe pas.');
        }

        $this->prefixe->delete($id);
        return redirect()->back()->with('success', 'Préfixe supprimé avec succès.');
    }

    /*
        GESTION DES CLIENTS
    */
    public function listeComptesEtSoldes() {
        $listeComptes = $this->numeroModel
            ->select("
                numero.id, 
                numero.sequence AS numero_telephone,
                numero.idOperateur,
                COALESCE(
                    SUM(
                        CASE 
                            WHEN mouvement.idOperation IN (2, 3) THEN -mouvement.argent
                            ELSE mouvement.argent                              
                        END
                    ), 0
                ) AS solde_actuel
            ")
            ->join('mouvement', 'mouvement.idN1 = numero.id', 'left')
            ->groupBy('numero.id')
            ->orderBy('numero.sequence', 'ASC')
            ->findAll();

        return view('admin/comptes_vue', [
            'comptes' => $listeComptes
        ]);
    }
}
