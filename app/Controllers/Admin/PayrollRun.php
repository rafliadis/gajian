<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PayrollPeriodeModel;
use App\Models\PayrollDetailModel;
use App\Models\KaryawanModel;
use App\Models\JabatanModel;
use App\Models\KomponenGajiModel;
use App\Models\AuditLogModel;

class PayrollRun extends BaseController
{
    public function index()
    {
        $periodeModel = new PayrollPeriodeModel();
        return view('admin/payroll/index', [
            'title'   => 'Payroll Run',
            'periode' => $periodeModel->getAll(),
        ]);
    }

    public function create()
    {
        return view('admin/payroll/create', [
            'title' => 'Buat Periode Payroll Baru',
        ]);
    }

    /**
     * FR-4.1 & FR-4.2: Buka periode & hitung otomatis
     */
    public function run()
    {
        $bulan = (int) $this->request->getPost('bulan');
        $tahun = (int) $this->request->getPost('tahun');

        if ($bulan < 1 || $bulan > 12 || $tahun < 2020) {
            return redirect()->back()->with('error', 'Bulan atau tahun tidak valid.');
        }

        $periodeModel = new PayrollPeriodeModel();
        $detailModel  = new PayrollDetailModel();
        $karyawanModel = new KaryawanModel();
        $komponenModel = new KomponenGajiModel();

        // Cek apakah periode sudah ada
        if ($periodeModel->cekPeriodeAda($bulan, $tahun)) {
            return redirect()->back()->with('error', 'Periode ' . $this->namaBulan($bulan) . ' ' . $tahun . ' sudah ada!');
        }

        $namaBulan = $this->namaBulan($bulan);

        // Buat record periode
        $periodeModel->insert([
            'bulan'        => $bulan,
            'tahun'        => $tahun,
            'nama_periode' => $namaBulan . ' ' . $tahun,
            'status'       => 'preview',
            'tanggal_run'  => date('Y-m-d H:i:s'),
        ]);
        $idPeriode = $periodeModel->getInsertID();

        // Ambil semua karyawan aktif
        $karyawanList = $karyawanModel->getAktif();

        foreach ($karyawanList as $k) {
            $komponen = $komponenModel->getByKaryawan($k['id_karyawan']);

            $gajiPokok        = (float) ($k['gaji_pokok'] ?? 0);
            $tunjanganTetap   = (float) ($k['tunjangan_tetap'] ?? 0);
            $tunjanganTidakTetap = (float) ($komponen['tunjangan_tidak_tetap'] ?? 0);
            $bonus            = (float) ($komponen['bonus'] ?? 0);
            $potonganLain     = (float) ($komponen['potongan_lain'] ?? 0);

            $ikutBpjsKes = $komponen ? (int) $komponen['ikut_bpjs_kesehatan'] : 1;
            $ikutBpjsTk  = $komponen ? (int) $komponen['ikut_bpjs_tk'] : 1;
            $kenaPph21   = $komponen ? (int) $komponen['kena_pph21'] : 1;

            $totalPendapatan = $gajiPokok + $tunjanganTetap + $tunjanganTidakTetap + $bonus;

            // ── Hitung BPJS Kesehatan ──
            $bpjsKesKaryawan  = $ikutBpjsKes ? round($gajiPokok * 0.01) : 0;
            $bpjsKesPerusahaan = $ikutBpjsKes ? round($gajiPokok * 0.04) : 0;

            // ── Hitung BPJS Ketenagakerjaan ──
            // JHT: 2% karyawan + 3.7% perusahaan
            // JP: 1% karyawan + 2% perusahaan
            $bpjsTkJht = $ikutBpjsTk ? round($gajiPokok * 0.02) : 0;
            $bpjsTkJp  = $ikutBpjsTk ? round($gajiPokok * 0.01) : 0;
            $bpjsTkPerusahaan = $ikutBpjsTk ? round($gajiPokok * 0.057) : 0;

            // ── Hitung PPh 21 (Metode sederhana: gross annualized) ──
            $pph21 = 0;
            if ($kenaPph21) {
                $pph21 = $this->hitungPph21(
                    $gajiPokok + $tunjanganTetap,
                    $k['status_pernikahan'] ?? 'TK',
                    $bpjsKesKaryawan + $bpjsTkJht + $bpjsTkJp
                );
            }

            $totalPotongan = $bpjsKesKaryawan + $bpjsTkJht + $bpjsTkJp + $pph21 + $potonganLain;
            $gajiBersih    = $totalPendapatan - $totalPotongan;

            $detailModel->insert([
                'id_periode'                  => $idPeriode,
                'id_karyawan'                 => $k['id_karyawan'],
                'gaji_pokok'                  => $gajiPokok,
                'tunjangan_tetap'             => $tunjanganTetap,
                'tunjangan_tidak_tetap'       => $tunjanganTidakTetap,
                'bonus'                       => $bonus,
                'total_pendapatan'            => $totalPendapatan,
                'potongan_bpjs_kes_karyawan'  => $bpjsKesKaryawan,
                'potongan_bpjs_tk_jht'        => $bpjsTkJht,
                'potongan_bpjs_tk_jp'         => $bpjsTkJp,
                'potongan_pph21'              => $pph21,
                'potongan_lain'               => $potonganLain,
                'total_potongan'              => $totalPotongan,
                'bpjs_kes_perusahaan'         => $bpjsKesPerusahaan,
                'bpjs_tk_perusahaan'          => $bpjsTkPerusahaan,
                'gaji_bersih'                 => $gajiBersih,
            ]);
        }

        AuditLogModel::catat('PAYROLL_RUN', 'payroll_periode', $idPeriode, "Payroll run untuk {$namaBulan} {$tahun}, " . count($karyawanList) . " karyawan.");
        return redirect()->to('/admin/payroll/preview/' . $idPeriode)->with('success', 'Payroll run berhasil! Silakan review sebelum finalisasi.');
    }

