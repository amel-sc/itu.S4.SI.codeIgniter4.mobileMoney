<?php
namespace App\Controllers;
use App\Models\UtilisateurModel;

class AuthController extends BaseController{    
	public function form()    {        
		$model = new UtilisateurModel();

        return view('auth/login', [
            'title' => 'Login'
        ]);    
    }
}