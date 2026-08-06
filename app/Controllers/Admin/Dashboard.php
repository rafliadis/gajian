<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\PayrollPeriodeModel;
use App\Models\AuditLogModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $karyawanModel = new KaryawanModel();
        $periodeModel  = new PayrollPeriodeModel();
        $auditModel    = new AuditLogModel();

        // Hitung statistik
        $totalKaryawan = $karyawanModel->countAktif();
        $allPeriode    = $periodeModel->getAll();
        $periodeBerjalan = null;
        $periodeFinalized = 0;
        foreach ($allPeriode as $p) {
            if ($p['status'] === 'draft' || $p['status'] === 'preview') {
                $periodeBerjalan = $p;
            }
            if ($p['status'] === 'finalized') {
                $periodeFinalized++;
            }
        }

        // Rekap terakhir yang finalized
        $lastFinalized = null;
        foreach ($allPeriode as $p) {
            if ($p['status'] === 'finalized') {
                $lastFinalized = $p;
                break;
            }
        }

        $recentLog = $auditModel->getRecent(10);

        $data = [
            'title'            => 'Dashboard Admin',
            'totalKaryawan'    => $totalKaryawan,
            'totalPeriode'     => count($allPeriode),
            'periodeFinalized' => $periodeFinalized,
            'periodeBerjalan'  => $periodeBerjalan,
            'lastFinalized'    => $lastFinalized,
            'recentLog'        => $recentLog,
        ];

        return view('admin/dashboard', $data);
    }
}
