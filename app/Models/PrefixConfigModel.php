<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixConfigModel extends Model
{
    protected $table         = 'prefix_config';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['value'];
}