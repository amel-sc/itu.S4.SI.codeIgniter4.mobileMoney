<?php

namespace App\Controllers;

use App\Models\HistoriqueTransactionModel;
use App\Models\OperationTypeModel;
use App\Models\UtilisateurModel;
use App\Models\MontantFraisModel;

class ClientController extends BaseController
{
    public function dashboard()
    {
        $user = session()->get('user');

        // Rafraîchir les données utilisateur depuis la base
        $utilisateurModel = new UtilisateurModel();
        $freshUser = $utilisateurModel->find($user['id']);
        if ($freshUser) {
            session()->set('user', $freshUser);
            $user = $freshUser;
        }

        return view('client/dashboard', [
            'title' => 'Mon espace',
            'user' => $user
        ]);
    }

    public function formDepot()
    {
        $utilisateurModel = new UtilisateurModel();
        $user = session()->get('user');

        $freshUser = $utilisateurModel->find($user['id']);
        if ($freshUser) {
            session()->set('user', $freshUser);
            $user = $freshUser;
        }

        $montantFraisModel = new MontantFraisModel();
        $operationTypeModel = new OperationTypeModel();

        $type_operations = $operationTypeModel->findAll();
        $baremes = $montantFraisModel->where('id_operation_type', 1)->findAll(); // dépôt = 1

        return view('client/depot', [
            'title' => 'Dépôt',
            'user' => $user,
            'baremes' => $baremes,
            'type_operations' => $type_operations
        ]);
    }

    public function depot()
    {
        $utilisateurModel = new UtilisateurModel();
        $historiqueTransactionModel = new HistoriqueTransactionModel();
        $montantFraisModel = new MontantFraisModel();

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $montant = $this->request->getPost('montant');
            $sender = session()->get('user');

            if (!$sender) {
                throw new \Exception("Utilisateur introuvable");
            }

            // Règle : montant > 0
            if (!is_numeric($montant) || $montant <= 0) {
                throw new \Exception("Le montant doit être strictement supérieur à zéro.");
            }

            // Vérifier barème de frais (dépôt = 1)
            $frais = $montantFraisModel->findByOperationAndMontant(1, $montant);
            if (!$frais) {
                throw new \Exception("Aucun barème de frais trouvé pour ce montant.");
            }

            $nouveauSolde = $sender['solde'] + ($montant - $frais['frais']);

            $utilisateurModel->updateSoldeByUser($sender['id'], $nouveauSolde);

            // Rafraîchir session
            $userUpdated = $utilisateurModel->find($sender['id']);
            if ($userUpdated) {
                session()->set('user', $userUpdated);
            }

            // Insertion historique
            $historiqueTransactionModel->insert([
                'id_type_operation' => 1,
                'numero_sender' => $sender['numero'],
                'numero_receiver' => null,
                'montant' => $montant,
                'frais' => $frais['frais']
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Erreur lors de la transaction.");
            }

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/client/depot')->with('error', $e->getMessage());
        }

        return redirect()->to('/client/depot')->with('success', 'Dépôt effectué avec succès !');
    }

    public function formRetrait()
    {
        $utilisateurModel = new UtilisateurModel();
        $user = session()->get('user');

        $freshUser = $utilisateurModel->find($user['id']);
        if ($freshUser) {
            session()->set('user', $freshUser);
            $user = $freshUser;
        }

        $montantFraisModel = new MontantFraisModel();
        $baremes = $montantFraisModel->where('id_operation_type', 2)->findAll(); // retrait = 2

        return view('client/retrait', [
            'title' => 'Retrait',
            'user' => $user,
            'baremes' => $baremes
        ]);
    }

