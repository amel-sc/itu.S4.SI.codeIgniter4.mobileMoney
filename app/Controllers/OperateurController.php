<?php

namespace App\Controllers;

use App\Models\OperateurModel;
use App\Models\StatutOperateurModel;

class OperateurController extends BaseController
{
    public function list()
    {
        $operateurModel = new OperateurModel();

        return view('operateur/list', [
            'title' => 'Opérateurs',
            'operateurs' => $operateurModel->findAllWithStatus()
        ]);
    }

    public function insert_form()
    {
        $statutModel = new StatutOperateurModel();

        return view('operateur/form', [
            'title' => 'Ajouter un opérateur',
            'statuts' => $statutModel->findAllOrdered()
        ]);
    }

    public function save()
    {
        $operateurModel = new OperateurModel();

        $data = [
            'nom' => $this->request->getPost('nom'),
            'id_statut' => $this->request->getPost('id_statut'),
        ];

        if (! $operateurModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $operateurModel->errors());
        }

        return redirect()->to('/operateurs/insert-form')->with('success', 'Opérateur ajouté avec succès.');
    }

    public function edit_form($id)
    {
        $operateurModel = new OperateurModel();
        $statutModel = new StatutOperateurModel();

        return view('operateur/form', [
            'title' => 'Modifier un opérateur',
            'operateur' => $operateurModel->find($id),
            'statuts' => $statutModel->findAllOrdered(),
        ]);
    }

    public function update($id)
    {
        $operateurModel = new OperateurModel();

        $data = [
            'nom' => $this->request->getPost('nom'),
            'id_statut' => $this->request->getPost('id_statut'),
        ];

        if (! $operateurModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $operateurModel->errors());
        }

        return redirect()->to('/operateurs/edit-form/' . $id)->with('success', 'Opérateur modifié avec succès.');
    }

    public function delete($id)
    {
        $operateurModel = new OperateurModel();
        $operateurModel->delete($id);

        return redirect()->to('/operateurs');
    }
}