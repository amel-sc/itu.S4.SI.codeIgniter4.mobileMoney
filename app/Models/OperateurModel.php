<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table         = 'operateur';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['nom', 'id_statut'];

    public function findAllWithStatus(): array
    {
        return $this->select('operateur.*, statut_operateur.libelle AS statut_libelle')
            ->join('statut_operateur', 'statut_operateur.id = operateur.id_statut', 'left')
            ->orderBy('operateur.nom', 'ASC')
            ->findAll();
    }
}