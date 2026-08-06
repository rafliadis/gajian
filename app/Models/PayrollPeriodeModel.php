<?php

namespace App\Models;

use CodeIgniter\Model;

class PayrollPeriodeModel extends Model
{
    protected $table      = 'payroll_periode';
    protected $primaryKey = 'id_periode';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'bulan', 'tahun', 'nama_periode', 'status',
        'tanggal_run', 'tanggal_finalisasi', 'difinalisasi_oleh', 'catatan',
    ];

    public function getAll(): array
    {
        return $this->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->findAll();
    }

    public function cekPeriodeAda(int $bulan, int $tahun): bool
    {
        return $this->where('bulan', $bulan)->where('tahun', $tahun)->countAllResults() > 0;
    }

    public function getFinalized(): array
    {
        return $this->where('status', 'finalized')->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->findAll();
    }
}
