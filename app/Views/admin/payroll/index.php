<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">⚡ Riwayat Proses Gaji</h2>
        <a href="<?= base_url('admin/payroll/buat') ?>" class="btn btn-primary btn-sm">➕ Buka Periode Baru</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Periode</th>
                    <th>Bulan / Tahun</th>
                    <th>Tanggal Run</th>
                    <th>Tanggal Finalisasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($periode)): $no = 1; ?>
                    <?php foreach ($periode as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 600; color: var(--text);"><?= esc($p['nama_periode']) ?></td>
                            <td style="color: var(--text-muted);"><?= sprintf('%02d / %d', $p['bulan'], $p['tahun']) ?></td>
                            <td style="color: var(--text-muted); font-size: 13px;"><?= date('d/m/Y H:i', strtotime($p['tanggal_run'])) ?></td>
                            <td style="color: var(--text-muted); font-size: 13px;">
                                <?= $p['tanggal_finalisasi'] ? date('d/m/Y H:i', strtotime($p['tanggal_finalisasi'])) : '-' ?>
                            </td>
                            <td>
                                <?php if ($p['status'] === 'finalized'): ?>
                                    <span class="badge badge-success">SELESAI (FINAL)</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">DRAFT (PREVIEW)</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p['status'] === 'finalized'): ?>
                                    <a href="<?= base_url('admin/payroll/detail/' . $p['id_periode']) ?>" class="btn btn-ghost btn-sm">👁️ Detail</a>
                                <?php else: ?>
                                    <a href="<?= base_url('admin/payroll/preview/' . $p['id_periode']) ?>" class="btn btn-primary btn-sm">⚡ Review & Finalisasi</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center; color:var(--text-dim); padding:40px;">Belum ada periode penggajian. Silakan buat yang pertama.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
