<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h2 class="card-title"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/departemen') ?>" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>

    <form method="post" action="<?= $departemen ? base_url('admin/departemen/update/' . $departemen['id_departemen']) : base_url('admin/departemen/save') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label">Nama Departemen <span style="color:var(--danger)">*</span></label>
            <input type="text" name="nama_departemen" class="form-control"
                   value="<?= esc(old('nama_departemen', $departemen['nama_departemen'] ?? '')) ?>"
                   placeholder="Contoh: Teknologi Informasi" required>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" placeholder="Deskripsi singkat departemen..."><?= esc(old('deskripsi', $departemen['deskripsi'] ?? '')) ?></textarea>
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:8px;">
            <a href="<?= base_url('admin/departemen') ?>" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
