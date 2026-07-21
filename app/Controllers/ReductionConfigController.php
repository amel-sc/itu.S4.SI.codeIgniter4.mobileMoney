<?php

namespace App\Controllers;

use App\Models\ReductionConfigModel;
use App\Models\OperateurModel;

class ReductionConfigController extends BaseController
{
    public function insert_form()
    {
        $reductionConfigModel = new ReductionConfigModel();

        $reduction = $reductionConfigModel->first();

        return view('reduction/form', [
            'title' => 'Modifier une reduction',
            'reduction' => $reduction
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

    public function update()
    {
        $reductionModel = new ReductionConfigModel();

        $data = [
            'pourcentage' => $this->request->getPost('pourcentage'),
        ];

        $reduction = $reductionModel->where('id', 1)->first();

        if ($reduction) {
            if (!$reductionModel->update(1, $data)) {
                return redirect()->back()->withInput()->with('errors', $reductionModel->errors());
            }
        } 

        else {
            $reductionModel->insert($data);
        }

        return redirect()->to('/reduction-config/edit-form/' . $id)->with('success', 'reduction modifiée avec succès.');
    }
}