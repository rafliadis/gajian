<?php

namespace App\Controllers;

use App\Models\JabatanModel;

class Jabatan extends BaseController
{
    public function index()
    {
        $model = new JabatanModel();
        $data['jabatan'] = $model->findAll();
        return view('jabatan/index', $data);
    }

    public function create()
    {
        return view('jabatan/create');
    }

    public function save()
    {
        $model = new JabatanModel();
        $model->save([
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'gaji_pokok'   => $this->request->getPost('gaji_pokok'),
            'tunjangan'    => $this->request->getPost('tunjangan'),
            'no_hp'        => $this->request->getPost('no_hp'),
        ]);
        return redirect()->to('/jabatan');
    }

    public function edit($id)
    {
        $model = new JabatanModel();
        $data['jabatan'] = $model->find($id);
        return view('jabatan/edit', $data);
    }

    public function update($id)
    {
        $model = new JabatanModel();
        // Menggunakan update($id, $data) agar data lama ditimpa (tidak duplikat)
        $model->update($id, [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'gaji_pokok'   => $this->request->getPost('gaji_pokok'),
            'tunjangan'    => $this->request->getPost('tunjangan'),
            'no_hp'        => $this->request->getPost('no_hp'),
        ]);
        
        return redirect()->to('/jabatan')->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $model = new JabatanModel();
        $model->delete($id);
        return redirect()->to('/jabatan');
    }
    
}