<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PayrollPeriodeModel;
use App\Models\PayrollDetailModel;

class Laporan extends BaseController
{
    public function index()
    {
        $periodeModel = new PayrollPeriodeModel();
        return view('admin/laporan/index', [
            'title'   => 'Laporan Penggajian',
            'periode' => $periodeModel->getFinalized(),
        ]);
    }

    public function export(int $idPeriode)
    {
        // Gunakan instance model baru agar query builder fresh
        $periodeModel = new PayrollPeriodeModel();
        $periode = $periodeModel->find($idPeriode);

        if (!$periode) {
            return redirect()->to('/admin/laporan')->with('error', 'Periode tidak ditemukan.');
        }

        // Gunakan instance terpisah untuk setiap query
        $detailModel  = new PayrollDetailModel();
        $detail       = $detailModel->getByPeriode($idPeriode);

        $detailModel2 = new PayrollDetailModel();
        $totalGaji    = $detailModel2->getTotalPeriode($idPeriode);

        // Export PDF (rekap)
        return view('admin/laporan/export_pdf', [
            'periode'   => $periode,
            'detail'    => $detail,
            'totalGaji' => $totalGaji,
        ]);
    }
}
