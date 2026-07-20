<?php
namespace App\Controllers;
use App\Models\UtilisateurModel;

class AuthController extends BaseController{    
	// function to get form to login
    public function form()    {        
        return view('auth/login', [
            'title' => 'Connexion',
            'hideSidebar' => true,
            'hideNavbar' => true
        ]);    
    }
    // function to login
    public function login() {
        $utilisateurModel = new UtilisateurModel();
        // get user numero
        $numero = $this->request->getPost('numero');

        // get user by numero
        $user = $utilisateurModel->findByNumero($numero);

        // verify if user exist
        if ($user) {
            session()->set('user', $user);
            return redirect()->to('/home');
        }

        else {
            return redirect()->to('/login')->with('error', 'Utilisateur introuvable')->withInput();
        }
    }
}
