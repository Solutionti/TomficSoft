<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterDesechosImagenToText extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('desechos_organicos', [
            'imagen' => [
                'name' => 'imagen',
                'type' => 'MEDIUMTEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('desechos_organicos', [
            'imagen' => [
                'name'       => 'imagen',
                'type'       => 'VARCHAR',
                'constraint' => 3000,
                'null'       => true,
            ],
        ]);
    }
}
