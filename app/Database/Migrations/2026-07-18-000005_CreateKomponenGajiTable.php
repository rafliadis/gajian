<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKomponenGajiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_komponen'    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_karyawan'    => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'tunjangan_tidak_tetap' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00', 'comment' => 'Transport, makan, dll'],
            'bonus'          => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'potongan_lain'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00', 'comment' => 'Pinjaman, cicilan, dll'],
            'ikut_bpjs_kesehatan' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'ikut_bpjs_tk'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'kena_pph21'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'keterangan'     => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_komponen');
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id_karyawan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('komponen_gaji', true);
    }

    public function down()
    {
        $this->forge->dropTable('komponen_gaji', true);
    }
}
