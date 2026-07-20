<?php

namespace App\Controllers;
use App\Models\PrefixConfigModel;
use App\Models\OperateurModel;

class PrefixConfigController extends BaseController {


    public function list() {
        $prefixConfigModel = new PrefixConfigModel();
        $prefixes = $prefixConfigModel->findAllWithOperators();

        return view('prefix/list', [
            'title' => 'Préfixes',
            'prefixes' => $prefixes
        ]);
    }

    public function insert_form() {
        $operateurModel = new OperateurModel();

        return view('prefix/form', [
            'title' => 'Ajouter un préfixe',
            'operateurs' => $operateurModel->findAllWithStatus()
        ]);
    }

    public function save() {
        $prefixConfigModel = new PrefixConfigModel();
        $data = [
            'value' => $this->request->getPost('value'),
            'id_operateur' => $this->request->getPost('id_operateur')
        ];
        if (!$prefixConfigModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $prefixConfigModel->errors());
        }
        return redirect()->to('/prefix/insert-form')->with('success', 'Préfixe ajouté avec succès.');
    }

    public function edit_form($id) {
        $prefixConfigModel = new PrefixConfigModel();
        $operateurModel = new OperateurModel();
        $prefix = $prefixConfigModel->find($id);

        return view('prefix/form', [
            'title' => 'Modifier un préfixe',
            'prefix' => $prefix,
            'operateurs' => $operateurModel->findAllWithStatus()
        ]);
    }

    public function update($id) {
        $prefixConfigModel = new PrefixConfigModel();
        $data = [
            'value' => $this->request->getPost('value'),
            'id_operateur' => $this->request->getPost('id_operateur')
        ];
        if (!$prefixConfigModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $prefixConfigModel->errors());
        }
        return redirect()->to('/prefix/edit-form/' . $id)->with('success', 'Préfixe modifié avec succès.');
    }

    public function delete($id) {
        $prefixConfigModel = new PrefixConfigModel();
        $prefixConfigModel->delete($id);
        return redirect()->to('/prefix');
    }

}