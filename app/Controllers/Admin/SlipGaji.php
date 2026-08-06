<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PayrollPeriodeModel;
use App\Models\PayrollDetailModel;
use App\Models\AuditLogModel;

class SlipGaji extends BaseController
{
    public function index()
    {
        $periodeModel = new PayrollPeriodeModel();
        return view('admin/slip_gaji/index', [
            'title'   => 'Slip Gaji Karyawan',
            'periode' => $periodeModel->getFinalized(),
        ]);
    }

    public function periode(int $idPeriode)
    {
        $periodeModel = new PayrollPeriodeModel();
        $detailModel  = new PayrollDetailModel();

        $periode = $periodeModel->find($idPeriode);
        if (!$periode || $periode['status'] !== 'finalized') {
            return redirect()->to('/admin/slip-gaji')->with('error', 'Periode belum difinalisasi atau tidak ditemukan.');
        }

        $detail    = $detailModel->getByPeriode($idPeriode);

        $detailModel2 = new PayrollDetailModel();
        $totalGaji    = $detailModel2->getTotalPeriode($idPeriode);

        return view('admin/slip_gaji/periode', [
            'title'     => 'Slip Gaji: ' . $periode['nama_periode'],
            'periode'   => $periode,
            'detail'    => $detail,
            'totalGaji' => $totalGaji,
        ]);
    }

    public function cetak(int $idDetail)
    {
        $detailModel = new PayrollDetailModel();

        // Ambil detail slip gaji
        $slip = $detailModel->select('payroll_detail.*, karyawan.nama_karyawan, karyawan.nik, karyawan.npwp, karyawan.status_pernikahan, karyawan.no_rekening, karyawan.nama_bank, karyawan.no_bpjs_kesehatan, karyawan.no_bpjs_tk, jabatan.nama_jabatan, departemen.nama_departemen, payroll_periode.nama_periode, payroll_periode.bulan, payroll_periode.tahun')
                            ->join('karyawan', 'karyawan.id_karyawan = payroll_detail.id_karyawan')
                            ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left')
                            ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
                            ->join('payroll_periode', 'payroll_periode.id_periode = payroll_detail.id_periode')
                            ->find($idDetail);

        if (!$slip) return redirect()->to('/admin/slip-gaji')->with('error', 'Slip gaji tidak ditemukan.');

        AuditLogModel::catat('CETAK_SLIP', 'payroll_detail', $idDetail, 'Cetak slip gaji karyawan: ' . $slip['nama_karyawan']);

        // Generate PDF
        return $this->generatePdf($slip);
    }

    private function generatePdf(array $slip)
    {
        $html = view('admin/slip_gaji/pdf_template', ['slip' => $slip]);

        // Gunakan dompdf jika tersedia
        if (class_exists('\Dompdf\Dompdf')) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('slip_gaji_' . $slip['nama_karyawan'] . '_' . $slip['nama_periode'] . '.pdf', ['Attachment' => false]);
            exit;
        }

        // Fallback: tampilkan HTML untuk print
        return $this->response->setBody($html);
    }
}
