<?php

namespace App\Controllers;

use App\Models\HistoriqueTransactionModel;
use App\Models\OperationTypeModel;

class HistoriqueController extends BaseController
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

        // Récupérer toutes les transactions, triées par date décroissante
        $transactions = $historiqueModel->orderBy('date_transaction', 'DESC')->findAll();

        return view('historique/index', [
            'title' => 'Historique des opérations',
            'transactions' => $transactions,
            'typeMap' => $typeMap
        ]);
    }
}