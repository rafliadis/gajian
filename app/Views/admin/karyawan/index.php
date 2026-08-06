<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">👥 Data Karyawan</h2>
        <a href="<?= base_url('admin/karyawan/create') ?>" class="btn btn-primary btn-sm">➕ Tambah Karyawan</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama & NIK</th>
                    <th>Jabatan & Departemen</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($karyawan)): ?>
                    <?php foreach ($karyawan as $k): ?>
                        <tr>
                            <td>
                                <?php if ($k['foto'] && file_exists(FCPATH . 'uploads/karyawan/' . $k['foto'])): ?>
                                    <img src="<?= base_url('uploads/karyawan/' . $k['foto']) ?>" alt="Foto Karyawan" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-light);">
                                <?php else: ?>
                                    <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; border: 2px solid rgba(255,255,255,0.06);">
                                        <?= strtoupper(substr($k['nama_karyawan'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--text);"><?= esc($k['nama_karyawan']) ?></div>
                                <span style="font-size: 11px; color: var(--text-dim); font-family: monospace;"><?= esc($k['nik'] ?: '-') ?></span>
                            </td>
                            <td>
                                <div style="font-weight: 500; color: var(--text-muted);"><?= esc($k['nama_jabatan'] ?? 'Belum Diatur') ?></div>
                                <span style="font-size: 12px; color: var(--text-dim);"><?= esc($k['nama_departemen'] ?? '-') ?></span>
                            </td>
                            <td>
                                <div style="font-size: 13px; color: var(--text-muted);"><?= esc($k['email'] ?: '-') ?></div>
                                <span style="font-size: 12px; color: var(--text-dim);"><?= esc($k['no_hp'] ?: '-') ?></span>
                            </td>
                            <td>
                                <?php if ($k['status'] === 'aktif'): ?>
                                    <span class="badge badge-success">AKTIF</span>
                                <?php else: ?>
                                    <span class="badge badge-danger" style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.2);">NONAKTIF</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="<?= base_url('admin/karyawan/detail/' . $k['id_karyawan']) ?>" class="btn btn-ghost btn-sm" style="padding: 6px 10px;">👁️ Detail</a>
                                    <a href="<?= base_url('admin/karyawan/edit/' . $k['id_karyawan']) ?>" class="btn btn-warning btn-sm" style="padding: 6px 10px;">✏️ Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm" style="padding: 6px 10px;" onclick="confirmDelete('<?= base_url('admin/karyawan/delete/' . $k['id_karyawan']) ?>', 'Yakin ingin menghapus karyawan <?= esc($k['nama_karyawan']) ?>?')">🗑️ Hapus</a>
                                </div>
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
