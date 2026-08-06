<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/akun') ?>" class="btn btn-ghost btn-sm">⬅️ Kembali</a>
    </div>

    <form action="<?= base_url('admin/akun/buat-akun/' . $karyawan['id_karyawan']) ?>" method="post">
        <?= csrf_field() ?>

        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--card-border); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; font-weight: 700;">
                <?= strtoupper(substr($karyawan['nama_karyawan'], 0, 1)) ?>
            </div>
            <div>
                <div style="font-weight: 600; color: var(--text); font-size: 14px;"><?= esc($karyawan['nama_karyawan']) ?></div>
                <span style="font-size: 11px; color: var(--text-dim);"><?= esc($karyawan['nik'] ?: '-') ?> | NIK</span>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="username">Username Akun <span style="color:var(--danger)">*</span></label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Contoh: rafliadi" value="<?= old('username') ?>" required>
            <span style="font-size: 11px; color: var(--text-dim);">Gunakan huruf kecil, angka, atau garis bawah (min 3 karakter).</span>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Alamat Email <span style="color:var(--danger)">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: karyawan@email.com" value="<?= old('email', $karyawan['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password Akun <span style="color:var(--danger)">*</span></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
        </div>

        <div style="margin-top: 24px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
            <a href="<?= base_url('admin/akun') ?>" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">➕ Buat Akun Karyawan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
