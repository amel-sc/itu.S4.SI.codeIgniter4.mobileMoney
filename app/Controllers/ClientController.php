<?php

namespace App\Controllers;

use App\Models\HistoriqueTransactionModel;
use App\Models\OperationTypeModel;
use App\Models\UtilisateurModel;

class ClientController extends BaseController
{
    public function dashboard()
    {
        $user = session()->get('user');

        $utilisateurModel = new UtilisateurModel();
        $freshUser = $user ? $utilisateurModel->find($user['id']) : null;
        if ($freshUser) {
            session()->set('user', $freshUser);
            $user = $freshUser;
        }

        return view('client/dashboard', [
            'title' => 'Mon espace',
            'user' => $user
        ]);
    }

    public function historique()
    {
        $user = session()->get('user');
        $historiqueModel = new HistoriqueTransactionModel();
        $operationTypeModel = new OperationTypeModel();

        $operationTypes = $operationTypeModel->findAll();
        $typeMap = [];
        foreach ($operationTypes as $type) {
            $typeMap[$type['id']] = $type['libelle'];
        }

        $transactions = $historiqueModel
            ->where('numero_sender', $user['numero'])
            ->orWhere('numero_receiver', $user['numero'])
            ->orderBy('date_transaction', 'DESC')
            ->findAll();

        return view('client/historique', [
            'title' => 'Mes opérations',
            'transactions' => $transactions,
            'typeMap' => $typeMap,
            'user' => $user
        ]);
    }
}