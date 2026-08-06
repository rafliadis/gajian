<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDepartemenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_departemen' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama_departemen' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_departemen');
        $this->forge->createTable('departemen', true);
    }

    public function down()
    {
        $this->forge->dropTable('departemen', true);
    }
}
