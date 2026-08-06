<?php

namespace App\Controllers\Karyawan;

use App\Controllers\BaseController;
use App\Models\PayrollDetailModel;
use App\Models\KaryawanModel;
use App\Models\AuditLogModel;

class SlipGaji extends BaseController
{
    /**
     * FR-5.1: Daftar slip gaji milik karyawan ini
     */
    public function index()
    {
        $idKaryawan = session()->get('id_karyawan');

        if (!$idKaryawan) {
            return redirect()->to('/login')->with('error', 'Akun Anda belum terhubung ke data karyawan. Hubungi admin.');
        }

        $detailModel   = new PayrollDetailModel();
        $karyawanModel = new KaryawanModel();

        $karyawan = $karyawanModel->getDetail($idKaryawan);
        $riwayat  = $detailModel->getRiwayatKaryawan($idKaryawan);

        return view('karyawan/slip_gaji/index', [
            'title'     => 'Slip Gaji Saya',
            'karyawan'  => $karyawan,
            'riwayat'   => $riwayat,
        ]);
    }

    /**
     * FR-5.2: Detail slip gaji dengan IDOR protection
     */
    public function detail(int $idDetail)
    {
        $idKaryawan = session()->get('id_karyawan');
        $detailModel = new PayrollDetailModel();

        $slip = $detailModel->select('payroll_detail.*, karyawan.nama_karyawan, karyawan.nik, karyawan.npwp, karyawan.status_pernikahan, karyawan.no_rekening, karyawan.nama_bank, karyawan.no_bpjs_kesehatan, karyawan.no_bpjs_tk, jabatan.nama_jabatan, departemen.nama_departemen, payroll_periode.nama_periode, payroll_periode.bulan, payroll_periode.tahun, payroll_periode.status')
                           ->join('karyawan', 'karyawan.id_karyawan = payroll_detail.id_karyawan')
                           ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left')
                           ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
                           ->join('payroll_periode', 'payroll_periode.id_periode = payroll_detail.id_periode')
                           ->find($idDetail);

        if (!$slip) {
            return redirect()->to('/karyawan/slip-gaji')->with('error', 'Slip gaji tidak ditemukan.');
        }

        // ── FR-5.4 & FR-7.1: IDOR Protection ──
        if ((int) $slip['id_karyawan'] !== (int) $idKaryawan) {
            AuditLogModel::catat('IDOR_ATTEMPT', 'payroll_detail', $idDetail, 'Percobaan akses slip gaji orang lain.');
            return redirect()->to('/karyawan/slip-gaji')->with('error', 'Anda tidak memiliki izin untuk mengakses data ini.');
        }

        // Hanya bisa lihat yang sudah finalized
        if ($slip['status'] !== 'finalized') {
            return redirect()->to('/karyawan/slip-gaji')->with('error', 'Slip gaji belum tersedia.');
        }

        return view('karyawan/slip_gaji/detail', [
            'title' => 'Detail Slip Gaji - ' . $slip['nama_periode'],
            'slip'  => $slip,
        ]);
    }

    /**
     * FR-5.3: Download PDF slip gaji — dengan IDOR protection
     */
    public function download(int $idDetail)
    {
        $idKaryawan  = session()->get('id_karyawan');
        $detailModel = new PayrollDetailModel();

        $slip = $detailModel->select('payroll_detail.*, karyawan.nama_karyawan, karyawan.nik, karyawan.npwp, karyawan.status_pernikahan, karyawan.no_rekening, karyawan.nama_bank, karyawan.no_bpjs_kesehatan, karyawan.no_bpjs_tk, jabatan.nama_jabatan, departemen.nama_departemen, payroll_periode.nama_periode, payroll_periode.bulan, payroll_periode.tahun, payroll_periode.status')
                           ->join('karyawan', 'karyawan.id_karyawan = payroll_detail.id_karyawan')
                           ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left')
                           ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
                           ->join('payroll_periode', 'payroll_periode.id_periode = payroll_detail.id_periode')
                           ->find($idDetail);

        if (!$slip) {
            return redirect()->to('/karyawan/slip-gaji')->with('error', 'Slip gaji tidak ditemukan.');
        }

        // ── IDOR Protection ──
        if ((int) $slip['id_karyawan'] !== (int) $idKaryawan) {
            AuditLogModel::catat('IDOR_ATTEMPT', 'payroll_detail', $idDetail, 'Percobaan download slip gaji orang lain.');
            return redirect()->to('/karyawan/slip-gaji')->with('error', 'Anda tidak memiliki izin untuk mengakses data ini.');
        }

        if ($slip['status'] !== 'finalized') {
            return redirect()->to('/karyawan/slip-gaji')->with('error', 'Slip gaji belum tersedia.');
        }

        AuditLogModel::catat('DOWNLOAD_SLIP', 'payroll_detail', $idDetail, 'Download slip gaji: ' . $slip['nama_periode']);

        $html = view('karyawan/slip_gaji/pdf_template', ['slip' => $slip]);

        if (class_exists('\Dompdf\Dompdf')) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $namaFile = 'slip_gaji_' . str_replace(' ', '_', $slip['nama_karyawan']) . '_' . $slip['nama_periode'] . '.pdf';
            $dompdf->stream($namaFile, ['Attachment' => true]);
            exit;
        }

        // Fallback print
        return $this->response->setBody($html);
    }
}
