<?php

namespace App\Controllers;

use App\Models\CommissionConfigModel;
use App\Models\HistoriqueTransactionModel;
use App\Models\OperationTypeModel;
use App\Models\PrefixConfigModel;

class GainsController extends BaseController
{
    public function index()
    {
        $historiqueModel = new HistoriqueTransactionModel();
        $operationTypeModel = new OperationTypeModel();
        $prefixConfigModel = new PrefixConfigModel();
        $commissionConfigModel = new CommissionConfigModel();

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
        $totalCommission = 0;
        $detailsOperateurs = [];

        foreach ($transactions as $t) {
            if ($t['id_type_operation'] == 2) {
                $totalRetrait += $t['frais'];
            } elseif ($t['id_type_operation'] == 3) {
                $totalTransfert += $t['frais'];

                $operatorInfo = $prefixConfigModel->findOperatorByNumero((string) ($t['numero_receiver'] ?? ''));

                if ($operatorInfo) {
                    $operatorId = (int) ($operatorInfo['id_operateur'] ?? 0);
                    $operatorNom = $operatorInfo['operateur_nom'] ?? 'Opérateur inconnu';
                    $statutOperateur = $operatorInfo['statut_operateur'] ?? 'Inconnu';
                    $commissionConfig = $commissionConfigModel->findByOperateurId($operatorId);
                    $commission = (float) ($t['commission'] ?? 0);

                    if (!isset($detailsOperateurs[$operatorId])) {
                        $detailsOperateurs[$operatorId] = [
                            'id' => $operatorId,
                            'nom' => $operatorNom,
                            'statut' => $statutOperateur,
                            'montant_total' => 0,
                            'commission_total' => 0,
                            'transactions' => 0,
                            'pourcentage' => (float) ($commissionConfig['pourcentage'] ?? 0)
                        ];
                    }

                    $detailsOperateurs[$operatorId]['montant_total'] += (float) $t['montant'];
                    $detailsOperateurs[$operatorId]['commission_total'] += $commission;
                    $detailsOperateurs[$operatorId]['transactions']++;
                    $totalCommission += $commission;
                }
            }
        }

        $totalGeneral = $totalRetrait + $totalTransfert + $totalCommission;

        return view('gains/index', [
            'title' => 'Situation des gains',
            'totalRetrait' => $totalRetrait,
            'totalTransfert' => $totalTransfert,
            'totalCommission' => $totalCommission,
            'totalGeneral' => $totalGeneral,
            'detailsOperateurs' => array_values($detailsOperateurs)
        ]);
    }
}