<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">🏢 Data Departemen</h2>
        <a href="<?= base_url('admin/departemen/create') ?>" class="btn btn-primary btn-sm">➕ Tambah Departemen</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Departemen</th>
                    <th>Deskripsi</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($departemen)): $no = 1; ?>
                    <?php foreach ($departemen as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 600;"><?= esc($d['nama_departemen']) ?></td>
                            <td style="color: var(--text-muted);"><?= esc($d['deskripsi'] ?? '-') ?></td>
                            <td style="color: var(--text-muted); font-size: 12px;"><?= date('d/m/Y', strtotime($d['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('admin/departemen/edit/' . $d['id_departemen']) ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('<?= base_url('admin/departemen/delete/' . $d['id_departemen']) ?>', 'Hapus departemen <?= esc($d['nama_departemen']) ?>?')">🗑️ Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; color:var(--text-dim); padding:40px;">Belum ada data departemen.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
