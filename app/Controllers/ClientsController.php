<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class ClientsController extends BaseController
{
    public function index()
    {
        $utilisateurModel = new UtilisateurModel();

        // Récupérer tous les utilisateurs avec le rôle client (id_role = 2)
        $clients = $utilisateurModel->where('id_role', 2)->findAll();

        $clientsData = [];
        foreach ($clients as $client) {
            $clientsData[] = [
                'id' => $client['id'],
                'prenom' => $client['prenom'],
                'nom' => $client['nom'],
                'numero' => $client['numero'],
                'solde' => $client['solde']
            ];
        }

        return view('clients/index', [
            'title' => 'Situation des comptes clients',
            'clients' => $clientsData
        ]);
    }
}