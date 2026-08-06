<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\JabatanModel;
use App\Models\AuditLogModel;

class Karyawan extends BaseController
{
    protected KaryawanModel $model;

    public function __construct()
    {
        $this->model = new KaryawanModel();
    }

    public function index()
    {
        return view('admin/karyawan/index', [
            'title'    => 'Data Karyawan',
            'karyawan' => $this->model->getAllWithJabatan(),
        ]);
    }

    public function create()
    {
        $jabatanModel = new JabatanModel();
        return view('admin/karyawan/form', [
            'title'    => 'Tambah Karyawan',
            'karyawan' => null,
            'jabatan'  => $jabatanModel->withDepartemen(),
        ]);
    }

    public function save()
    {
        $rules = [
            'nama_karyawan'     => 'required|min_length[2]|max_length[150]',
            'id_jabatan'        => 'required|numeric',
            'tanggal_masuk'     => 'required|valid_date[Y-m-d]',
            'nik'               => 'permit_empty|numeric',
            'npwp'              => 'permit_empty|numeric',
            'no_hp'             => 'permit_empty|numeric',
            'no_rekening'       => 'permit_empty|numeric',
            'no_bpjs_kesehatan' => 'permit_empty|numeric',
            'no_bpjs_tk'        => 'permit_empty|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle foto upload
        $foto = $this->request->getFile('foto');
        $namaFoto = null;
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/karyawan', $namaFoto);
        }

        $data = [
            'id_jabatan'        => $this->request->getPost('id_jabatan'),
            'nik'               => $this->request->getPost('nik'),
            'npwp'              => $this->request->getPost('npwp'),
            'nama_karyawan'     => $this->request->getPost('nama_karyawan'),
            'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir'     => $this->request->getPost('tanggal_lahir') ?: null,
            'alamat'            => $this->request->getPost('alamat'),
            'no_hp'             => $this->request->getPost('no_hp'),
            'email'             => $this->request->getPost('email'),
            'tanggal_masuk'     => $this->request->getPost('tanggal_masuk'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'no_rekening'       => $this->request->getPost('no_rekening'),
            'nama_bank'         => $this->request->getPost('nama_bank'),
            'no_bpjs_kesehatan' => $this->request->getPost('no_bpjs_kesehatan'),
            'no_bpjs_tk'        => $this->request->getPost('no_bpjs_tk'),
            'status'            => $this->request->getPost('status') ?: 'aktif',
            'foto'              => $namaFoto,
        ];

        $this->model->insert($data);
        $newId = $this->model->getInsertID();

        AuditLogModel::catat('CREATE', 'karyawan', $newId, 'Tambah karyawan: ' . $data['nama_karyawan']);
        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $karyawan = $this->model->find($id);
        if (!$karyawan) return redirect()->to('/admin/karyawan')->with('error', 'Karyawan tidak ditemukan.');

        $jabatanModel = new JabatanModel();
        return view('admin/karyawan/form', [
            'title'    => 'Edit Karyawan',
            'karyawan' => $karyawan,
            'jabatan'  => $jabatanModel->withDepartemen(),
        ]);
    }

    public function update(int $id)
    {
        $karyawan = $this->model->find($id);
        if (!$karyawan) return redirect()->to('/admin/karyawan')->with('error', 'Karyawan tidak ditemukan.');

        $rules = [
            'nama_karyawan'     => 'required|min_length[2]|max_length[150]',
            'id_jabatan'        => 'required|numeric',
            'nik'               => 'permit_empty|numeric',
            'npwp'              => 'permit_empty|numeric',
            'no_hp'             => 'permit_empty|numeric',
            'no_rekening'       => 'permit_empty|numeric',
            'no_bpjs_kesehatan' => 'permit_empty|numeric',
            'no_bpjs_tk'        => 'permit_empty|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle foto upload
        $foto = $this->request->getFile('foto');
        $namaFoto = $karyawan['foto'];
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama
            if ($namaFoto && file_exists(FCPATH . 'uploads/karyawan/' . $namaFoto)) {
                unlink(FCPATH . 'uploads/karyawan/' . $namaFoto);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/karyawan', $namaFoto);
        }

        $data = [
            'id_jabatan'        => $this->request->getPost('id_jabatan'),
            'nik'               => $this->request->getPost('nik'),
            'npwp'              => $this->request->getPost('npwp'),
            'nama_karyawan'     => $this->request->getPost('nama_karyawan'),
            'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir'     => $this->request->getPost('tanggal_lahir') ?: null,
            'alamat'            => $this->request->getPost('alamat'),
            'no_hp'             => $this->request->getPost('no_hp'),
            'email'             => $this->request->getPost('email'),
            'tanggal_masuk'     => $this->request->getPost('tanggal_masuk') ?: null,
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'no_rekening'       => $this->request->getPost('no_rekening'),
            'nama_bank'         => $this->request->getPost('nama_bank'),
            'no_bpjs_kesehatan' => $this->request->getPost('no_bpjs_kesehatan'),
            'no_bpjs_tk'        => $this->request->getPost('no_bpjs_tk'),
            'status'            => $this->request->getPost('status'),
            'foto'              => $namaFoto,
        ];

        $this->model->update($id, $data);
        AuditLogModel::catat('UPDATE', 'karyawan', $id, 'Update karyawan: ' . $data['nama_karyawan']);
        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $karyawan = $this->model->find($id);
        if (!$karyawan) return redirect()->to('/admin/karyawan')->with('error', 'Karyawan tidak ditemukan.');

        try {
            // Hapus foto jika ada
            if (!empty($karyawan['foto']) && file_exists(FCPATH . 'uploads/karyawan/' . $karyawan['foto'])) {
                unlink(FCPATH . 'uploads/karyawan/' . $karyawan['foto']);
            }

            // Hapus akun user terkait jika ada
            $userModel = new \App\Models\UserModel();
            $userModel->where('id_karyawan', $id)->delete();

            // Hapus data karyawan
            $this->model->delete($id);

            AuditLogModel::catat('DELETE', 'karyawan', $id, 'Hapus karyawan: ' . $karyawan['nama_karyawan']);
            return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/admin/karyawan')->with('error', 'Gagal menghapus karyawan karena data terkait dengan riwayat penggajian.');
        }
    }

    public function detail(int $id)
    {
        $karyawan = $this->model->getDetail($id);
        if (!$karyawan) return redirect()->to('/admin/karyawan')->with('error', 'Karyawan tidak ditemukan.');

        return view('admin/karyawan/detail', [
            'title'    => 'Detail Karyawan',
            'karyawan' => $karyawan,
        ]);
    }
}