    /**
     * FR-4.5: Preview sebelum finalisasi
     */
    public function preview(int $idPeriode)
    {
        $periodeModel = new PayrollPeriodeModel();
        $detailModel  = new PayrollDetailModel();

        $periode = $periodeModel->find($idPeriode);
        if (!$periode) return redirect()->to('/admin/payroll')->with('error', 'Periode tidak ditemukan.');

        $detail = $detailModel->getByPeriode($idPeriode);
        $totalGaji = $detailModel->getTotalPeriode($idPeriode);

        return view('admin/payroll/preview', [
            'title'     => 'Preview Payroll: ' . $periode['nama_periode'],
            'periode'   => $periode,
            'detail'    => $detail,
            'totalGaji' => $totalGaji,
        ]);
    }

    /**
     * FR-4.5: Koreksi manual per karyawan
     */
    public function koreksi(int $idDetail)
    {
        $detailModel = new PayrollDetailModel();
        $detail = $detailModel->find($idDetail);

        if (!$detail) return redirect()->back()->with('error', 'Data tidak ditemukan.');

        // Cek periode masih dalam status preview
        $periodeModel = new PayrollPeriodeModel();
        $periode = $periodeModel->find($detail['id_periode']);
        if ($periode['status'] === 'finalized') {
            return redirect()->back()->with('error', 'Periode sudah difinalisasi, tidak bisa dikoreksi.');
        }

        $koreksiNominal    = (float) $this->request->getPost('koreksi_nominal');
        $koreksiKeterangan = $this->request->getPost('koreksi_keterangan');

        // Update gaji bersih dengan koreksi
        $gajiBersiBaru = $detail['gaji_bersih'] + $koreksiNominal;

        $detailModel->update($idDetail, [
            'koreksi_nominal'    => $koreksiNominal,
            'koreksi_keterangan' => $koreksiKeterangan,
            'gaji_bersih'        => $gajiBersiBaru,
            'is_koreksi'         => 1,
        ]);

        AuditLogModel::catat('KOREKSI', 'payroll_detail', $idDetail, "Koreksi nominal: {$koreksiNominal}. Alasan: {$koreksiKeterangan}");
        return redirect()->back()->with('success', 'Koreksi berhasil disimpan.');
    }

