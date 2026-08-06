<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table      = 'jabatan';
    protected $primaryKey = 'id_jabatan';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_departemen', 'nama_jabatan', 'gaji_pokok', 'tunjangan_tetap',
    ];

    /**
     * Ambil jabatan beserta nama departemen
     */
    public function withDepartemen(): array
    {
        return $this->select('jabatan.*, departemen.nama_departemen')
                    ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
                    ->findAll();
    }
}