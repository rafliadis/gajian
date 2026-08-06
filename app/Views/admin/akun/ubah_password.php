<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card" style="max-width: 460px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">🔑 Ubah Password Saya</h2>
    </div>

    <form action="<?= base_url('admin/akun/ubah-password') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="password_lama">Password Saat Ini <span style="color:var(--danger)">*</span></label>
            <input type="password" class="form-control" id="password_lama" name="password_lama" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="password_baru">Password Baru <span style="color:var(--danger)">*</span></label>
            <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Minimal 6 karakter" required>
        </div>

        <div style="margin-top: 24px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">💾 Update Password Saya</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
