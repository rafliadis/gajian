<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\KaryawanModel;
use App\Models\AuditLogModel;

class Akun extends BaseController
{
    public function index()
    {
        $userModel     = new UserModel();
        $karyawanModel = new KaryawanModel();

        $users     = $userModel->findAll();
        $karyawan  = $karyawanModel->getAllWithJabatan();

        // Tandai karyawan yang sudah punya akun
        $karyawanDenganAkun = array_column($users, 'id_karyawan');
        foreach ($karyawan as &$k) {
            $k['has_akun'] = in_array($k['id_karyawan'], $karyawanDenganAkun);
        }

        return view('admin/akun/index', [
            'title'    => 'Manajemen Akun',
            'users'    => $users,
            'karyawan' => $karyawan,
        ]);
    }

    public function buatAkunForm(int $idKaryawan)
    {
        $karyawanModel = new KaryawanModel();
        $karyawan = $karyawanModel->find($idKaryawan);
        if (!$karyawan) return redirect()->to('/admin/akun')->with('error', 'Karyawan tidak ditemukan.');

        return view('admin/akun/buat_akun', [
            'title'    => 'Buat Akun: ' . $karyawan['nama_karyawan'],
            'karyawan' => $karyawan,
        ]);
    }

    public function buatAkun(int $idKaryawan)
    {
        $userModel     = new UserModel();
        $karyawanModel = new KaryawanModel();

        $karyawan = $karyawanModel->find($idKaryawan);
        if (!$karyawan) return redirect()->to('/admin/akun')->with('error', 'Karyawan tidak ditemukan.');

        // Cek apakah sudah ada akun
        $existing = $userModel->where('id_karyawan', $idKaryawan)->first();
        if ($existing) {
            return redirect()->to('/admin/akun')->with('error', 'Karyawan ini sudah memiliki akun.');
        }

        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel->insert([
            'id_karyawan' => $idKaryawan,
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'        => 'karyawan',
            'is_active'   => 1,
        ]);

        AuditLogModel::catat('CREATE_AKUN', 'users', $idKaryawan, 'Buat akun karyawan: ' . $karyawan['nama_karyawan']);
        return redirect()->to('/admin/akun')->with('success', 'Akun karyawan berhasil dibuat.');
    }

    public function resetPasswordForm(int $idUser)
    {
        $userModel = new UserModel();
        $user = $userModel->find($idUser);
        if (!$user) return redirect()->to('/admin/akun')->with('error', 'User tidak ditemukan.');

        return view('admin/akun/reset_password', [
            'title' => 'Reset Password',
            'user'  => $user,
        ]);
    }

    public function resetPassword(int $idUser)
    {
        $userModel = new UserModel();
        $user = $userModel->find($idUser);
        if (!$user) return redirect()->to('/admin/akun')->with('error', 'User tidak ditemukan.');

        $rules = ['password' => 'required|min_length[6]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel->update($idUser, [
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);

        AuditLogModel::catat('RESET_PASSWORD', 'users', $idUser, 'Reset password user: ' . $user['username']);
        return redirect()->to('/admin/akun')->with('success', 'Password berhasil direset.');
    }

    public function ubahPasswordForm()
    {
        return view('admin/akun/ubah_password', ['title' => 'Ubah Password Admin']);
    }

    public function ubahPassword()
    {
        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));

        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[6]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (!password_verify($this->request->getPost('password_lama'), $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai.');
        }

        $userModel->update($user['id'], [
            'password' => password_hash($this->request->getPost('password_baru'), PASSWORD_BCRYPT),
        ]);

        AuditLogModel::catat('UBAH_PASSWORD', 'users', $user['id'], 'Admin ubah password sendiri');
        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    public function toggle(int $idUser)
    {
        $userModel = new UserModel();
        $user = $userModel->find($idUser);
        if (!$user) return redirect()->to('/admin/akun')->with('error', 'User tidak ditemukan.');

        $newStatus = $user['is_active'] ? 0 : 1;
        $userModel->update($idUser, ['is_active' => $newStatus]);

        $label = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
        AuditLogModel::catat('TOGGLE_AKUN', 'users', $idUser, "Akun {$user['username']} {$label}");
        return redirect()->to('/admin/akun')->with('success', "Akun {$user['username']} berhasil {$label}.");
    }
}
