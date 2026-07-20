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
}