<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="stats-grid" style="margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(99,102,241,0.15);">📅</div>
        <div class="stat-info">
            <div class="stat-value"><?= esc($periode['nama_periode']) ?></div>
            <div class="stat-label">Periode Penggajian</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16,185,129,0.15);">💰</div>
        <div class="stat-info">
            <div class="stat-value">Rp <?= number_format($totalGaji, 0, ',', '.') ?></div>
            <div class="stat-label">Total Pengeluaran Gaji Bersih</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(6,182,212,0.15);">👥</div>
        <div class="stat-info">
            <div class="stat-value"><?= count($detail) ?></div>
            <div class="stat-label">Karyawan Terproses</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">🔍 Preview & Penyesuaian Gaji Karyawan</h2>
        <div style="display: flex; gap: 12px;">
            <a href="<?= base_url('admin/payroll') ?>" class="btn btn-ghost btn-sm">⬅️ Batal</a>
            <form action="<?= base_url('admin/payroll/finalisasi/' . $periode['id_periode']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin memfinalisasi penggajian periode ini? Slip gaji akan langsung diterbitkan dan data tidak dapat diubah lagi.')">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-success btn-sm">🔒 Finalisasi Penggajian</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table style="font-size: 13px;">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Pendapatan Pokok</th>
                    <th>Pendapatan Tambahan</th>
                    <th>Potongan BPJS (Kar)</th>
                    <th>PPh 21</th>
                    <th>Potongan Lain</th>
                    <th>Koreksi</th>
                    <th>Gaji Bersih</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail as $d): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: var(--text);"><?= esc($d['nama_karyawan']) ?></div>
                            <span style="font-size: 11px; color: var(--text-dim);"><?= esc($d['nama_jabatan'] ?? '-') ?></span>
                        </td>
                        <td>
                            <div>Gaji Pokok: Rp <?= number_format($d['gaji_pokok'], 0, ',', '.') ?></div>
                            <span style="font-size: 11px; color: var(--text-dim);">Tunj. Tetap: Rp <?= number_format($d['tunjangan_tetap'], 0, ',', '.') ?></span>
                        </td>
                        <td>
                            <div>Tunj. Var: Rp <?= number_format($d['tunjangan_tidak_tetap'], 0, ',', '.') ?></div>
                            <span style="font-size: 11px; color: var(--text-dim);">Bonus: Rp <?= number_format($d['bonus'], 0, ',', '.') ?></span>
                        </td>
                        <td>
                            <div>Kes: Rp <?= number_format($d['potongan_bpjs_kes_karyawan'], 0, ',', '.') ?></div>
                            <span style="font-size: 11px; color: var(--text-dim);">TK: Rp <?= number_format($d['potongan_bpjs_tk_jht'] + $d['potongan_bpjs_tk_jp'], 0, ',', '.') ?></span>
                        </td>
                        <td style="color: #fca5a5;">Rp <?= number_format($d['potongan_pph21'], 0, ',', '.') ?></td>
                        <td style="color: #fca5a5;">Rp <?= number_format($d['potongan_lain'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($d['is_koreksi']): ?>
                                <div style="color: <?= $d['koreksi_nominal'] >= 0 ? '#6ee7b7' : '#fca5a5' ?>; font-weight: 600;">
                                    <?= $d['koreksi_nominal'] >= 0 ? '+' : '' ?>Rp <?= number_format($d['koreksi_nominal'], 0, ',', '.') ?>
                                </div>
                                <span style="font-size: 10px; color: var(--text-dim); display: block; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= esc($d['koreksi_keterangan']) ?>">
                                    <?= esc($d['koreksi_keterangan']) ?>
                                </span>
                            <?php else: ?>
                                <span style="color: var(--text-dim);">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight: 700; color: var(--success); font-size: 14px;">
                            Rp <?= number_format($d['gaji_bersih'], 0, ',', '.') ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-ghost btn-sm" style="padding: 6px 10px;" 
                                    onclick="bukaModalKoreksi(<?= $d['id_detail'] ?>, '<?= esc($d['nama_karyawan']) ?>', <?= (int)$d['koreksi_nominal'] ?>, '<?= esc($d['koreksi_keterangan'] ?? '') ?>')">
                                ⚙️ Koreksi
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Koreksi -->
<div id="modalKoreksi" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 200; align-items: center; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 440px; margin: 20px; background: #1e2433; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
        <div class="card-header" style="margin-bottom: 16px;">
            <h3 class="card-title" id="koreksiModalTitle">Koreksi Gaji</h3>
            <button type="button" class="btn btn-ghost btn-sm" onclick="tutupModalKoreksi()" style="padding: 4px 8px;">✕</button>
        </div>
        <form id="formKoreksi" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="koreksi_nominal">Nominal Penyesuaian (Rp) <span style="color:var(--danger)">*</span></label>
                <input type="number" class="form-control" id="koreksi_nominal" name="koreksi_nominal" placeholder="Gunakan tanda minus (-) untuk memotong" required>
                <span style="font-size: 11px; color: var(--text-dim); display: block; margin-top: 4px;">Contoh: 150000 untuk menambah, atau -100000 untuk memotong.</span>
            </div>
            <div class="form-group">
                <label class="form-label" for="koreksi_keterangan">Alasan Koreksi <span style="color:var(--danger)">*</span></label>
                <textarea class="form-control" id="koreksi_keterangan" name="koreksi_keterangan" placeholder="Contoh: Koreksi keterlambatan atau bonus lembur manual" required></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn btn-ghost" onclick="tutupModalKoreksi()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Koreksi</button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaModalKoreksi(idDetail, namaKaryawan, nominalExisting, keteranganExisting) {
    const modal = document.getElementById('modalKoreksi');
    const form = document.getElementById('formKoreksi');
    const title = document.getElementById('koreksiModalTitle');
    const inputNominal = document.getElementById('koreksi_nominal');
    const inputKeterangan = document.getElementById('koreksi_keterangan');

    title.textContent = 'Koreksi Gaji: ' + namaKaryawan;
    form.action = '<?= base_url('admin/payroll/koreksi') ?>/' + idDetail;
    inputNominal.value = nominalExisting;
    inputKeterangan.value = keteranganExisting;

    modal.style.display = 'flex';
}

function tutupModalKoreksi() {
    document.getElementById('modalKoreksi').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('modalKoreksi');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<?= $this->endSection() ?>
