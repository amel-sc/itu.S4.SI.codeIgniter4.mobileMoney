<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // prefix_config
        $prefix_config = [
            [
                'value' => '038',
            ],
            [
                'value' => '033',
            ],
            [
                'value' => '037',
            ]
        ];

        $this->db->table('prefix_config')->insertBatch($prefix_config);
    }
}