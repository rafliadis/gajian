<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggajianModel extends Model
{
    protected $table      = 'penggajian';
    protected $primaryKey = 'id_gaji';
    protected $allowedFields = ['id_karyawan', 'id_bonus', 'id_potongan', 'bulan', 'tahun', 'total_gaji', 'tanggal_gaji'];
}
