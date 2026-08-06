# Product Requirements Document (PRD)
# Sistem Informasi Penggajian (Versi Sederhana: Admin & Karyawan)

**Versi Dokumen:** 1.0
**Tanggal:** 18 Juli 2026
**Status:** Draft
**Pemilik Dokumen:** [Nama Product Manager]

---

## 1. Ringkasan Produk

Sistem Informasi Penggajian adalah aplikasi berbasis web dengan **2 peran pengguna**:

1. **Admin** — mengelola seluruh data karyawan, komponen gaji, menjalankan proses payroll, dan menerbitkan slip gaji.
2. **Karyawan** — hanya dapat **login dan melihat/mengunduh slip gaji miliknya sendiri**. Tidak ada fitur pengajuan cuti, lembur, atau approval di versi ini.

Tujuannya adalah menyediakan sistem payroll yang ringkas, fokus pada otomatisasi perhitungan gaji oleh Admin dan transparansi slip gaji bagi Karyawan.

---

## 2. Tujuan Bisnis

- Mengotomatisasi perhitungan gaji agar lebih akurat dan cepat dibanding proses manual (Excel).
- Memberikan akses mandiri (self-service) kepada karyawan untuk melihat slip gaji kapan saja, tanpa perlu meminta ke HR.
- Menyederhanakan hak akses sistem menjadi 2 peran agar mudah dikelola dan dikembangkan (cocok untuk MVP/perusahaan skala kecil-menengah).

---

## 3. Peran Pengguna & Hak Akses (Role Matrix)

| Fitur | Admin | Karyawan |
|---|:---:|:---:|
| Login ke sistem | ✅ | ✅ |
| Kelola data master karyawan (tambah/ubah/nonaktifkan) | ✅ | ❌ |
| Kelola komponen gaji (gaji pokok, tunjangan, potongan) | ✅ | ❌ |
| Menjalankan proses payroll (payroll run) | ✅ | ❌ |
| Melihat & mengoreksi hasil perhitungan sebelum finalisasi | ✅ | ❌ |
| Menerbitkan/generate slip gaji | ✅ | ❌ |
| Melihat slip gaji milik semua karyawan | ✅ | ❌ |
| **Melihat & mengunduh slip gaji milik sendiri** | ✅ (opsional, jika admin juga karyawan) | ✅ |
| Melihat riwayat slip gaji periode sebelumnya (milik sendiri) | ✅ | ✅ |
| Melihat laporan rekap payroll (semua karyawan) | ✅ | ❌ |
| Reset password akun karyawan | ✅ | ❌ |
| Ubah password sendiri | ✅ | ✅ |

> **Prinsip utama:** Karyawan hanya memiliki akses **read-only** ke data slip gaji miliknya sendiri. Tidak ada fitur input, pengajuan, atau approval untuk role Karyawan di versi ini.

---

## 4. Kebutuhan Fungsional (Functional Requirements)

### 4.1 Autentikasi & Manajemen Akun
- FR-1.1: Sistem menyediakan login dengan email/username dan password untuk kedua role.
- FR-1.2: Sistem membedakan tampilan/menu berdasarkan role (Admin vs Karyawan) setelah login.
- FR-1.3: Admin dapat membuat akun untuk karyawan baru (otomatis terhubung ke data karyawan tersebut).
- FR-1.4: Karyawan dapat mengganti password sendiri; Admin dapat mereset password karyawan bila lupa.
- FR-1.5: Sistem melakukan logout otomatis setelah periode tidak aktif tertentu (session timeout).

### 4.2 Manajemen Data Karyawan (Admin)
- FR-2.1: Admin dapat menambah, mengubah, dan menonaktifkan data karyawan (nama, jabatan, departemen, status kepegawaian, NPWP, no. rekening, data BPJS).
- FR-2.2: Sistem mencatat riwayat perubahan data karyawan (untuk audit).

