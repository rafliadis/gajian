<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_karyawan', 'username', 'email', 'password',
        'role', 'is_active', 'last_login',
    ];

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]',
        'email'    => 'required|valid_email|max_length[150]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[admin,karyawan]',
    ];

    /**
     * Cari user berdasarkan username atau email
     */
    public function findByUsernameOrEmail(string $credential): ?array
    {
        return $this->where('username', $credential)
                    ->orWhere('email', $credential)
                    ->where('is_active', 1)
                    ->first();
    }
}
