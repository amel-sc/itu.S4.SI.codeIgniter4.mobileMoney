<?php
namespace App\Models;
use CodeIgniter\Model;


class HistoriqueTransactionModel extends Model {    
	protected $table = 'historique_transaction';    
	protected $allowedFields = [
        'type_operation', 
        'montant',
        'frais',
        'num_sender',
        'num_receiver',
        'date'
    ];
}