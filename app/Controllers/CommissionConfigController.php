<?php

namespace App\Controllers;

use App\Models\CommissionConfigModel;
use App\Models\OperateurModel;

class CommissionConfigController extends BaseController
{
    public function list()
    {
        $commissionModel = new CommissionConfigModel();

        return view('commission_config/list', [
            'title' => 'Configurations de commission',
            'commissions' => $commissionModel->findAllWithOperators()
        ]);
    }

    public function insert_form()
    {
        $operateurModel = new OperateurModel();

        return view('commission_config/form', [
            'title' => 'Ajouter une commission',
            'operateurs' => $operateurModel->findAllWithStatus()
        ]);
    }

    public function save()
    {
        $commissionModel = new CommissionConfigModel();

        $data = [
            'id_operateur' => $this->request->getPost('id_operateur'),
            'pourcentage' => $this->request->getPost('pourcentage'),
        ];

        if (! $commissionModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $commissionModel->errors());
        }

        return redirect()->to('/commission-config/insert-form')->with('success', 'Commission ajoutée avec succès.');
    }

    public function edit_form($id)
    {
        $commissionModel = new CommissionConfigModel();
        $operateurModel = new OperateurModel();

        return view('commission_config/form', [
            'title' => 'Modifier une commission',
            'commission' => $commissionModel->find($id),
            'operateurs' => $operateurModel->findAllWithStatus(),
        ]);
    }

    public function update($id)
    {
        $commissionModel = new CommissionConfigModel();

        $data = [
            'id_operateur' => $this->request->getPost('id_operateur'),
            'pourcentage' => $this->request->getPost('pourcentage'),
        ];

        if (! $commissionModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $commissionModel->errors());
        }

        return redirect()->to('/commission-config/edit-form/' . $id)->with('success', 'Commission modifiée avec succès.');
    }

    public function delete($id)
    {
        $commissionModel = new CommissionConfigModel();
        $commissionModel->delete($id);

        return redirect()->to('/commission-config');
    }
}