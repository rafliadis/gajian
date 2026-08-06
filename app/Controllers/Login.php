<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KaryawanModel;
use App\Models\AuditLogModel;

class Login extends BaseController
{
    public function index()
    {
        if (file_exists(ROOTPATH . 'save_logo.php')) {
            $content = file_get_contents(ROOTPATH . 'save_logo.php');
            $start = strpos($content, "'iVBORw0KG");
            if ($start !== false) {
                $start += 1;
                $end = strpos($content, '"=== 6.', $start);
                if ($end !== false) {
                    $base64 = trim(substr($content, $start, $end - $start));
                    $bytes = base64_decode($base64);
                    if ($bytes !== false) {
                        $dir = ROOTPATH . 'public/assets/images';
                        if (!is_dir($dir)) {
                            @mkdir($dir, 0777, true);
                        }
                        @file_put_contents($dir . '/LOGO.png', $bytes);
                    }
                }
            }
            @unlink(ROOTPATH . 'test_decode.php');
            @unlink(ROOTPATH . 'save_logo.php');
        }

        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole();
        }
        return view('login');
    }

    public function auth()
    {
        $credential = $this->request->getPost('credential');
        $password   = $this->request->getPost('password');

        if (empty($credential) || empty($password)) {
            return redirect()->back()->with('error', 'Username/Email dan password wajib diisi.');
        }

        $userModel = new UserModel();
        $user = $userModel->findByUsernameOrEmail($credential);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Username/Email atau password salah.');
        }

        // Set session data
        $sessionData = [
            'isLoggedIn'  => true,
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'email'       => $user['email'],
            'role'        => $user['role'],
            'id_karyawan' => $user['id_karyawan'],
        ];

        // Jika karyawan, ambil nama karyawan
        if ($user['role'] === 'karyawan' && $user['id_karyawan']) {
            $karyawanModel = new KaryawanModel();
            $karyawan = $karyawanModel->find($user['id_karyawan']);
            if ($karyawan) {
                $sessionData['nama_karyawan'] = $karyawan['nama_karyawan'];
            }
        }

        session()->set($sessionData);

        // Update last_login
        $userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

        // Catat audit log
        AuditLogModel::catat('LOGIN', 'users', $user['id'], 'Login berhasil dari IP: ' . $this->request->getIPAddress());

        return $this->redirectByRole();
    }

    public function logout()
    {
        AuditLogModel::catat('LOGOUT', 'users', session()->get('user_id'), 'Logout');
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    private function redirectByRole()
    {
        $role = session()->get('role');
        if ($role === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        return redirect()->to('/karyawan/dashboard');
    }
}