<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">🎖️ Data Jabatan</h2>
        <a href="<?= base_url('admin/jabatan/create') ?>" class="btn btn-primary btn-sm">➕ Tambah Jabatan</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Jabatan</th>
                    <th>Departemen</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan Tetap</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($jabatan)): $no = 1; ?>
                    <?php foreach ($jabatan as $j): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 600;"><?= esc($j['nama_jabatan']) ?></td>
                            <td style="color: var(--text-muted);"><?= esc($j['nama_departemen'] ?? 'Tanpa Departemen') ?></td>
                            <td style="font-weight: 500;">Rp <?= number_format($j['gaji_pokok'], 0, ',', '.') ?></td>
                            <td style="font-weight: 500;">Rp <?= number_format($j['tunjangan_tetap'], 0, ',', '.') ?></td>
                            <td>
                                <a href="<?= base_url('admin/jabatan/edit/' . $j['id_jabatan']) ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('<?= base_url('admin/jabatan/delete/' . $j['id_jabatan']) ?>', 'Hapus jabatan <?= esc($j['nama_jabatan']) ?>?')">🗑️ Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center; color:var(--text-dim); padding:40px;">Belum ada data jabatan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
