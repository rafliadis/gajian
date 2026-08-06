<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DepartemenModel;
use App\Models\AuditLogModel;

class Departemen extends BaseController
{
    protected DepartemenModel $model;

    public function __construct()
    {
        $this->model = new DepartemenModel();
    }

    public function index()
    {
        return view('admin/departemen/index', [
            'title'      => 'Data Departemen',
            'departemen' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('admin/departemen/form', [
            'title' => 'Tambah Departemen',
            'departemen' => null,
        ]);
    }

    public function save()
    {
        $rules = ['nama_departemen' => 'required|min_length[2]|max_length[100]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'nama_departemen' => $this->request->getPost('nama_departemen'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
        ]);

        AuditLogModel::catat('CREATE', 'departemen', $this->model->getInsertID(), 'Tambah departemen: ' . $this->request->getPost('nama_departemen'));
        return redirect()->to('/admin/departemen')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $departemen = $this->model->find($id);
        if (!$departemen) return redirect()->to('/admin/departemen')->with('error', 'Departemen tidak ditemukan.');

        return view('admin/departemen/form', [
            'title'      => 'Edit Departemen',
            'departemen' => $departemen,
        ]);
    }

    public function update(int $id)
    {
        $rules = ['nama_departemen' => 'required|min_length[2]|max_length[100]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'nama_departemen' => $this->request->getPost('nama_departemen'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
        ]);

        AuditLogModel::catat('UPDATE', 'departemen', $id, 'Update departemen ID: ' . $id);
        return redirect()->to('/admin/departemen')->with('success', 'Departemen berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $departemen = $this->model->find($id);
        if (!$departemen) return redirect()->to('/admin/departemen')->with('error', 'Departemen tidak ditemukan.');

        $this->model->delete($id);
        AuditLogModel::catat('DELETE', 'departemen', $id, 'Hapus departemen: ' . $departemen['nama_departemen']);
        return redirect()->to('/admin/departemen')->with('success', 'Departemen berhasil dihapus.');
    }
}
