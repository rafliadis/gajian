<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KomponenGajiModel;
use App\Models\KaryawanModel;
use App\Models\AuditLogModel;

class KomponenGaji extends BaseController
{
    public function index()
    {
        $karyawanModel  = new KaryawanModel();
        $komponenModel  = new KomponenGajiModel();

        $karyawan = $karyawanModel->getAllWithJabatan();

        // Tambahkan info apakah sudah ada komponen gaji
        foreach ($karyawan as &$k) {
            $komponen = $komponenModel->getByKaryawan($k['id_karyawan']);
            $k['has_komponen'] = $komponen !== null;
        }

        return view('admin/komponen_gaji/index', [
            'title'    => 'Komponen Gaji Karyawan',
            'karyawan' => $karyawan,
        ]);
    }

    public function form(int $idKaryawan)
    {
        $karyawanModel = new KaryawanModel();
        $komponenModel = new KomponenGajiModel();

        $karyawan = $karyawanModel->getDetail($idKaryawan);
        if (!$karyawan) return redirect()->to('/admin/komponen-gaji')->with('error', 'Karyawan tidak ditemukan.');

        $komponen = $komponenModel->getByKaryawan($idKaryawan);

        return view('admin/komponen_gaji/form', [
            'title'    => 'Atur Komponen Gaji: ' . $karyawan['nama_karyawan'],
            'karyawan' => $karyawan,
            'komponen' => $komponen,
        ]);
    }

    public function save(int $idKaryawan)
    {
        $karyawanModel = new KaryawanModel();
        $komponenModel = new KomponenGajiModel();

        $karyawan = $karyawanModel->find($idKaryawan);
        if (!$karyawan) return redirect()->to('/admin/komponen-gaji')->with('error', 'Karyawan tidak ditemukan.');

        $data = [
            'id_karyawan'           => $idKaryawan,
            'tunjangan_tidak_tetap' => $this->request->getPost('tunjangan_tidak_tetap') ?: 0,
            'bonus'                 => $this->request->getPost('bonus') ?: 0,
            'potongan_lain'         => $this->request->getPost('potongan_lain') ?: 0,
            'ikut_bpjs_kesehatan'   => $this->request->getPost('ikut_bpjs_kesehatan') ? 1 : 0,
            'ikut_bpjs_tk'          => $this->request->getPost('ikut_bpjs_tk') ? 1 : 0,
            'kena_pph21'            => $this->request->getPost('kena_pph21') ? 1 : 0,
            'keterangan'            => $this->request->getPost('keterangan'),
        ];

        $existing = $komponenModel->getByKaryawan($idKaryawan);
        if ($existing) {
            $komponenModel->update($existing['id_komponen'], $data);
            AuditLogModel::catat('UPDATE', 'komponen_gaji', $idKaryawan, 'Update komponen gaji karyawan ID: ' . $idKaryawan);
        } else {
            $komponenModel->insert($data);
            AuditLogModel::catat('CREATE', 'komponen_gaji', $idKaryawan, 'Buat komponen gaji karyawan ID: ' . $idKaryawan);
        }

        return redirect()->to('/admin/komponen-gaji')->with('success', 'Komponen gaji berhasil disimpan.');
    }
}
