<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 24px; align-items: start;">
    
    <!-- Bagian Kiri: Daftar Akun Terdaftar -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">👤 Akun Pengguna Sistem</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email & Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: var(--text);"><?= esc($u['username']) ?></div>
                                    <span style="font-size: 11px; color: var(--text-dim);">Last Login: <?= $u['last_login'] ? date('d/m H:i', strtotime($u['last_login'])) : '-' ?></span>
                                </td>
                                <td>
                                    <div style="font-size: 13px; color: var(--text-muted);"><?= esc($u['email']) ?></div>
                                    <span class="badge badge-primary" style="font-size: 10px; padding: 2px 6px;"><?= strtoupper($u['role']) ?></span>
                                </td>
                                <td>
                                    <?php if ($u['is_active']): ?>
                                        <span class="badge badge-success">AKTIF</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger" style="background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2);">NONAKTIF</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="<?= base_url('admin/akun/reset-password/' . $u['id']) ?>" class="btn btn-ghost btn-sm" style="padding: 4px 8px;" title="Reset Password">🔑 Reset</a>
                                        <?php if ($u['role'] !== 'admin'): ?>
                                            <a href="<?= base_url('admin/akun/toggle/' . $u['id']) ?>" 
                                               class="btn <?= $u['is_active'] ? 'btn-danger' : 'btn-success' ?> btn-sm" 
                                               style="padding: 4px 8px;"
                                               onclick="return confirm('Apakah Anda yakin ingin <?= $u['is_active'] ? 'menonaktifkan' : 'mengaktifkan' ?> akun ini?')">
                                                <?= $u['is_active'] ? '🛑 Off' : '✅ On' ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center; color:var(--text-dim); padding:40px;">Belum ada akun terdaftar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bagian Kanan: Karyawan Belum Punya Akun -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">⚠️ Karyawan Tanpa Akun</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $karyawanTanpaAkun = array_filter($karyawan, function($k) {
                            return !$k['has_akun'] && $k['status'] === 'aktif';
                        });

                        if (!empty($karyawanTanpaAkun)):
                            foreach ($karyawanTanpaAkun as $k):
                    ?>
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--text);"><?= esc($k['nama_karyawan']) ?></div>
                                <span style="font-size: 11px; color: var(--text-dim);"><?= esc($k['nik'] ?: '-') ?></span>
                            </td>
                            <td style="color: var(--text-muted); font-size: 13px;"><?= esc($k['nama_jabatan'] ?? '-') ?></td>
                            <td>
                                <a href="<?= base_url('admin/akun/buat-akun/' . $k['id_karyawan']) ?>" class="btn btn-primary btn-sm" style="padding: 6px 10px;">
                                    ➕ Buat Akun
                                </a>
                            </td>
                        </tr>
                    <?php
                            endforeach;
                        else:
                    ?>
                        <tr><td colspan="3" style="text-align:center; color:var(--text-dim); padding:40px;">Semua karyawan aktif telah memiliki akun login.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
