<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixConfigModel extends Model
{
    protected $table         = 'prefix_config';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['value', 'id_operateur'];

    public function findAllWithOperators(): array
    {
        return $this->select('prefix_config.*, operateur.nom AS operateur_nom, statut_operateur.libelle AS statut_operateur')
            ->join('operateur', 'operateur.id = prefix_config.id_operateur', 'left')
            ->join('statut_operateur', 'statut_operateur.id = operateur.id_statut', 'left')
            ->orderBy('prefix_config.value', 'ASC')
            ->findAll();
    }

    public function findOperatorByNumero(string $numero): ?array
    {
        $prefixes = $this->select('prefix_config.id AS prefix_id, prefix_config.value, prefix_config.id_operateur, operateur.nom AS operateur_nom, operateur.id_statut, statut_operateur.libelle AS statut_operateur')
            ->join('operateur', 'operateur.id = prefix_config.id_operateur', 'left')
            ->join('statut_operateur', 'statut_operateur.id = operateur.id_statut', 'left')
            ->orderBy('LENGTH(prefix_config.value)', 'DESC', false)
            ->findAll();

        foreach ($prefixes as $prefix) {
            $value = (string) ($prefix['value'] ?? '');

            if ($value !== '' && str_starts_with($numero, $value)) {
                return $prefix;
            }
        }

        return null;
    }
}