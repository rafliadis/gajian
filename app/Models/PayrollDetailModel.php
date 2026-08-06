<?php

namespace App\Models;

use CodeIgniter\Model;

class PayrollDetailModel extends Model
{
    protected $table      = 'payroll_detail';
    protected $primaryKey = 'id_detail';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_periode', 'id_karyawan',
        'gaji_pokok', 'tunjangan_tetap', 'tunjangan_tidak_tetap', 'bonus', 'total_pendapatan',
        'potongan_bpjs_kes_karyawan', 'potongan_bpjs_tk_jht', 'potongan_bpjs_tk_jp',
        'potongan_pph21', 'potongan_lain', 'total_potongan',
        'bpjs_kes_perusahaan', 'bpjs_tk_perusahaan',
        'gaji_bersih', 'koreksi_nominal', 'koreksi_keterangan', 'is_koreksi',
    ];

    /**
     * Ambil detail payroll dengan info karyawan & jabatan
     * Menggunakan fresh query builder ($db->table) agar tidak tercemar state sebelumnya.
     */
    public function getByPeriode(int $idPeriode): array
    {
        return $this->db->table('payroll_detail')
            ->select('payroll_detail.*, karyawan.nama_karyawan, karyawan.nik, jabatan.nama_jabatan, departemen.nama_departemen')
            ->join('karyawan', 'karyawan.id_karyawan = payroll_detail.id_karyawan')
            ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left')
            ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
            ->where('payroll_detail.id_periode', $idPeriode)
            ->orderBy('karyawan.nama_karyawan', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil slip gaji karyawan tertentu di suatu periode
     */
    public function getByKaryawanAndPeriode(int $idKaryawan, int $idPeriode): ?array
    {
        return $this->db->table('payroll_detail')
            ->select('payroll_detail.*, karyawan.nama_karyawan, karyawan.nik, karyawan.no_rekening, karyawan.nama_bank, jabatan.nama_jabatan, departemen.nama_departemen, payroll_periode.nama_periode, payroll_periode.bulan, payroll_periode.tahun')
            ->join('karyawan', 'karyawan.id_karyawan = payroll_detail.id_karyawan')
            ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left')
            ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
            ->join('payroll_periode', 'payroll_periode.id_periode = payroll_detail.id_periode')
            ->where('payroll_detail.id_karyawan', $idKaryawan)
            ->where('payroll_detail.id_periode', $idPeriode)
            ->get()
            ->getRowArray();
    }

    /**
     * Ambil semua slip gaji milik karyawan tertentu (finalized saja)
     */
    public function getRiwayatKaryawan(int $idKaryawan): array
    {
        return $this->db->table('payroll_detail')
            ->select('payroll_detail.*, payroll_periode.nama_periode, payroll_periode.bulan, payroll_periode.tahun, payroll_periode.status, payroll_periode.tanggal_finalisasi')
            ->join('payroll_periode', 'payroll_periode.id_periode = payroll_detail.id_periode')
            ->where('payroll_detail.id_karyawan', $idKaryawan)
            ->where('payroll_periode.status', 'finalized')
            ->orderBy('payroll_periode.tahun', 'DESC')
            ->orderBy('payroll_periode.bulan', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Total gaji bersih seluruh karyawan dalam satu periode
     */
    public function getTotalPeriode(int $idPeriode): float
    {
        $result = $this->db->table('payroll_detail')
            ->selectSum('gaji_bersih', 'total')
            ->where('id_periode', $idPeriode)
            ->get()
            ->getRowArray();

        return $result['total'] ?? 0;
    }
}
