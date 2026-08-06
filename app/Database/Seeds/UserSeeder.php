<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Insert admin default
        $this->db->table('users')->insert([
            'id_karyawan' => null,
            'username'    => 'admin',
            'email'       => 'admin@penggajian.com',
            'password'    => password_hash('Admin@123', PASSWORD_BCRYPT),
            'role'        => 'admin',
            'is_active'   => 1,
            'created_at'  => $now,
            'updated_at'  => $now,
        ]);

        // Insert departemen contoh
        $this->db->table('departemen')->insertBatch([
            ['nama_departemen' => 'Human Resources', 'deskripsi' => 'Departemen HR', 'created_at' => $now, 'updated_at' => $now],
            ['nama_departemen' => 'Teknologi Informasi', 'deskripsi' => 'Departemen IT', 'created_at' => $now, 'updated_at' => $now],
            ['nama_departemen' => 'Keuangan', 'deskripsi' => 'Departemen Finance', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Insert jabatan contoh
        $this->db->table('jabatan')->insertBatch([
            ['id_departemen' => 1, 'nama_jabatan' => 'HR Manager', 'gaji_pokok' => 8000000, 'tunjangan_tetap' => 1500000, 'created_at' => $now, 'updated_at' => $now],
            ['id_departemen' => 2, 'nama_jabatan' => 'Software Engineer', 'gaji_pokok' => 9000000, 'tunjangan_tetap' => 2000000, 'created_at' => $now, 'updated_at' => $now],
            ['id_departemen' => 3, 'nama_jabatan' => 'Akuntan', 'gaji_pokok' => 7000000, 'tunjangan_tetap' => 1000000, 'created_at' => $now, 'updated_at' => $now],
        ]);

        echo "UserSeeder berhasil dijalankan!\n";
        echo "Admin Login: admin@penggajian.com / Admin@123\n";
    }
}
