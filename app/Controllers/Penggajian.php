<?php

namespace App\Controllers;

use App\Models\PenggajianModel;

class Penggajian extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Algoritma perhitungan: (Gaji Pokok + Tunjangan + Bonus) - Potongan
        $builder = $db->table('penggajian');
        $builder->select('penggajian.*, karyawan.nama, (jabatan.gaji_pokok + jabatan.tunjangan + bonus.nominal - potongan.nominal) as total_hitung');
        $builder->join('karyawan', 'karyawan.id_karyawan = penggajian.id_karyawan');
        $builder->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan');
        $builder->join('bonus', 'bonus.id_bonus = penggajian.id_bonus');
        $builder->join('potongan', 'potongan.id_potongan = penggajian.id_potongan');
        
        $data['penggajian'] = $builder->get()->getResultArray();

        return view('penggajian/index', $data);
    }
}