    public function retrait()
    {
        $utilisateurModel = new UtilisateurModel();
        $historiqueTransactionModel = new HistoriqueTransactionModel();
        $montantFraisModel = new MontantFraisModel();

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $montant = $this->request->getPost('montant');
            $sender = session()->get('user');

            if (!$sender) {
                throw new \Exception("Utilisateur introuvable");
            }

            if (!is_numeric($montant) || $montant <= 0) {
                throw new \Exception("Le montant doit être strictement supérieur à zéro.");
            }

            $frais = $montantFraisModel->findByOperationAndMontant(2, $montant);
            if (!$frais) {
                throw new \Exception("Aucun barème de frais trouvé pour ce montant.");
            }

            if ($sender['solde'] < ($montant + $frais['frais'])) {
                throw new \Exception("Solde insuffisant. Solde actuel : " 
                    . number_format((float)$sender['solde'], 2, ',', ' ') . " Ar");
            }

            $nouveauSolde = $sender['solde'] - ($montant + $frais['frais']);

            $utilisateurModel->updateSoldeByUser($sender['id'], $nouveauSolde);

            $userUpdated = $utilisateurModel->find($sender['id']);
            if ($userUpdated) {
                session()->set('user', $userUpdated);
            }

            $historiqueTransactionModel->insert([
                'id_type_operation' => 2,
                'numero_sender' => $sender['numero'],
                'numero_receiver' => null,
                'montant' => $montant,
                'frais' => $frais['frais']
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Erreur lors de la transaction.");
            }

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/client/retrait')->with('error', $e->getMessage());
        }

        return redirect()->to('/client/retrait')->with('success', 'Retrait effectué avec succès !');
    }

    public function formTransfert()
    {
        $utilisateurModel = new UtilisateurModel();
        $user = session()->get('user');

        $freshUser = $utilisateurModel->find($user['id']);
        if ($freshUser) {
            session()->set('user', $freshUser);
            $user = $freshUser;
        }

        $montantFraisModel = new MontantFraisModel();
        $baremes = $montantFraisModel->where('id_operation_type', 3)->findAll(); // transfert = 3

        return view('client/transfert', [
            'title' => 'Transfert',
            'user' => $user,
            'baremes' => $baremes
        ]);
    }

    public function transfert()
    {
        $utilisateurModel = new UtilisateurModel();
        $historiqueTransactionModel = new HistoriqueTransactionModel();
        $montantFraisModel = new MontantFraisModel();

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $montant = $this->request->getPost('montant');
            $numero_receiver = trim($this->request->getPost('numero_receiver') ?? '');
            $sender = session()->get('user');

            if (!$sender) {
                throw new \Exception("Utilisateur introuvable");
            }

            if (!is_numeric($montant) || $montant <= 0) {
                throw new \Exception("Le montant doit être strictement supérieur à zéro.");
            }

            // Vérifier que ce n'est pas son propre numéro
            if ($numero_receiver === $sender['numero']) {
                throw new \Exception("Vous ne pouvez pas effectuer un transfert vers votre propre numéro.");
            }

            $receiver = $utilisateurModel->findByNumero($numero_receiver);
            if (!$receiver) {
                throw new \Exception("Destinataire introuvable. Vérifiez le numéro saisi.");
            }

            $frais = $montantFraisModel->findByOperationAndMontant(3, $montant);
            if (!$frais) {
                throw new \Exception("Aucun barème de frais trouvé pour ce montant.");
            }

            if ($sender['solde'] < ($montant + $frais['frais'])) {
                throw new \Exception("Solde insuffisant. Solde actuel : " 
                    . number_format((float)$sender['solde'], 2, ',', ' ') . " Ar");
            }

            // Mise à jour receiver
            $nouveauSoldeReceiver = $receiver['solde'] + $montant;
            $utilisateurModel->updateSoldeByUser($receiver['id'], $nouveauSoldeReceiver);

            // Mise à jour sender
            $nouveauSoldeSender = $sender['solde'] - ($montant + $frais['frais']);
            $utilisateurModel->updateSoldeByUser($sender['id'], $nouveauSoldeSender);

            // Rafraîchir session
            $userUpdated = $utilisateurModel->find($sender['id']);
            if ($userUpdated) {
                session()->set('user', $userUpdated);
            }

            // Insertion historique
            $historiqueTransactionModel->insert([
                'id_type_operation' => 3,
                'numero_sender' => $sender['numero'],
                'numero_receiver' => $numero_receiver,
                'montant' => $montant,
                'frais' => $frais['frais']
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Erreur lors de la transaction.");
            }

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/client/transfert')->with('error', $e->getMessage());
        }

        return redirect()->to('/client/transfert')->with('success', 'Transfert effectué avec succès !');
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

        // Transactions où l'utilisateur est sender ou receiver
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