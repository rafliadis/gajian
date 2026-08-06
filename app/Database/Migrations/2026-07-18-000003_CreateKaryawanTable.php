<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKaryawanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_karyawan'        => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_jabatan'         => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'nik'                => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'npwp'               => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'nama_karyawan'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'jenis_kelamin'      => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'default' => 'L'],
            'tanggal_lahir'      => ['type' => 'DATE', 'null' => true],
            'alamat'             => ['type' => 'TEXT', 'null' => true],
            'no_hp'              => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'              => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tanggal_masuk'      => ['type' => 'DATE', 'null' => true],
            'status_pernikahan'  => ['type' => 'ENUM', 'constraint' => ['TK', 'K0', 'K1', 'K2', 'K3'], 'default' => 'TK', 'comment' => 'TK=Tidak Kawin, K0=Kawin 0 tanggungan, dst'],
            'no_rekening'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'nama_bank'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'no_bpjs_kesehatan'  => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'no_bpjs_tk'         => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'status'             => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'foto'               => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_karyawan');
        $this->forge->addForeignKey('id_jabatan', 'jabatan', 'id_jabatan', 'CASCADE', 'SET NULL');
        $this->forge->createTable('karyawan', true);
    }

    public function down()
    {
        $this->forge->dropTable('karyawan', true);
    }
}
