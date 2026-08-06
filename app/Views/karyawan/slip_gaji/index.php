<?= $this->extend('layout/karyawan') ?>
<?= $this->section('content') ?>

<div style="display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start;">
    
    <!-- Profile Sidebar (Left) -->
    <div class="card" style="text-align: center;">
        <div style="margin-bottom: 16px;">
            <?php if ($karyawan['foto'] && file_exists(FCPATH . 'uploads/karyawan/' . $karyawan['foto'])): ?>
                <img src="<?= base_url('uploads/karyawan/' . $karyawan['foto']) ?>" alt="Foto Profil" style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary); box-shadow: 0 4px 16px rgba(22,163,74,0.2);">
            <?php else: ?>
                <div style="width: 110px; height: 110px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 42px; font-weight: 800; color: white;">
                    <?= strtoupper(substr($karyawan['nama_karyawan'], 0, 1)) ?>
                </div>
            <?php endif; ?>
        </div>
        <h2 style="font-size: 18px; font-weight: 700; color: var(--text);"><?= esc($karyawan['nama_karyawan']) ?></h2>
        <p style="font-size: 12px; color: var(--text-dim); margin-bottom: 12px; font-family: monospace;"><?= esc($karyawan['nik'] ?: '-') ?></p>

        <div style="text-align: left; border-top: 1px solid var(--card-border); padding-top: 12px; font-size: 13px; display: flex; flex-direction: column; gap: 8px;">
            <div>
                <span style="color: var(--text-dim); display: block; font-size: 11px;">JABATAN / DEPARTEMEN</span>
                <span style="font-weight: 600; color: var(--text);"><?= esc($karyawan['nama_jabatan'] ?? '-') ?></span>
                <span style="display: block; font-size: 12px; color: var(--text-muted);"><?= esc($karyawan['nama_departemen'] ?? '-') ?></span>
            </div>
            <div>
                <span style="color: var(--text-dim); display: block; font-size: 11px;">REKENING TRANSFER</span>
                <span style="font-weight: 600; color: var(--text);"><?= esc($karyawan['nama_bank'] ?: '-') ?> - <?= esc($karyawan['no_rekening'] ?: '-') ?></span>
            </div>
            <div>
                <span style="color: var(--text-dim); display: block; font-size: 11px;">STATUS PTKP (PAJAK)</span>
                <span style="font-weight: 600; color: var(--text);"><?= esc($karyawan['status_pernikahan'] ?: 'TK') ?></span>
            </div>
        </div>
    </div>

    <!-- Slip Gaji History (Right) -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📋 Riwayat Slip Gaji</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Periode Gaji</th>
                        <th>Bulan / Tahun</th>
                        <th>Tanggal Terbit</th>
                        <th>Gaji Bersih Diterima</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat)): $no = 1; ?>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td style="font-weight: 600; color: var(--text);"><?= esc($r['nama_periode']) ?></td>
                                <td style="color: var(--text-muted);"><?= sprintf('%02d / %d', $r['bulan'], $r['tahun']) ?></td>
                                <td style="color: var(--text-muted); font-size: 13px;">
                                    <?= isset($r['tanggal_finalisasi']) && $r['tanggal_finalisasi']
                                        ? date('d/m/Y H:i', strtotime($r['tanggal_finalisasi']))
                                        : '-' ?>
                                </td>
                                <td style="font-weight: 700; color: var(--success); font-size: 14px;">
                                    Rp <?= number_format($r['gaji_bersih'], 0, ',', '.') ?>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        <a href="<?= base_url('karyawan/slip-gaji/detail/' . $r['id_detail']) ?>" class="btn btn-primary btn-sm" style="padding: 6px 12px;">
                                            👁️ Detail
                                        </a>
                                        <a href="<?= base_url('karyawan/slip-gaji/download/' . $r['id_detail']) ?>" target="_blank" class="btn btn-ghost btn-sm" style="padding: 6px 12px;">
                                            📥 PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:40px;">Belum ada slip gaji yang dirilis untuk Anda.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
