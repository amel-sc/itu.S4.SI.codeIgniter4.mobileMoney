<?php
namespace App\Models;
use CodeIgniter\Model;


class HistoriqueTransactionModel extends Model {    
	protected $table = 'historique_transaction';    
	protected $allowedFields = [
        'id_type_operation', 
        'montant',
        'frais',
    'commission',
        'numero_sender',
        'numero_receiver',
        'date_transaction'
    ];
}