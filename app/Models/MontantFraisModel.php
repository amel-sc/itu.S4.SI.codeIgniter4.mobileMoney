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
}
