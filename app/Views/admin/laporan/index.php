<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">📈 Laporan Rekapitulasi Payroll</h2>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Periode</th>
                    <th>Bulan / Tahun</th>
                    <th>Tanggal Penerbitan</th>
                    <th>Ekspor Data</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($periode)): $no = 1; ?>
                    <?php foreach ($periode as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 600; color: var(--text);"><?= esc($p['nama_periode']) ?></td>
                            <td style="color: var(--text-muted);"><?= sprintf('%02d / %d', $p['bulan'], $p['tahun']) ?></td>
                            <td style="color: var(--text-muted); font-size: 13px;">
                                <?= date('d/m/Y H:i', strtotime($p['tanggal_finalisasi'])) ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="<?= base_url('admin/laporan/export/' . $p['id_periode'] . '?format=pdf') ?>" target="_blank" class="btn btn-primary btn-sm">
                                        🖨️ Cetak PDF Rekap
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; color:var(--text-dim); padding:40px;">Belum ada periode payroll yang difinalisasi. Laporan rekap tersedia setelah payroll diselesaikan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
