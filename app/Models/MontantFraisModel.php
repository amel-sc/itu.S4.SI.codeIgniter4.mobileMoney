<?php

namespace App\Models;

use CodeIgniter\Model;

class MontantFraisModel extends Model
{
    protected $table         = 'montant_frais';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['id_operation_type', 'montant1', 'montant2', 'frais'];

    // function to get montant_frais by operation and montant
    public function findByOperationAndMontant($operation, $montant) {
        return $this->where('id_operation_type', $operation)
                    ->where('montant1 <=', $montant)
                    ->where('montant2 >=', $montant)
                    ->first();
    }
}