### 4.3 Komponen Gaji (Admin)
- FR-3.1: Admin dapat mengatur komponen gaji per karyawan: gaji pokok, tunjangan tetap, tunjangan tidak tetap, bonus/insentif.
- FR-3.2: Admin dapat mengatur komponen potongan: pajak (PPh 21), BPJS Kesehatan, BPJS Ketenagakerjaan, potongan lain (pinjaman, dll).

### 4.4 Proses Payroll (Admin)
- FR-4.1: Admin dapat membuka periode payroll baru (misal: per bulan).
- FR-4.2: Sistem menghitung gaji bersih (take home pay) secara otomatis berdasarkan komponen gaji dan potongan yang telah dikonfigurasi.
- FR-4.3: Sistem menghitung PPh 21 sesuai tarif dan PTKP yang berlaku.
- FR-4.4: Sistem menghitung iuran BPJS Kesehatan dan BPJS Ketenagakerjaan sesuai persentase yang berlaku.
- FR-4.5: Admin dapat melihat preview perhitungan sebelum finalisasi, dan melakukan koreksi manual bila diperlukan.
- FR-4.6: Setelah difinalisasi, Admin men-generate slip gaji untuk seluruh karyawan dalam periode tersebut.
- FR-4.7: Data payroll yang sudah difinalisasi tidak dapat diubah langsung; perubahan harus melalui mekanisme koreksi/adjustment tercatat (audit trail).

### 4.5 Slip Gaji — Sisi Karyawan
- FR-5.1: Karyawan dapat login dan melihat daftar slip gaji miliknya berdasarkan periode (bulan/tahun).
- FR-5.2: Karyawan dapat membuka detail slip gaji: rincian gaji pokok, tunjangan, potongan (pajak, BPJS, lain-lain), dan gaji bersih (take home pay).
- FR-5.3: Karyawan dapat mengunduh slip gaji dalam format PDF.
- FR-5.4: Karyawan hanya dapat melihat slip gaji miliknya sendiri (tidak dapat mengakses data karyawan lain).
- FR-5.5: Sistem mengirim notifikasi (email) ke karyawan saat slip gaji periode baru telah tersedia.

### 4.6 Laporan (Admin)
- FR-6.1: Admin dapat melihat dan mengekspor rekap payroll seluruh karyawan per periode (format Excel/CSV/PDF).
- FR-6.2: Admin dapat melihat rekap total biaya gaji per departemen/periode.

### 4.7 Keamanan & Audit
- FR-7.1: Sistem menerapkan kontrol akses berbasis role (RBAC) yang membatasi Karyawan hanya pada data miliknya.
- FR-7.2: Seluruh aksi Admin pada data gaji tercatat dalam audit log (siapa, kapan, perubahan apa).
- FR-7.3: Data sensitif (gaji, NIK, rekening bank) dienkripsi saat disimpan.

---

## 5. Kebutuhan Non-Fungsional

| Kategori | Kebutuhan |
|---|---|
| **Keamanan** | Enkripsi data at-rest & in-transit (TLS 1.2+); Karyawan tidak bisa mengakses data karyawan lain meski memanipulasi URL/parameter (proteksi IDOR) |
| **Kinerja** | Payroll run untuk 500 karyawan selesai < 3 menit |
| **Ketersediaan** | Uptime ≥ 99.5% |
| **Kepatuhan** | Perhitungan PPh 21 & BPJS sesuai regulasi terbaru |
| **Usability** | Karyawan dapat menemukan & mengunduh slip gaji dalam ≤ 3 klik setelah login |
| **Auditability** | Semua perubahan data gaji oleh Admin tercatat & dapat ditelusuri minimal 5 tahun |

---

## 6. Alur Pengguna (User Flow)

### 6.1 Alur Admin — Payroll Run
1. Admin login ke sistem.
2. Admin membuka periode payroll baru.
3. Sistem menghitung gaji otomatis berdasarkan komponen gaji & potongan yang sudah dikonfigurasi.
4. Admin mereview hasil perhitungan (preview) dan melakukan koreksi bila perlu.
5. Admin finalisasi payroll → sistem generate slip gaji untuk semua karyawan.
6. Sistem mengirim notifikasi ke seluruh karyawan bahwa slip gaji sudah tersedia.

