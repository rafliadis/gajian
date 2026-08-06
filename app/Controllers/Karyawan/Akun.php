<?php

namespace App\Controllers\Karyawan;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AuditLogModel;

class Akun extends BaseController
{
    public function ubahPasswordForm()
    {
        return view('karyawan/akun/ubah_password', ['title' => 'Ubah Password']);
    }

    public function ubahPassword()
    {
        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));

        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[6]',
            'konfirmasi'    => 'required|matches[password_baru]',
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

        AuditLogModel::catat('UBAH_PASSWORD', 'users', $user['id'], 'Karyawan ubah password');
        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
