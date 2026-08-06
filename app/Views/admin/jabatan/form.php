<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/jabatan') ?>" class="btn btn-ghost btn-sm">⬅️ Kembali</a>
    </div>

    <form action="<?= $jabatan ? base_url('admin/jabatan/update/' . $jabatan['id_jabatan']) : base_url('admin/jabatan/save') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="nama_jabatan">Nama Jabatan <span style="color:var(--danger)">*</span></label>
            <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" placeholder="Contoh: Senior Developer" value="<?= old('nama_jabatan', $jabatan['nama_jabatan'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="id_departemen">Departemen</label>
            <select class="form-control" id="id_departemen" name="id_departemen">
                <option value="">-- Pilih Departemen --</option>
                <?php foreach ($departemen as $d): ?>
                    <option value="<?= $d['id_departemen'] ?>" <?= old('id_departemen', $jabatan['id_departemen'] ?? '') == $d['id_departemen'] ? 'selected' : '' ?>>
                        <?= esc($d['nama_departemen']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="gaji_pokok">Gaji Pokok (Rp) <span style="color:var(--danger)">*</span></label>
                <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" placeholder="Contoh: 9000000" min="1" value="<?= old('gaji_pokok', isset($jabatan['gaji_pokok']) ? (int) $jabatan['gaji_pokok'] : '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="tunjangan_tetap">Tunjangan Tetap (Rp)</label>
                <input type="number" class="form-control" id="tunjangan_tetap" name="tunjangan_tetap" placeholder="Contoh: 1500000" min="0" value="<?= old('tunjangan_tetap', isset($jabatan['tunjangan_tetap']) ? (int) $jabatan['tunjangan_tetap'] : '') ?>">
            </div>
        </div>

        <div style="margin-top: 10px; display: flex; justify-content: flex-end; gap: 12px;">
            <a href="<?= base_url('admin/jabatan') ?>" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
