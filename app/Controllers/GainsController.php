<?php

namespace App\Controllers;

use App\Models\HistoriqueTransactionModel;
use App\Models\OperationTypeModel;

class GainsController extends BaseController
{
    public function index()
    {
        $historiqueModel = new HistoriqueTransactionModel();
        $operationTypeModel = new OperationTypeModel();

        // Récupérer les types d'opérations
        $operationTypes = $operationTypeModel->findAll();
        $typeMap = [];
        foreach ($operationTypes as $type) {
            $typeMap[$type['id']] = $type['libelle'];
        }

        // Récupérer toutes les transactions
        $transactions = $historiqueModel->findAll();

        // Calculer les gains par type d'opération (retrait = 2, transfert = 3)
        $totalRetrait = 0;
        $totalTransfert = 0;

        foreach ($transactions as $t) {
            if ($t['id_type_operation'] == 2) {
                $totalRetrait += $t['frais'];
            } elseif ($t['id_type_operation'] == 3) {
                $totalTransfert += $t['frais'];
            }
        }

        $totalGeneral = $totalRetrait + $totalTransfert;

        return view('gains/index', [
            'title' => 'Situation des gains',
            'totalRetrait' => $totalRetrait,
            'totalTransfert' => $totalTransfert,
            'totalGeneral' => $totalGeneral
        ]);
    }
}