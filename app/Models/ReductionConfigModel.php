<?php

namespace App\Models;

use CodeIgniter\Model;

class ReductionConfigModel extends Model
{
    protected $table         = 'reduction_config';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['pourcentage'];
}