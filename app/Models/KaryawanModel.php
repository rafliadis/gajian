<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table      = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_jabatan', 'nik', 'npwp', 'nama_karyawan', 'jenis_kelamin',
        'tanggal_lahir', 'alamat', 'no_hp', 'email', 'tanggal_masuk',
        'status_pernikahan', 'no_rekening', 'nama_bank',
        'no_bpjs_kesehatan', 'no_bpjs_tk', 'status', 'foto',
    ];

    /**
     * Ambil semua karyawan aktif beserta jabatan & departemen
     */
    public function getAllWithJabatan(): array
    {
        return $this->select('karyawan.*, jabatan.nama_jabatan, jabatan.gaji_pokok, jabatan.tunjangan_tetap, departemen.nama_departemen')
                    ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left')
                    ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
                    ->findAll();
    }

    /**
     * Ambil karyawan aktif saja
     */
    public function getAktif(): array
    {
        return $this->select('karyawan.*, jabatan.nama_jabatan, jabatan.gaji_pokok, jabatan.tunjangan_tetap, departemen.nama_departemen')
                    ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left')
                    ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
                    ->where('karyawan.status', 'aktif')
                    ->findAll();
    }

    /**
     * Ambil detail karyawan dengan join
     */
    public function getDetail(int $id): ?array
    {
        return $this->select('karyawan.*, jabatan.nama_jabatan, jabatan.gaji_pokok, jabatan.tunjangan_tetap, departemen.nama_departemen, departemen.id_departemen')
                    ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left')
                    ->join('departemen', 'departemen.id_departemen = jabatan.id_departemen', 'left')
                    ->find($id);
    }

    /**
     * Hitung total karyawan aktif
     */
    public function countAktif(): int
    {
        return $this->where('status', 'aktif')->countAllResults();
    }
}