<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJabatanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jabatan'     => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_departemen'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'nama_jabatan'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'gaji_pokok'     => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'tunjangan_tetap'=> ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_jabatan');
        $this->forge->addForeignKey('id_departemen', 'departemen', 'id_departemen', 'CASCADE', 'SET NULL');
        $this->forge->createTable('jabatan', true);
    }

    public function down()
    {
        $this->forge->dropTable('jabatan', true);
    }
}