    /**
     * FR-4.6 & FR-4.7: Finalisasi payroll
     */
    public function finalisasi(int $idPeriode)
    {
        $periodeModel = new PayrollPeriodeModel();
        $periode = $periodeModel->find($idPeriode);

        if (!$periode) return redirect()->to('/admin/payroll')->with('error', 'Periode tidak ditemukan.');
        if ($periode['status'] === 'finalized') {
            return redirect()->back()->with('error', 'Periode ini sudah difinalisasi sebelumnya.');
        }

        $periodeModel->update($idPeriode, [
            'status'             => 'finalized',
            'tanggal_finalisasi' => date('Y-m-d H:i:s'),
            'difinalisasi_oleh'  => session()->get('user_id'),
        ]);

        AuditLogModel::catat('FINALIZE', 'payroll_periode', $idPeriode, 'Finalisasi payroll periode: ' . $periode['nama_periode']);
        return redirect()->to('/admin/payroll')->with('success', 'Payroll periode ' . $periode['nama_periode'] . ' berhasil difinalisasi!');
    }

    public function detail(int $idPeriode)
    {
        $periodeModel = new PayrollPeriodeModel();
        $detailModel  = new PayrollDetailModel();

        $periode = $periodeModel->find($idPeriode);
        if (!$periode) return redirect()->to('/admin/payroll')->with('error', 'Periode tidak ditemukan.');

        $detail    = $detailModel->getByPeriode($idPeriode);
        $totalGaji = $detailModel->getTotalPeriode($idPeriode);

        return view('admin/payroll/detail', [
            'title'     => 'Detail Payroll: ' . $periode['nama_periode'],
            'periode'   => $periode,
            'detail'    => $detail,
            'totalGaji' => $totalGaji,
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────
    // Helper: Hitung PPh 21 (Gross Method sederhana)
    // ────────────────────────────────────────────────────────────────────────
    private function hitungPph21(float $penghasilan, string $statusPernikahan, float $iuranBpjs): float
    {
        // PTKP 2024
        $ptkp = [
            'TK'  => 54_000_000,
            'K0'  => 58_500_000,
            'K1'  => 63_000_000,
            'K2'  => 67_500_000,
            'K3'  => 72_000_000,
        ];

        $ptkpTahunan   = $ptkp[$statusPernikahan] ?? 54_000_000;
        $penghasilanTahunan = $penghasilan * 12;
        $iuranBpjsTahunan   = $iuranBpjs * 12;

        // Biaya jabatan: 5% dari penghasilan bruto, max Rp6juta/tahun
        $biayaJabatan = min($penghasilanTahunan * 0.05, 6_000_000);

        // Penghasilan Neto
        $penghNetoTahunan = $penghasilanTahunan - $biayaJabatan - $iuranBpjsTahunan;

        // PKP
        $pkp = max(0, $penghNetoTahunan - $ptkpTahunan);

        // Tarif Progresif PPh 21 (2024)
        $pph21Tahunan = 0;
        if ($pkp <= 60_000_000) {
            $pph21Tahunan = $pkp * 0.05;
        } elseif ($pkp <= 250_000_000) {
            $pph21Tahunan = 60_000_000 * 0.05 + ($pkp - 60_000_000) * 0.15;
        } elseif ($pkp <= 500_000_000) {
            $pph21Tahunan = 60_000_000 * 0.05 + 190_000_000 * 0.15 + ($pkp - 250_000_000) * 0.25;
        } elseif ($pkp <= 5_000_000_000) {
            $pph21Tahunan = 60_000_000 * 0.05 + 190_000_000 * 0.15 + 250_000_000 * 0.25 + ($pkp - 500_000_000) * 0.30;
        } else {
            $pph21Tahunan = 60_000_000 * 0.05 + 190_000_000 * 0.15 + 250_000_000 * 0.25 + 4_500_000_000 * 0.30 + ($pkp - 5_000_000_000) * 0.35;
        }

        return round($pph21Tahunan / 12);
    }

    private function namaBulan(int $bulan): string
    {
        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $namaBulan[$bulan] ?? '';
    }
}
