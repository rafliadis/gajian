<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(99,102,241,0.15);">👥</div>
        <div class="stat-info">
            <div class="stat-value"><?= number_format($totalKaryawan) ?></div>
            <div class="stat-label">Karyawan Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16,185,129,0.15);">✅</div>
        <div class="stat-info">
            <div class="stat-value"><?= number_format($periodeFinalized) ?></div>
            <div class="stat-label">Periode Selesai</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(245,158,11,0.15);">⚡</div>
        <div class="stat-info">
            <div class="stat-value"><?= $periodeBerjalan ? '1' : '0' ?></div>
            <div class="stat-label">Penggajian Berjalan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(6,182,212,0.15);">📄</div>
        <div class="stat-info">
            <div class="stat-value"><?= number_format($totalPeriode) ?></div>
            <div class="stat-label">Total Periode</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

    <!-- Status Payroll Saat Ini -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">⚡ Status Penggajian</h2>
            <a href="<?= base_url('admin/payroll') ?>" class="btn btn-ghost btn-sm">Lihat Semua</a>
        </div>

        <?php if ($periodeBerjalan): ?>
            <div style="text-align: center; padding: 20px 0;">
                <div style="font-size: 48px; margin-bottom: 12px;">🔄</div>
                <div style="font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 6px;">
                    <?= esc($periodeBerjalan['nama_periode']) ?>
                </div>
                <div class="badge badge-warning" style="margin-bottom: 16px;">
                    <?= strtoupper($periodeBerjalan['status']) ?>
                </div>
                <br>
                <a href="<?= base_url('admin/payroll/preview/' . $periodeBerjalan['id_periode']) ?>" class="btn btn-primary btn-sm">
                    👁️ Review & Finalisasi
                </a>
            </div>
        <?php elseif ($lastFinalized): ?>
            <div style="text-align: center; padding: 20px 0;">
                <div style="font-size: 48px; margin-bottom: 12px;">✅</div>
                <div style="font-size: 16px; color: var(--text-muted); margin-bottom: 6px;">Periode terakhir selesai:</div>
                <div style="font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 16px;">
                    <?= esc($lastFinalized['nama_periode']) ?>
                </div>
                <a href="<?= base_url('admin/payroll/buat') ?>" class="btn btn-primary btn-sm">
                    ➕ Buat Periode Baru
                </a>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 20px 0;">
                <div style="font-size: 48px; margin-bottom: 12px;">🚀</div>
                <div style="font-size: 15px; color: var(--text-muted); margin-bottom: 16px;">Belum ada periode penggajian.</div>
                <a href="<?= base_url('admin/payroll/buat') ?>" class="btn btn-primary">
                    ➕ Mulai Penggajian Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Aksi Cepat -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">🚀 Aksi Cepat</h2>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <a href="<?= base_url('admin/karyawan/create') ?>" class="btn btn-ghost" style="flex-direction: column; padding: 20px; text-align: center; gap: 8px;">
                <span style="font-size: 28px;">👤</span>
                <span style="font-size: 13px;">Tambah Karyawan</span>
            </a>
            <a href="<?= base_url('admin/payroll/buat') ?>" class="btn btn-ghost" style="flex-direction: column; padding: 20px; text-align: center; gap: 8px;">
                <span style="font-size: 28px;">⚡</span>
                <span style="font-size: 13px;">Proses Gaji</span>
            </a>
            <a href="<?= base_url('admin/komponen-gaji') ?>" class="btn btn-ghost" style="flex-direction: column; padding: 20px; text-align: center; gap: 8px;">
                <span style="font-size: 28px;">💰</span>
                <span style="font-size: 13px;">Komponen Gaji</span>
            </a>
            <a href="<?= base_url('admin/laporan') ?>" class="btn btn-ghost" style="flex-direction: column; padding: 20px; text-align: center; gap: 8px;">
                <span style="font-size: 28px;">📊</span>
                <span style="font-size: 13px;">Lihat Laporan</span>
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity Log -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">📋 Aktivitas Terkini</h2>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Modul</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentLog)): ?>
                    <?php foreach ($recentLog as $log): ?>
                        <tr>
                            <td style="color: var(--text-muted); font-size: 12px;">
                                <?= date('d/m/Y H:i', strtotime($log['created_at'])) ?>
                            </td>
                            <td style="font-weight: 600;"><?= esc($log['username'] ?? '-') ?></td>
                            <td>
                                <span class="badge badge-info"><?= esc($log['aksi']) ?></span>
                            </td>
                            <td style="color: var(--text-muted);"><?= esc($log['modul'] ?? '-') ?></td>
                            <td style="color: var(--text-muted); font-size: 13px; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= esc($log['keterangan'] ?? '-') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-dim); padding: 40px;">
                            Belum ada aktivitas tercatat.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
