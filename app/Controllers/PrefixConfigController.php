<?php

namespace App\Controllers;
use App\Models\PrefixConfigModel;

class PrefixConfigController extends BaseController {


    public function list() {
        $prefixConfigModel = new PrefixConfigModel();
        $prefixes = $prefixConfigModel->findAll();

        return view('prefix/list', [
            'title' => 'Préfixes',
            'prefixes' => $prefixes
        ]);
    }

    public function insert_form() {
        return view('prefix/form', [
            'title' => 'Ajouter un préfixe'
        ]);
    }

    public function save() {
        $prefixConfigModel = new PrefixConfigModel();
        $data = [
            'value' => $this->request->getPost('value')
        ];
        if (!$prefixConfigModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $prefixConfigModel->errors());
        }
        return redirect()->to('/prefix/insert-form')->with('success', 'Préfixe ajouté avec succès.');
    }

    public function edit_form($id) {
        $prefixConfigModel = new PrefixConfigModel();
        $prefix = $prefixConfigModel->find($id);

        return view('prefix/form', [
            'title' => 'Modifier un préfixe',
            'prefix' => $prefix
        ]);
    }

    public function update($id) {
        $prefixConfigModel = new PrefixConfigModel();
        $data = [
            'value' => $this->request->getPost('value')
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