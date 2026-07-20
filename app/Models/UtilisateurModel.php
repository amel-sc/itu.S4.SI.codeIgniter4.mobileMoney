<?php
namespace App\Models;
use CodeIgniter\Model;

class UtilisateurModel extends Model {    
	protected $table = 'utilisateur';    
	protected $allowedFields = [
        'prenom', 
        'nom',
        'numero',
        'id_role'
    ];

    // function to verify is user exist
    public function userExist($numero) {
        $result = false;
        $user = $this->findByNumero($numero);

        if ($user) {
            $result = true;
        }

        return $result;
    }

    // function to get user by numero
    public function findByNumero($numero) {
        return $this->where('numero', $numero)->first();
    }
}