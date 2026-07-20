<?php
namespace App\Controllers;
use App\Models\PrefixConfigModel;
use App\Models\UtilisateurModel;

class AuthController extends BaseController{    
	// function to get form to login
    public function form()    {        
        $user = session()->get('user');
        if ($user) {
            return ((int) ($user['id_role'] ?? 0) === 2)
                ? redirect()->to('/client/dashboard')
                : redirect()->to('/home');
        }

        return view('auth/login', [
            'title' => 'Connexion',
            'hideSidebar' => true,
            'hideNavbar' => true
        ]);    
    }
    // function to login
    public function login() {
        $utilisateurModel = new UtilisateurModel();
        $prefixConfigModel = new PrefixConfigModel();
        // get user numero
        $numero = $this->request->getPost('numero');

        // get user by numero
        $user = $utilisateurModel->findByNumero($numero);

        // verify if user exist
        if ($user) {
            $operatorInfo = $prefixConfigModel->findOperatorByNumero($numero);

            if (!$operatorInfo || strtolower(trim((string) ($operatorInfo['statut_operateur'] ?? ''))) !== 'operateur') {
                return redirect()->to('/login')->with('error', 'Ce numéro ne peut pas se connecter à cet opérateur.')->withInput();
            }

            session()->set('user', $user);
            return ((int) ($user['id_role'] ?? 0) === 2)
                ? redirect()->to('/client/dashboard')
                : redirect()->to('/home');
        }

        else {
            return redirect()->to('/login')->with('error', 'Utilisateur introuvable')->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Déconnexion effectuée avec succès.');
    }
}