### 6.2 Alur Karyawan — Lihat Slip Gaji
1. Karyawan login ke sistem.
2. Karyawan diarahkan ke halaman "Slip Gaji Saya" (tampilan default, tanpa menu lain yang kompleks).
3. Karyawan memilih periode yang ingin dilihat.
4. Sistem menampilkan rincian slip gaji periode tersebut.
5. Karyawan dapat mengunduh slip gaji dalam format PDF.

---

## 7. Wireframe Konsep (Deskriptif)

**Halaman Karyawan (setelah login):**
- Header: Nama karyawan, jabatan, foto profil (opsional)
- Menu utama (minimal): "Slip Gaji" | "Ubah Password" | "Logout"
- Daftar slip gaji per periode (list/dropdown bulan-tahun)
- Detail slip gaji: gaji pokok, tunjangan, total potongan (pajak, BPJS, lain), **gaji bersih (bold/highlight)**
- Tombol "Unduh PDF"

**Halaman Admin (setelah login):**
- Dashboard ringkasan: jumlah karyawan aktif, status payroll periode berjalan
- Menu: "Data Karyawan" | "Komponen Gaji" | "Payroll Run" | "Slip Gaji Karyawan" | "Laporan" | "Pengaturan Akun"

---

## 8. Kriteria Penerimaan (Acceptance Criteria)

**Fitur: Karyawan melihat slip gaji**
- Given karyawan sudah login dan payroll periode berjalan telah difinalisasi oleh Admin,
- When karyawan membuka menu "Slip Gaji" dan memilih periode tersebut,
- Then sistem menampilkan rincian gaji bersih beserta komponen gaji dan potongan, dan karyawan dapat mengunduhnya sebagai PDF.

**Fitur: Pembatasan akses data**
- Given karyawan A login ke sistem,
- When karyawan A mencoba mengakses data/slip gaji milik karyawan B (misalnya melalui URL langsung),
- Then sistem menolak akses dan menampilkan pesan/error "tidak memiliki izin".

**Fitur: Admin menjalankan payroll run**
- Given seluruh komponen gaji karyawan sudah dikonfigurasi,
- When Admin menjalankan proses payroll run untuk periode berjalan,
- Then sistem menghasilkan perhitungan gaji bersih yang akurat untuk seluruh karyawan aktif dan slip gaji siap diakses karyawan setelah difinalisasi.

---

## 9. Di Luar Lingkup (Out of Scope)

- Pengajuan cuti, lembur, atau reimbursement oleh karyawan
- Approval workflow (atasan-bawahan)
- Aplikasi mobile native
- Integrasi otomatis ke bank untuk pencairan dana (disbursement)
- Multi-role tambahan (misal: Manajer, Finance) — dapat menjadi Fase 2

---

## 10. Rencana Rilis

| Fase | Cakupan | Estimasi |
|---|---|---|
| **MVP** | Login 2 role, kelola data karyawan & komponen gaji, payroll run manual, slip gaji (view & download PDF) | 6–8 minggu |
| **Fase 2 (opsional)** | Laporan lanjutan, notifikasi email, riwayat multi-tahun, export data | 3–4 minggu |

---

## 11. Pertanyaan Terbuka

- Apakah Admin juga berperan sebagai karyawan yang menerima gaji (perlu akses ganda)?
- Apakah slip gaji perlu ditandatangani secara digital (e-signature) untuk keperluan legal?
- Berapa lama riwayat slip gaji yang perlu disimpan dan dapat diakses karyawan (misal: 12 bulan terakhir vs semua riwayat)?

---

**Catatan:** Dokumen ini disusun dengan scope sederhana (2 role) sebagai versi MVP. Fitur tambahan seperti approval, multi-role, atau integrasi lanjutan dapat direncanakan pada fase berikutnya.
