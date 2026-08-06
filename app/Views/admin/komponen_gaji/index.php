<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">💰 Komponen Gaji Karyawan</h2>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama & NIK</th>
                    <th>Jabatan & Departemen</th>
                    <th>Gaji Pokok & Tunjangan Tetap</th>
                    <th>Status Komponen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($karyawan)): $no = 1; ?>
                    <?php foreach ($karyawan as $k): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="font-weight: 600; color: var(--text);"><?= esc($k['nama_karyawan']) ?></div>
                                <span style="font-size: 11px; color: var(--text-dim); font-family: monospace;"><?= esc($k['nik'] ?: '-') ?></span>
                            </td>
                            <td>
                                <div style="font-weight: 500; color: var(--text-muted);"><?= esc($k['nama_jabatan'] ?? '-') ?></div>
                                <span style="font-size: 12px; color: var(--text-dim);"><?= esc($k['nama_departemen'] ?? '-') ?></span>
                            </td>
                            <td>
                                <div style="font-size: 13px; color: var(--text-muted);">Gaji Pokok: Rp <?= number_format($k['gaji_pokok'] ?? 0, 0, ',', '.') ?></div>
                                <span style="font-size: 12px; color: var(--text-dim);">Tunjangan: Rp <?= number_format($k['tunjangan_tetap'] ?? 0, 0, ',', '.') ?></span>
                            </td>
                            <td>
                                <?php if ($k['has_komponen']): ?>
                                    <span class="badge badge-success">✓ TERSEDIA</span>
                                <?php else: ?>
                                    <span class="badge badge-warning" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2); color: var(--warning);">⚠ BELUM DIATUR</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/komponen-gaji/karyawan/' . $k['id_karyawan']) ?>" class="btn btn-primary btn-sm">
                                    ⚙️ Atur Komponen
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center; color:var(--text-dim); padding:40px;">Belum ada data karyawan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
