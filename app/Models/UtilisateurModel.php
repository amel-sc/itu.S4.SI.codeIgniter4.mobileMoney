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
}