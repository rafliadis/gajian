<?php

namespace App\Controllers\Karyawan;

use App\Controllers\BaseController;
use App\Models\PayrollDetailModel;
use App\Models\KaryawanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Redirect ke halaman slip gaji (sesuai PRD: default tampilan karyawan)
        return redirect()->to('/karyawan/slip-gaji');
    }
}
