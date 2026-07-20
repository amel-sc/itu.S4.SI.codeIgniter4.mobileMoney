<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAchatTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'auto_increment' => true,
            ],
            'value' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ]
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('prefix_config');
    }

    public function down()
    {
        $this->forge->dropTable('prefix_config');
    }
}