<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div style="display: grid; grid-template-columns: 280px 1fr; gap: 24px; align-items: start;">
    
    <!-- Profile Card (Left) -->
    <div class="card" style="text-align: center;">
        <div style="margin-bottom: 20px;">
            <?php if ($karyawan['foto'] && file_exists(FCPATH . 'uploads/karyawan/' . $karyawan['foto'])): ?>
                <img src="<?= base_url('uploads/karyawan/' . $karyawan['foto']) ?>" alt="Foto Karyawan" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; border: 4px solid var(--primary); box-shadow: 0 8px 24px rgba(99,102,241,0.25);">
            <?php else: ?>
                <div style="width: 140px; height: 140px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 52px; font-weight: 800; color: white; border: 4px solid var(--primary-light);">
                    <?= strtoupper(substr($karyawan['nama_karyawan'], 0, 1)) ?>
                </div>
            <?php endif; ?>
        </div>
        <h2 style="font-size: 20px; font-weight: 700; color: var(--text); margin-bottom: 4px;"><?= esc($karyawan['nama_karyawan']) ?></h2>
        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 12px; font-family: monospace;"><?= esc($karyawan['nik'] ?: 'Tidak ada NIK') ?></p>
        <div style="margin-bottom: 16px;">
            <?php if ($karyawan['status'] === 'aktif'): ?>
                <span class="badge badge-success">AKTIF</span>
            <?php else: ?>
                <span class="badge badge-danger" style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.2);">NONAKTIF</span>
            <?php endif; ?>
        </div>
        
        <div style="border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px; text-align: left;">
            <div style="margin-bottom: 12px;">
                <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block;">Jabatan</span>
                <span style="font-size: 14px; font-weight: 600; color: var(--text);"><?= esc($karyawan['nama_jabatan'] ?? 'Belum Diatur') ?></span>
            </div>
            <div>
                <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block;">Departemen</span>
                <span style="font-size: 14px; font-weight: 600; color: var(--text);"><?= esc($karyawan['nama_departemen'] ?? '-') ?></span>
            </div>
        </div>

        <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 8px;">
            <a href="<?= base_url('admin/karyawan/edit/' . $karyawan['id_karyawan']) ?>" class="btn btn-primary btn-sm" style="justify-content: center; width: 100%;">✏️ Edit Profil</a>
            <a href="<?= base_url('admin/karyawan') ?>" class="btn btn-ghost btn-sm" style="justify-content: center; width: 100%;">⬅️ Kembali</a>
        </div>
    </div>

    <!-- Details Panels (Right) -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Tab 1: Personal Info -->
        <div class="card">
            <h3 style="font-size: 15px; color: var(--primary-light); border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 8px; margin-bottom: 16px;">👤 Informasi Pribadi</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Jenis Kelamin</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text);"><?= $karyawan['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Tanggal Lahir</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text);"><?= $karyawan['tanggal_lahir'] ? date('d F Y', strtotime($karyawan['tanggal_lahir'])) : '-' ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">No. HP / WhatsApp</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text);"><?= esc($karyawan['no_hp'] ?: '-') ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Email</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text);"><?= esc($karyawan['email'] ?: '-') ?></span>
                </div>
                <div style="grid-column: span 2;">
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Alamat</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text); line-height: 1.5;"><?= nl2br(esc($karyawan['alamat'] ?? '-')) ?></span>
                </div>
            </div>
        </div>

        <!-- Tab 2: Kepegawaian & Finansial -->
        <div class="card">
            <h3 style="font-size: 15px; color: var(--primary-light); border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 8px; margin-bottom: 16px;">💼 Kepegawaian & Gaji Pokok</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Tanggal Masuk Kerja</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text);"><?= $karyawan['tanggal_masuk'] ? date('d F Y', strtotime($karyawan['tanggal_masuk'])) : '-' ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Status Pernikahan (PTKP)</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text);">
                        <?php
                            $ptkp = [
                                'TK' => 'TK (Tidak Kawin)',
                                'K0' => 'K0 (Kawin, 0 Tanggungan)',
                                'K1' => 'K1 (Kawin, 1 Tanggungan)',
                                'K2' => 'K2 (Kawin, 2 Tanggungan)',
                                'K3' => 'K3 (Kawin, 3 Tanggungan)',
                            ];
                            echo $ptkp[$karyawan['status_pernikahan']] ?? $karyawan['status_pernikahan'];
                        ?>
                    </span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Gaji Pokok Jabatan</span>
                    <span style="font-size: 15px; font-weight: 600; color: var(--success);">Rp <?= number_format($karyawan['gaji_pokok'] ?? 0, 0, ',', '.') ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Tunjangan Tetap Jabatan</span>
                    <span style="font-size: 15px; font-weight: 600; color: var(--success);">Rp <?= number_format($karyawan['tunjangan_tetap'] ?? 0, 0, ',', '.') ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">NPWP</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text);"><?= esc($karyawan['npwp'] ?: '-') ?></span>
                </div>
            </div>
        </div>

        <!-- Tab 3: Banking & BPJS -->
        <div class="card">
            <h3 style="font-size: 15px; color: var(--primary-light); border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 8px; margin-bottom: 16px;">💳 Informasi Perbankan & BPJS</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Nama Bank</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text);"><?= esc($karyawan['nama_bank'] ?: '-') ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">Nomor Rekening</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text); font-family: monospace;"><?= esc($karyawan['no_rekening'] ?: '-') ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">No. BPJS Kesehatan</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text); font-family: monospace;"><?= esc($karyawan['no_bpjs_kesehatan'] ?: '-') ?></span>
                </div>
                <div>
                    <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; display: block; margin-bottom: 2px;">No. BPJS Ketenagakerjaan</span>
                    <span style="font-size: 14px; font-weight: 500; color: var(--text); font-family: monospace;"><?= esc($karyawan['no_bpjs_tk'] ?: '-') ?></span>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
