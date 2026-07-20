<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('statut_operateur')->insertBatch([
            ['libelle' => 'operateur'],
            ['libelle' => 'valable'],
            ['libelle' => 'non valable'],
        ]);

        $this->db->table('operateur')->insertBatch([
            ['nom' => 'Telma', 'id_statut' => 1],
            ['nom' => 'Orange', 'id_statut' => 2],
            ['nom' => 'Airtel', 'id_statut' => 3],
        ]);

        $this->db->table('commission_config')->insertBatch([
            ['id_operateur' => 2, 'pourcentage' => 5],
        ]);

        $prefix_config = [
            [
                'value' => '038',
                'id_operateur' => 1,
            ],
            [
                'value' => '033',
                'id_operateur' => 2,
            ],
            [
                'value' => '037',
                'id_operateur' => 3,
            ]
        ];

        $this->db->table('prefix_config')->insertBatch($prefix_config);
    }
}