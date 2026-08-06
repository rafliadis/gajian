<?php

namespace App\Models;

use CodeIgniter\Model;

class KomponenGajiModel extends Model
{
    protected $table      = 'komponen_gaji';
    protected $primaryKey = 'id_komponen';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_karyawan', 'tunjangan_tidak_tetap', 'bonus', 'potongan_lain',
        'ikut_bpjs_kesehatan', 'ikut_bpjs_tk', 'kena_pph21', 'keterangan',
    ];

    public function getByKaryawan(int $idKaryawan): ?array
    {
        return $this->where('id_karyawan', $idKaryawan)->first();
    }
}
