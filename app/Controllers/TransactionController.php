<?php
namespace App\Controllers;
use App\Models\HistoriqueTransactionModel;
use App\Models\OperationTypeModel;
use App\Models\UtilisateurModel;
use App\Models\MontantFraisModel;

class TransactionController extends BaseController{    
	// function to get form for transaction
    public function form() {        
        $operationTypeModel = new OperationTypeModel();

        $type_operations = $operationTypeModel->findAll();

        return view('transaction/form', [
            'title' => 'Transaction',
            'type_operations' => $type_operations
        ]);    
    }

    // fonction to make transaction
    public function transaction()
    {
        $utilisateurModel = new UtilisateurModel();
        $historiqueTransactionModel = new HistoriqueTransactionModel();
        $montantFraisModel = new MontantFraisModel();

        $db = \Config\Database::connect();

        // début transaction SQL
        $db->transStart();

        try {

            // get data
            $type_operation = $this->request->getPost('type_operation');
            $numero_receiver = $this->request->getPost('numero_receiver');
            $montant = $this->request->getPost('montant');

            $sender = session()->get('user');

            if (!$sender) {
                throw new \Exception("Sender introuvable");
            }

            // trouver frais
            $frais = $montantFraisModel->findByOperationAndMontant($type_operation, $montant);

            if (!$frais) {
                throw new \Exception("Frais introuvable");
            }


            if ($type_operation == 1) {
                // dépôt
                $nouveauSoldeSender = $sender['solde'] + ($montant - $frais['frais']);

            } elseif ($type_operation == 2) {
                // retrait
                if ($sender['solde'] < ($montant + $frais['frais'])) {
                    throw new \Exception("Solde insuffisant");
                }

                $nouveauSoldeSender = $sender['solde'] - ($montant + $frais['frais']);

            } elseif ($type_operation == 3) {
                // transfert
                $receiver = $utilisateurModel->findByNumero($numero_receiver);

                if (!$receiver) {
                    throw new \Exception("Receiver introuvable");
                }

                if ($sender['solde'] < ($montant + $frais['frais'])) {
                    throw new \Exception("Solde insuffisant");
                }

                // mise à jour receiver
                $nouveauSoldeReceiver = $receiver['solde'] + $montant;

                $utilisateurModel->updateSoldeByUser(
                    $receiver['id'],
                    $nouveauSoldeReceiver
                );

                $nouveauSoldeSender = $sender['solde'] - ($montant + $frais['frais']);
            }


            // mise à jour sender
            $utilisateurModel->updateSoldeByUser(
                $sender['id'],
                $nouveauSoldeSender
            );

            // insertion historique
            $data = [
                'id_type_operation' => $type_operation,
                'numero_sender' => $sender['numero'],
                'numero_receiver' => ($type_operation == 3) ? $numero_receiver : null,
                'montant' => $montant,
                'frais' => $frais['frais']
            ];

            $historiqueTransactionModel->insert($data);

            // fin transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Erreur transaction");
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
            ->with('success', 'Transaction avec succès');
    }
}