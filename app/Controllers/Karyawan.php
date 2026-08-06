<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\JabatanModel; // Pastikan baris ini ada!

class Karyawan extends BaseController
{
    public function create()
    {
        $jabatanModel = new JabatanModel();
        $data['jabatan'] = $jabatanModel->findAll(); 
        
        return view('karyawan/create', $data);
    }
    // Di dalam app/Controllers/Karyawan.php
public function save()
{
    $model = new KaryawanModel();
    $model->save([
        'nip'           => $this->request->getPost('nip'),
        'nama_karyawan' => $this->request->getPost('nama_karyawan'),
        'no_hp'         => $this->request->getPost('no_hp'), // Tambahkan ini
        'alamat'        => $this->request->getPost('alamat'),
        'id_jabatan'    => $this->request->getPost('id_jabatan'),
        'status'        => $this->request->getPost('status'),
    ]);

    return redirect()->to('/karyawan');
}
    // ...
}