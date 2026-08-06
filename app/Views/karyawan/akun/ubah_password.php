<?= $this->extend('layout/karyawan') ?>
<?= $this->section('content') ?>

<div class="card" style="max-width: 460px; margin: 0 auto;">
    <div class="card-header" style="margin-bottom: 20px;">
        <h2 class="card-title">🔑 Ubah Password Akun</h2>
    </div>

    <form action="<?= base_url('karyawan/akun/ubah-password') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="password_lama">Password Lama <span style="color:var(--danger)">*</span></label>
            <input type="password" class="form-control" id="password_lama" name="password_lama" required autofocus>
            <span style="font-size: 11px; color: var(--text-muted);">Masukkan password saat ini untuk memverifikasi identitas Anda.</span>
        </div>

        <div class="form-group">
            <label class="form-label" for="password_baru">Password Baru <span style="color:var(--danger)">*</span></label>
            <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Minimal 6 karakter" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="konfirmasi">Konfirmasi Password Baru <span style="color:var(--danger)">*</span></label>
            <input type="password" class="form-control" id="konfirmasi" name="konfirmasi" placeholder="Ketik ulang password baru" required>
        </div>

        <div style="margin-top: 24px; border-top: 1px solid var(--card-border); padding-top: 20px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">💾 Update Password</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
