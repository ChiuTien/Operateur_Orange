<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Bareme;
use App\Models\Prefixe;

class OperateurController extends BaseController {
    protected $bareme;
    protected $prefixe;

    public function __construct() {
        $this->bareme = new Bareme();
        $this->prefixe = new Prefixe();
    }

    public function getData() {
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
}
