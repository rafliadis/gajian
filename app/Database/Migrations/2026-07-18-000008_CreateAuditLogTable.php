<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditLogTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'username'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'aksi'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'comment' => 'CREATE, UPDATE, DELETE, LOGIN, FINALIZE, dll'],
            'modul'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'comment' => 'karyawan, payroll, slip_gaji, dll'],
            'data_id'      => ['type' => 'INT', 'null' => true, 'comment' => 'ID record yang diubah'],
            'keterangan'   => ['type' => 'TEXT', 'null' => true],
            'ip_address'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('audit_log', true);
    }

    public function down()
    {
        $this->forge->dropTable('audit_log', true);
    }
}
