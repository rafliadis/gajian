<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card" style="max-width: 460px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">🔑 Reset Password User</h2>
        <a href="<?= base_url('admin/akun') ?>" class="btn btn-ghost btn-sm">⬅️ Kembali</a>
    </div>

    <form action="<?= base_url('admin/akun/reset-password/' . $user['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--card-border); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px;">
            <div style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; margin-bottom: 4px;">Akun Target</div>
            <div style="font-weight: 700; color: var(--text); font-size: 15px;"><?= esc($user['username']) ?></div>
            <div style="font-size: 13px; color: var(--text-muted); margin-top: 2px;"><?= esc($user['email']) ?></div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password Baru <span style="color:var(--danger)">*</span></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required autofocus>
            <span style="font-size: 11px; color: var(--text-dim); display: block; margin-top: 4px;">Masukkan password baru yang aman untuk akun ini.</span>
        </div>

        <div style="margin-top: 24px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
            <a href="<?= base_url('admin/akun') ?>" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Password</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
