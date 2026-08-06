<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <h2 class="card-title">📄 Slip Gaji Periode: <?= esc($periode['nama_periode']) ?></h2>
            <span style="font-size: 12px; color: var(--text-dim);">Diterbitkan pada: <?= date('d/m/Y H:i', strtotime($periode['tanggal_finalisasi'])) ?></span>
        </div>
        <a href="<?= base_url('admin/slip-gaji') ?>" class="btn btn-ghost btn-sm">⬅️ Kembali</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama & NIK</th>
                    <th>Jabatan & Departemen</th>
                    <th>Gaji Bersih (Take Home Pay)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detail)): $no = 1; ?>
                    <?php foreach ($detail as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="font-weight: 600; color: var(--text);"><?= esc($d['nama_karyawan']) ?></div>
                                <span style="font-size: 11px; color: var(--text-dim); font-family: monospace;"><?= esc($d['nik'] ?: '-') ?></span>
                            </td>
                            <td>
                                <div style="font-weight: 500; color: var(--text-muted);"><?= esc($d['nama_jabatan'] ?? '-') ?></div>
                                <span style="font-size: 12px; color: var(--text-dim);"><?= esc($d['nama_departemen'] ?? '-') ?></span>
                            </td>
                            <td style="font-weight: 700; color: var(--success); font-size: 14px;">
                                Rp <?= number_format($d['gaji_bersih'], 0, ',', '.') ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/slip-gaji/cetak/' . $d['id_detail']) ?>" target="_blank" class="btn btn-primary btn-sm">
                                    🖨️ Cetak / Download Slip
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; color:var(--text-dim); padding:40px;">Tidak ada data slip gaji untuk periode ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
