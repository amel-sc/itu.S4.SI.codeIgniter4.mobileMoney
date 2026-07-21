<?php

namespace App\Controllers;

use App\Models\EpargneModel;
use App\Models\OperateurModel;

class EpargneController extends BaseController
{
    public function edit_form($id)
    {
        $epargneModel = new EpargneModel();
        $user = session()->get('user');
        return view('epargne/form', [
            'title' => 'Modifier  epargne',
            'epargne' => $epargneModel->where('id_client' , $user['id'])->first()
        ]);
    }

    public function update($id)
    {
        $epargneModel = new EpargneModel();

        $data = [
            'id_client' => $this->request->getPost('id_client'),
            'pourcentage' => $this->request->getPost('pourcentage'),
            'solde' => $this->request->getPost('solde'),
        ];

        if (! $epargneModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $epargneModel->errors());
        }

        return redirect()->to('/client/epargne/edit-form/' . $id)->with('success', 'Commission modifiée avec succès.');
    }

}