<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="stats-grid" style="margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(99,102,241,0.15);">📅</div>
        <div class="stat-info">
            <div class="stat-value"><?= esc($periode['nama_periode']) ?></div>
            <div class="stat-label">Periode Penggajian</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16,185,129,0.15);">🔒</div>
        <div class="stat-info">
            <div class="stat-value">Selesai (Final)</div>
            <div class="stat-label">Status Periode</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(6,182,212,0.15);">💰</div>
        <div class="stat-info">
            <div class="stat-value">Rp <?= number_format($totalGaji, 0, ',', '.') ?></div>
            <div class="stat-label">Total Gaji Bersih</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="margin-bottom: 16px;">
        <div>
            <h2 class="card-title">📄 Rincian Gaji Final</h2>
            <span style="font-size: 12px; color: var(--text-dim);">
                Difinalisasi pada: <?= date('d F Y H:i', strtotime($periode['tanggal_finalisasi'])) ?>
            </span>
        </div>
        <a href="<?= base_url('admin/payroll') ?>" class="btn btn-ghost btn-sm">⬅️ Kembali</a>
    </div>

    <div class="table-responsive">
        <table style="font-size: 13px;">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Pendapatan Pokok</th>
                    <th>Pendapatan Tambahan</th>
                    <th>Potongan BPJS (Kar)</th>
                    <th>PPh 21</th>
                    <th>Potongan Lain</th>
                    <th>Koreksi</th>
                    <th>Gaji Bersih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail as $d): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: var(--text);"><?= esc($d['nama_karyawan']) ?></div>
                            <span style="font-size: 11px; color: var(--text-dim);"><?= esc($d['nama_jabatan'] ?? '-') ?></span>
                        </td>
                        <td>
                            <div>Gaji Pokok: Rp <?= number_format($d['gaji_pokok'], 0, ',', '.') ?></div>
                            <span style="font-size: 11px; color: var(--text-dim);">Tunj. Tetap: Rp <?= number_format($d['tunjangan_tetap'], 0, ',', '.') ?></span>
                        </td>
                        <td>
                            <div>Tunj. Var: Rp <?= number_format($d['tunjangan_tidak_tetap'], 0, ',', '.') ?></div>
                            <span style="font-size: 11px; color: var(--text-dim);">Bonus: Rp <?= number_format($d['bonus'], 0, ',', '.') ?></span>
                        </td>
                        <td>
                            <div>Kes: Rp <?= number_format($d['potongan_bpjs_kes_karyawan'], 0, ',', '.') ?></div>
                            <span style="font-size: 11px; color: var(--text-dim);">TK: Rp <?= number_format($d['potongan_bpjs_tk_jht'] + $d['potongan_bpjs_tk_jp'], 0, ',', '.') ?></span>
                        </td>
                        <td style="color: #fca5a5;">Rp <?= number_format($d['potongan_pph21'], 0, ',', '.') ?></td>
                        <td style="color: #fca5a5;">Rp <?= number_format($d['potongan_lain'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($d['is_koreksi']): ?>
                                <div style="color: <?= $d['koreksi_nominal'] >= 0 ? '#6ee7b7' : '#fca5a5' ?>; font-weight: 600;">
                                    <?= $d['koreksi_nominal'] >= 0 ? '+' : '' ?>Rp <?= number_format($d['koreksi_nominal'], 0, ',', '.') ?>
                                </div>
                                <span style="font-size: 10px; color: var(--text-dim); display: block;" title="<?= esc($d['koreksi_keterangan']) ?>">
                                    <?= esc($d['koreksi_keterangan']) ?>
                                </span>
                            <?php else: ?>
                                <span style="color: var(--text-dim);">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight: 700; color: var(--success); font-size: 14px;">
                            Rp <?= number_format($d['gaji_bersih'], 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
