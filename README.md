# 💼 Sistem Informasi Penggajian (SIP Payroll)

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Framework](https://img.shields.io/badge/CodeIgniter-4.7-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)](https://codeigniter.com/)
[![Database](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

**Sistem Informasi Penggajian (SIP Payroll)** adalah aplikasi web berbasis **CodeIgniter 4** yang dirancang untuk mengotomatisasi proses perhitungan gaji karyawan, pemotongan PPh 21 dan BPJS (Kesehatan & Ketenagakerjaan), serta menyediakan layanan mandiri (self-service) slip gaji bagi karyawan.

---

## 📌 Fitur Utama

### 👨‍💼 Role Admin
- **Dashboard Overview**: Ringkasan jumlah karyawan aktif, departemen, dan status periode payroll.
- **Manajemen Data Master**:
  - Kelola Data Departemen & Jabatan.
  - Kelola Data Karyawan (Data pribadi, NPWP, Rekening Bank, BPJS Kesehatan & Ketenagakerjaan).
- **Manajemen Komponen Gaji**:
  - Konfigurasi Gaji Pokok, Tunjangan Tetap, Tunjangan Tidak Tetap, dan Bonus.
  - Skema Potongan: PPh 21, BPJS Kesehatan, BPJS Ketenagakerjaan, dan Potongan Lainnya.
- **Proses Payroll (Payroll Run)**:
  - Pembukaan periode payroll baru bulanan.
  - Otomatisasi kalkulasi *Take Home Pay* (THP), PPh 21, dan BPJS.
  - Preview & koreksi hasil perhitungan sebelum finalisasi.
  - Finalisasi payroll & pembuatan slip gaji otomatis.
- **Laporan & Export**:
  - Export rekap payroll seluruh karyawan (PDF / Excel / CSV).
  - Laporan rekap total biaya gaji per departemen.
- **Audit Log**: Pencatatan aktivitas perubahan data sensitif penggajian.

### 👤 Role Karyawan (Self-Service)
- **Akses Mandiri**: Login khusus karyawan dengan tampilan ringkas & ramah pengguna.
- **Slip Gaji Digital**: View detail slip gaji per periode (Gaji Pokok, Tunjangan, Potongan, dan THP).
- **Unduh PDF**: Cetak dan unduh slip gaji resmi format PDF.
- **Keamanan Akun**: Fitur ubah password mandiri.

---

## 🔐 Hak Akses & Matriks Peran

| Fitur | Admin | Karyawan |
|---|:---:|:---:|
| Login Sistem | ✅ | ✅ |
| Kelola Data Karyawan, Departemen & Jabatan | ✅ | ❌ |
| Kelola Komponen Gaji & Potongan | ✅ | ❌ |
| Menjalankan Proses Payroll Run | ✅ | ❌ |
| Review & Finalisasi Payroll | ✅ | ❌ |
| Lihat & Export Laporan Rekap Payroll | ✅ | ❌ |
| **Lihat & Unduh Slip Gaji Sendiri** | ✅ | ✅ |
| Ubah Password Sendiri | ✅ | ✅ |

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP 8.2+, CodeIgniter 4.7
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5 / Admin Template
- **Dependency Manager**: Composer
- **Cetak Dokumen**: Dompdf / FPDF (PDF Generator)

---

## 🚀 Panduan Instalasi & Konfigurasi

### 1. Prasyarat Sistem
- PHP >= 8.2 (dengan ekstensi `intl`, `mbstring`, `mysqli`, `json`, `curl` aktif)
- MySQL / MariaDB >= 8.0
- Composer >= 2.x
- Web Server (Apache / Nginx / XAMPP)

### 2. Kloning Repositori
```bash
git clone https://github.com/username/sistem-informasi-penggajian.git
cd sistem-informasi-penggajian
```

### 3. Instalasi Dependensi
```bash
composer install
```

### 4. Konfigurasi Environment (`.env`)
Salin file `env` menjadi `.env`:
```bash
cp env .env
```
Buka file `.env` dan atur konfigurasi database serta URL aplikasi:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = db_gajian
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### 5. Migrasi & Seeder Database
Jalankan migrasi untuk membuat tabel database dan seeder untuk data awal akun:
```bash
php spark migrate
php spark db:seed UserSeeder
```

### 6. Menjalankan Server Lokal
```bash
php spark serve
```
Aplikasi dapat diakses melalui browser di `http://localhost:8080`.

---

## 📂 Struktur Proyek

```text
gajian/
├── app/
├── Controllers/         # Logic Controller (Admin & Karyawan)
│   ├── Database/            # Migrations & Seeders
│   ├── Models/              # Database Models (Karyawan, Payroll, dll)
│   └── Views/               # Template tampilan UI (Admin & Karyawan)
├── public/                  # Asset publik (CSS, JS, Images, index.php)
├── writable/                # File cache, logs, dan PDF ter-generate
├── .env                     # Konfigurasi Environment
├── composer.json            # Daftar dependensi PHP
└── PRD.md                   # Product Requirements Document
```

---

## 📝 Lisensi

Proyek ini dilindungi di bawah lisensi [MIT License](LICENSE).

---
*Dibuat dengan ❤️ menggunakan CodeIgniter 4.*
