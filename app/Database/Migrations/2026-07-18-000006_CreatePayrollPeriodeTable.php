<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePayrollPeriodeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_periode'     => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'bulan'          => ['type' => 'TINYINT', 'unsigned' => true, 'null' => false, 'comment' => '1-12'],
            'tahun'          => ['type' => 'SMALLINT', 'unsigned' => true, 'null' => false],
            'nama_periode'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'comment' => 'Contoh: Juli 2026'],
            'status'         => ['type' => 'ENUM', 'constraint' => ['draft', 'preview', 'finalized'], 'default' => 'draft'],
            'tanggal_run'    => ['type' => 'DATETIME', 'null' => true],
            'tanggal_finalisasi' => ['type' => 'DATETIME', 'null' => true],
            'difinalisasi_oleh'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'catatan'        => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_periode');
        $this->forge->addUniqueKey(['bulan', 'tahun']);
        $this->forge->createTable('payroll_periode', true);
    }

    public function down()
    {
        $this->forge->dropTable('payroll_periode', true);
    }
}
