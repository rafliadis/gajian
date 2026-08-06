<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePayrollDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_periode'          => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'id_karyawan'         => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            // Pendapatan
            'gaji_pokok'          => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'tunjangan_tetap'     => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'tunjangan_tidak_tetap' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'bonus'               => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'total_pendapatan'    => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            // Potongan
            'potongan_bpjs_kes_karyawan'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00', 'comment' => '1% dari gaji pokok'],
            'potongan_bpjs_tk_jht'        => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00', 'comment' => '2% dari gaji pokok'],
            'potongan_bpjs_tk_jp'         => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00', 'comment' => '1% dari gaji pokok'],
            'potongan_pph21'              => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'potongan_lain'               => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'total_potongan'              => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            // Biaya Perusahaan (tidak mengurangi THP)
            'bpjs_kes_perusahaan'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00', 'comment' => '4% dari gaji pokok'],
            'bpjs_tk_perusahaan'   => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            // Take Home Pay
            'gaji_bersih'          => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            // Koreksi manual
            'koreksi_nominal'      => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'koreksi_keterangan'   => ['type' => 'TEXT', 'null' => true],
            'is_koreksi'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_detail');
        $this->forge->addUniqueKey(['id_periode', 'id_karyawan']);
        $this->forge->addForeignKey('id_periode', 'payroll_periode', 'id_periode', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id_karyawan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('payroll_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('payroll_detail', true);
    }
}
