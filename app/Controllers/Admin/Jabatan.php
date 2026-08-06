<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Models\DepartemenModel;
use App\Models\AuditLogModel;

class Jabatan extends BaseController
{
    protected JabatanModel $model;

    public function __construct()
    {
        $this->model = new JabatanModel();
    }

    public function index()
    {
        return view('admin/jabatan/index', [
            'title'   => 'Data Jabatan',
            'jabatan' => $this->model->withDepartemen(),
        ]);
    }

    public function create()
    {
        $depModel = new DepartemenModel();
        return view('admin/jabatan/form', [
            'title'      => 'Tambah Jabatan',
            'jabatan'    => null,
            'departemen' => $depModel->findAll(),
        ]);
    }

    public function save()
    {
        $rules = [
            'nama_jabatan' => 'required|min_length[2]',
            'gaji_pokok'   => 'required|numeric|greater_than[0]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'id_departemen'   => $this->request->getPost('id_departemen') ?: null,
            'nama_jabatan'    => $this->request->getPost('nama_jabatan'),
            'gaji_pokok'      => $this->request->getPost('gaji_pokok'),
            'tunjangan_tetap' => $this->request->getPost('tunjangan_tetap') ?: 0,
        ]);

        AuditLogModel::catat('CREATE', 'jabatan', $this->model->getInsertID(), 'Tambah jabatan: ' . $this->request->getPost('nama_jabatan'));
        return redirect()->to('/admin/jabatan')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $jabatan = $this->model->find($id);
        if (!$jabatan) return redirect()->to('/admin/jabatan')->with('error', 'Jabatan tidak ditemukan.');

        $depModel = new DepartemenModel();
        return view('admin/jabatan/form', [
            'title'      => 'Edit Jabatan',
            'jabatan'    => $jabatan,
            'departemen' => $depModel->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'nama_jabatan' => 'required|min_length[2]',
            'gaji_pokok'   => 'required|numeric|greater_than[0]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'id_departemen'   => $this->request->getPost('id_departemen') ?: null,
            'nama_jabatan'    => $this->request->getPost('nama_jabatan'),
            'gaji_pokok'      => $this->request->getPost('gaji_pokok'),
            'tunjangan_tetap' => $this->request->getPost('tunjangan_tetap') ?: 0,
        ]);

        AuditLogModel::catat('UPDATE', 'jabatan', $id, 'Update jabatan ID: ' . $id);
        return redirect()->to('/admin/jabatan')->with('success', 'Jabatan berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $jabatan = $this->model->find($id);
        if (!$jabatan) return redirect()->to('/admin/jabatan')->with('error', 'Jabatan tidak ditemukan.');

        $this->model->delete($id);
        AuditLogModel::catat('DELETE', 'jabatan', $id, 'Hapus jabatan: ' . $jabatan['nama_jabatan']);
        return redirect()->to('/admin/jabatan')->with('success', 'Jabatan berhasil dihapus.');
    }
}
