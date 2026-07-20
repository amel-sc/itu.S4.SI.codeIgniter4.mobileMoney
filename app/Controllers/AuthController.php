<?php
namespace App\Controllers;
use App\Models\UtilisateurModel;

class AuthController extends BaseController{    
	// function to get form to login
    public function form()    {        
		$model = new UtilisateurModel();

        return view('auth/login', [
            'title' => 'Login'
        ]);    
    }
    // function to login
    public function login() {
        
    }
}