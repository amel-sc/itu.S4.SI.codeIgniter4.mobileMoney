<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionConfigModel extends Model
{
    protected $table         = 'commission_config';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['id_operateur', 'pourcentage'];

    public function findByOperateurId(int $idOperateur): ?array
    {
        return $this->where('id_operateur', $idOperateur)->first();
    }

    public function findAllWithOperators(): array
    {
        return $this->select('commission_config.*, operateur.nom AS operateur_nom, statut_operateur.libelle AS statut_libelle')
            ->join('operateur', 'operateur.id = commission_config.id_operateur', 'left')
            ->join('statut_operateur', 'statut_operateur.id = operateur.id_statut', 'left')
            ->orderBy('operateur.nom', 'ASC')
            ->findAll();
    }
}