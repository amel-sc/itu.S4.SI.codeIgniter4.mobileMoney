<?php
namespace App\Controllers;
use App\Models\HistoriqueTransactionModel;
use App\Models\CommissionConfigModel;
use App\Models\PrefixConfigModel;
use App\Models\OperationTypeModel;
use App\Models\UtilisateurModel;
use App\Models\MontantFraisModel;

class TransactionController extends BaseController{    
    // function to get form for transaction
    public function form() {        
        $operationTypeModel = new OperationTypeModel();
        $utilisateurModel = new UtilisateurModel();

        $type_operations = $operationTypeModel->findAll();
        $user = session()->get('user');
        $returnUrl = ((int) ($user['id_role'] ?? 0) === 2) ? '/client/dashboard' : '/home';

        // rafraîchir les données utilisateur depuis la base
        if ($user && isset($user['id'])) {
            $freshUser = $utilisateurModel->find($user['id']);
            if ($freshUser) {
                session()->set('user', $freshUser);
                $user = $freshUser;
            }
        }

        return view('transaction/form', [
            'title' => 'Transaction',
            'type_operations' => $type_operations,
            'solde' => $user['solde'] ?? 0,
            'return_url' => $returnUrl
        ]);    
    }

    // fonction to make transaction
    public function transaction()
    {
        $utilisateurModel = new UtilisateurModel();
        $historiqueTransactionModel = new HistoriqueTransactionModel();
        $montantFraisModel = new MontantFraisModel();
        $prefixConfigModel = new PrefixConfigModel();
        $commissionConfigModel = new CommissionConfigModel();

        $db = \Config\Database::connect();

        // début transaction SQL
        $db->transStart();

        try {

            // get data
            $type_operation = $this->request->getPost('type_operation');
            $numero_receiver_input = $this->request->getPost('numero_receiver');
            $includeWithdrawalFee = (bool) $this->request->getPost('include_withdrawal_fee');
            $montant = $this->request->getPost('montant');

            $sender = session()->get('user');

            if (!$sender) {
                throw new \Exception("Sender introuvable");
            }

            // RÈGLE 1 : Refuser les montants ≤ 0
            if (!is_numeric($montant) || $montant <= 0) {
                throw new \Exception("Le montant doit être strictement supérieur à zéro.");
            }

            // RÈGLE 4 : Vérifier qu'un barème de frais existe
            $frais = $montantFraisModel->findByOperationAndMontant($type_operation, $montant);

            if (!$frais) {
                throw new \Exception("Aucun barème de frais trouvé pour ce type d'opération et ce montant.");
            }

            if ($type_operation == 1) {
                // dépôt
                $nouveauSoldeSender = $sender['solde'] + ($montant - $frais['frais']);

            } elseif ($type_operation == 2) {
                // RÈGLE 2 : Refuser un retrait sans solde suffisant
                if ($sender['solde'] < ($montant + $frais['frais'])) {
                    throw new \Exception("Solde insuffisant pour effectuer ce retrait. Solde actuel : " 
                        . number_format((float)$sender['solde'], 2, ',', ' ') . " Ar");
                }

                $nouveauSoldeSender = $sender['solde'] - ($montant + $frais['frais']);

            } elseif ($type_operation == 3) {
                // transfert
                $numeroReceivers = is_array($numero_receiver_input)
                    ? array_values(array_filter(array_map('trim', $numero_receiver_input)))
                    : array_values(array_filter([trim((string) $numero_receiver_input)]));

                if (empty($numeroReceivers)) {
                    throw new \Exception("Veuillez saisir au moins un numéro de destinataire.");
                }

                $receiverOperations = [];
                $totalCommission = 0;
                $totalWithdrawalFee = 0;
                $receiverOperatorId = null;
                $receiverCount = count($numeroReceivers);
                $shareAmount = round(((float) $montant) / $receiverCount, 2);
                $distributedAmount = 0;

                foreach ($numeroReceivers as $index => $numeroReceiver) {
                    if ($numeroReceiver === $sender['numero']) {
                        throw new \Exception("Vous ne pouvez pas effectuer un transfert vers votre propre numéro.");
                    }

                    $receiver = $utilisateurModel->findByNumero($numeroReceiver);

                    if (!$receiver) {
                        throw new \Exception("Destinataire introuvable. Vérifiez le numéro saisi.");
                    }

                    $currentAmount = ($index === ($receiverCount - 1))
                        ? round(((float) $montant) - $distributedAmount, 2)
                        : $shareAmount;

                    $distributedAmount += $currentAmount;

                    $operatorInfo = $prefixConfigModel->findOperatorByNumero($numeroReceiver);
                    $currentCommission = 0;
                    $currentWithdrawalFee = 0;

                    if ($operatorInfo) {
                        $statutOperateur = strtolower(trim((string) ($operatorInfo['statut_operateur'] ?? '')));

                        if ($statutOperateur === 'non valable') {
                            throw new \Exception("Le destinataire est rattaché à un opérateur non valable.");
                        }

                        $currentOperatorId = (int) ($operatorInfo['id_operateur'] ?? 0);
                        if ($receiverCount > 1) {
                            if ($receiverOperatorId === null) {
                                $receiverOperatorId = $currentOperatorId;
                            } elseif ($receiverOperatorId !== $currentOperatorId) {
                                throw new \Exception("Les numéros saisis doivent appartenir au même opérateur.");
                            }
                        }

                        if ($statutOperateur === 'valable') {
                            $commissionConfig = $commissionConfigModel->findByOperateurId($currentOperatorId);
                            $pourcentage = (float) ($commissionConfig['pourcentage'] ?? 0);
                            $currentCommission = round($currentAmount * $pourcentage / 100, 2);
                        }
                    } elseif ($receiverCount > 1) {
                        throw new \Exception("Tous les numéros doivent être rattachés à un opérateur configuré.");
                    }

                    if ($includeWithdrawalFee) {
                        $withdrawalFee = $montantFraisModel->findByOperationAndMontant(2, $currentAmount);
                        if (!$withdrawalFee) {
                            throw new \Exception("Aucun barème de frais de retrait trouvé pour le montant " . number_format((float) $currentAmount, 2, ',', ' ') . " Ar.");
                        }
                        $currentWithdrawalFee = (float) $withdrawalFee['frais'];
                    }

                    $receiverOperations[] = [
                        'receiver_id' => $receiver['id'],
                        'receiver_numero' => $numeroReceiver,
                        'amount' => $currentAmount,
                        'commission' => $currentCommission,
                        'withdrawal_fee' => $currentWithdrawalFee,
                    ];

                    $totalCommission += $currentCommission;
                    $totalWithdrawalFee += $currentWithdrawalFee;
                }

                $totalDebit = (float) $montant + (float) $frais['frais'] + $totalCommission;
                if ($includeWithdrawalFee) {
                    $totalDebit += (float) $totalWithdrawalFee;
                }

                // RÈGLE 2 : Refuser un transfert sans solde suffisant
                if ($sender['solde'] < $totalDebit) {
                    throw new \Exception("Solde insuffisant pour effectuer ce transfert. Solde actuel : " 
                        . number_format((float)$sender['solde'], 2, ',', ' ') . " Ar");
                }

                foreach ($receiverOperations as $operation) {
                    $receiver = $utilisateurModel->find($operation['receiver_id']);
                    $creditAmount = $operation['amount'] + $operation['withdrawal_fee'];
                    $nouveauSoldeReceiver = $receiver['solde'] + $creditAmount;

                    $utilisateurModel->updateSoldeByUser(
                        $receiver['id'],
                        $nouveauSoldeReceiver
                    );

                    $historiqueTransactionModel->insert([
                        'id_type_operation' => $type_operation,
                        'numero_sender' => $sender['numero'],
                        'numero_receiver' => $operation['receiver_numero'],
                        'montant' => $operation['amount'],
                        'frais' => $includeWithdrawalFee ? $operation['withdrawal_fee'] : $frais['frais'],
                        'commission' => $operation['commission']
                    ]);
                }

                $nouveauSoldeSender = $sender['solde'] - $totalDebit;
            }


            // mise à jour sender
            $utilisateurModel->updateSoldeByUser(
                $sender['id'],
                $nouveauSoldeSender
            );

            // rafraîchir les données utilisateur en session
            $userUpdated = $utilisateurModel->find($sender['id']);
            if ($userUpdated) {
                session()->set('user', $userUpdated);
            }

            if ($type_operation != 3) {
                // insertion historique
                $data = [
                    'id_type_operation' => $type_operation,
                    'numero_sender' => $sender['numero'],
                    'numero_receiver' => null,
                    'montant' => $montant,
                    'frais' => $frais['frais'],
                    'commission' => 0
                ];

                $historiqueTransactionModel->insert($data);
            }

            // fin transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Erreur lors de la transaction en base de données.");
            }

        } catch (\Exception $e) {

            // annulation
            $db->transRollback();

            return redirect()
                ->to('/transaction/form')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->to('/transaction/form')
            ->with('success', 'Transaction effectuée avec succès !');
    }
}