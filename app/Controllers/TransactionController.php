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

        $db = \Config\Database::connect();

        // début transaction SQL
        $db->transStart();

        try {

            // get data
            $type_operation = $this->request->getPost('type_operation');
            $numero_receiver = trim($this->request->getPost('numero_receiver') ?? '');
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

                // RÈGLE 3 : Refuser un transfert vers son propre numéro
                if ($numero_receiver === $sender['numero']) {
                    throw new \Exception("Vous ne pouvez pas effectuer un transfert vers votre propre numéro.");
                }

                $receiver = $utilisateurModel->findByNumero($numero_receiver);

                if (!$receiver) {
                    throw new \Exception("Destinataire introuvable. Vérifiez le numéro saisi.");
                }

                // RÈGLE 2 : Refuser un transfert sans solde suffisant
                if ($sender['solde'] < ($montant + $frais['frais'])) {
                    throw new \Exception("Solde insuffisant pour effectuer ce transfert. Solde actuel : " 
                        . number_format((float)$sender['solde'], 2, ',', ' ') . " Ar");
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

            // rafraîchir les données utilisateur en session
            $userUpdated = $utilisateurModel->find($sender['id']);
            if ($userUpdated) {
                session()->set('user', $userUpdated);
            }

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