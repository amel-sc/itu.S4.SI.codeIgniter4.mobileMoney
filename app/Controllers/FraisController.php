<?php

namespace App\Controllers;
use App\Models\MontantFraisModel;
use App\Models\OperationTypeModel;

class FraisController extends BaseController {


    public function list() {
        $montantFraisModel = new MontantFraisModel();
        $operationTypeModel = new OperationTypeModel();
        $frais = $montantFraisModel->findAll();
        $operationTypes = $operationTypeModel->findAll();
        $fraisWithType = $this->addType($frais, $operationTypes);

        return view('frais/list', [
            'title' => 'Frais',
            'frais' => $fraisWithType
        ]);
    }

    public function addType($frais , $operationType) {
        $fraisWithType = [];
        foreach ($frais as $f) {
            $type = array_filter($operationType, function($t) use ($f) {
                return $t['id'] === $f['id_operation_type'];
            });
            $type = reset($type);
            $fraisWithType[] = [
                'id' => $f['id'],
                'operation_type' => $type ? $type['libelle'] : null,
                'montant1' => $f['montant1'],
                'montant2' => $f['montant2'],
                'frais' => $f['frais']
            ];
        }
        return $fraisWithType;
    }


    public function insert_form() {
        $operationTypeModel = new OperationTypeModel();
        $operationTypes = $operationTypeModel->findAll();

        return view('frais/form', [
            'title' => 'Ajouter un montant de frais',
            'operationTypes' => $operationTypes
        ]);
    }

    public function save() {
        $montantFraisModel = new MontantFraisModel();
        $data = [
            'id_operation_type' => $this->request->getPost('id_operation_type'),
            'montant1' => $this->request->getPost('montant1'),
            'montant2' => $this->request->getPost('montant2'),
            'frais' => $this->request->getPost('frais')
        ];
        if (!$montantFraisModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $montantFraisModel->errors());
        }
        return redirect()->to('/frais/insert-form')->with('success', 'Montant de frais ajouté avec succès.');
    }

    public function edit_form($id) {
        $montantFraisModel = new MontantFraisModel();
        $operationTypeModel = new OperationTypeModel();
        $frais = $montantFraisModel->find($id);
        $operationTypes = $operationTypeModel->findAll();

        return view('frais/form', [
            'title' => 'Modifier un montant de frais',
            'frais' => $frais,
            'operationTypes' => $operationTypes
        ]);
    }

    public function update($id) {
        $montantFraisModel = new MontantFraisModel();
        $data = [
            'id_operation_type' => $this->request->getPost('id_operation_type'),
            'montant1' => $this->request->getPost('montant1'),
            'montant2' => $this->request->getPost('montant2'),
            'frais' => $this->request->getPost('frais')
        ];
        if (!$montantFraisModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $montantFraisModel->errors());
        }
        return redirect()->to('/frais/edit-form/' . $id)->with('success', 'Montant de frais modifié avec succès.');
    }

    public function delete($id) {
        $montantFraisModel = new MontantFraisModel();
        $montantFraisModel->delete($id);
        return redirect()->to('/frais');
    }

}