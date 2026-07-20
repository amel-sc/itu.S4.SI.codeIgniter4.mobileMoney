<?php

namespace App\Models;

use CodeIgniter\Model;

class StatutOperateurModel extends Model
{
    protected $table         = 'statut_operateur';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['libelle'];

    public function findAllOrdered(): array
    {
        return $this->orderBy('id', 'ASC')->findAll();
    }
}