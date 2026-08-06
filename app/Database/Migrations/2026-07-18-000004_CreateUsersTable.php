<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_karyawan'  => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'comment' => 'NULL jika admin murni'],
            'username'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'password'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'role'         => ['type' => 'ENUM', 'constraint' => ['admin', 'karyawan'], 'default' => 'karyawan'],
            'is_active'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'last_login'   => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id_karyawan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
