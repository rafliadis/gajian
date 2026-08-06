<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div style="display: grid; grid-template-columns: 280px 1fr; gap: 24px; align-items: start;">
    
    <!-- Profil Singkat Karyawan (Kiri) -->
    <div class="card" style="text-align: center;">
        <div style="margin-bottom: 16px;">
            <?php if ($karyawan['foto'] && file_exists(FCPATH . 'uploads/karyawan/' . $karyawan['foto'])): ?>
                <img src="<?= base_url('uploads/karyawan/' . $karyawan['foto']) ?>" alt="Foto Karyawan" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary);">
            <?php else: ?>
                <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 800; color: white;">
                    <?= strtoupper(substr($karyawan['nama_karyawan'], 0, 1)) ?>
                </div>
            <?php endif; ?>
        </div>
        <h2 style="font-size: 16px; font-weight: 700; color: var(--text);"><?= esc($karyawan['nama_karyawan']) ?></h2>
        <p style="font-size: 12px; color: var(--text-dim); margin-bottom: 16px;"><?= esc($karyawan['nik'] ?: '-') ?></p>

        <div style="text-align: left; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 12px; font-size: 13px;">
            <div style="margin-bottom: 8px;">
                <span style="color: var(--text-dim); display: block; font-size: 11px;">Jabatan</span>
                <span style="font-weight: 600; color: var(--text);"><?= esc($karyawan['nama_jabatan'] ?? '-') ?></span>
            </div>
            <div style="margin-bottom: 8px;">
                <span style="color: var(--text-dim); display: block; font-size: 11px;">Gaji Pokok</span>
                <span style="font-weight: 600; color: var(--success);">Rp <?= number_format($karyawan['gaji_pokok'] ?? 0, 0, ',', '.') ?></span>
            </div>
            <div>
                <span style="color: var(--text-dim); display: block; font-size: 11px;">Tunjangan Tetap</span>
                <span style="font-weight: 600; color: var(--success);">Rp <?= number_format($karyawan['tunjangan_tetap'] ?? 0, 0, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <!-- Form Komponen Gaji (Kanan) -->
    <div class="card">
        <div class="card-header" style="margin-bottom: 24px;">
            <h2 class="card-title">⚙️ Konfigurasi Komponen Gaji</h2>
            <a href="<?= base_url('admin/komponen-gaji') ?>" class="btn btn-ghost btn-sm">⬅️ Kembali</a>
        </div>

        <form action="<?= base_url('admin/komponen-gaji/save/' . $karyawan['id_karyawan']) ?>" method="post">
            <?= csrf_field() ?>

            <h3 style="font-size: 14px; color: var(--primary-light); margin-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 6px;">💵 Pendapatan Tambahan & Potongan Variabel</h3>
            
            <div class="form-row-3">
                <div class="form-group">
                    <label class="form-label" for="tunjangan_tidak_tetap">Tunjangan Tidak Tetap (Rp)</label>
                    <input type="number" class="form-control" id="tunjangan_tidak_tetap" name="tunjangan_tidak_tetap" placeholder="Contoh: 500000" min="0" value="<?= old('tunjangan_tidak_tetap', isset($komponen['tunjangan_tidak_tetap']) ? (int)$komponen['tunjangan_tidak_tetap'] : '0') ?>">
                    <span style="font-size: 11px; color: var(--text-dim);">Uang makan, transport, dll.</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="bonus">Bonus / Insentif (Rp)</label>
                    <input type="number" class="form-control" id="bonus" name="bonus" placeholder="Contoh: 1000000" min="0" value="<?= old('bonus', isset($komponen['bonus']) ? (int)$komponen['bonus'] : '0') ?>">
                    <span style="font-size: 11px; color: var(--text-dim);">Bonus kinerja, THR, dll.</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="potongan_lain">Potongan Lain (Rp)</label>
                    <input type="number" class="form-control" id="potongan_lain" name="potongan_lain" placeholder="Contoh: 200000" min="0" value="<?= old('potongan_lain', isset($komponen['potongan_lain']) ? (int)$komponen['potongan_lain'] : '0') ?>">
                    <span style="font-size: 11px; color: var(--text-dim);">Keterlambatan, pinjaman, dll.</span>
                </div>
            </div>

            <h3 style="font-size: 14px; color: var(--primary-light); margin-top: 16px; margin-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 6px;">🛡️ Perlindungan Sosial & Perpajakan</h3>

            <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px;">
                    <input type="checkbox" name="ikut_bpjs_kesehatan" value="1" style="width: 18px; height: 18px; accent-color: var(--primary);" <?= old('ikut_bpjs_kesehatan', $komponen['ikut_bpjs_kesehatan'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <span><strong>Ikut BPJS Kesehatan</strong> (Potongan 1% Karyawan, 4% Perusahaan)</span>
                </label>
                
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px;">
                    <input type="checkbox" name="ikut_bpjs_tk" value="1" style="width: 18px; height: 18px; accent-color: var(--primary);" <?= old('ikut_bpjs_tk', $komponen['ikut_bpjs_tk'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <span><strong>Ikut BPJS Ketenagakerjaan</strong> (JHT: 2% Karyawan + JP: 1% Karyawan)</span>
                </label>

                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px;">
                    <input type="checkbox" name="kena_pph21" value="1" style="width: 18px; height: 18px; accent-color: var(--primary);" <?= old('kena_pph21', $komponen['kena_pph21'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <span><strong>Kena PPh 21 Pajak Penghasilan</strong> (Sesuai perhitungan PTKP tahunan)</span>
                </label>
            </div>

            <div class="form-group">
                <label class="form-label" for="keterangan">Keterangan Catatan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Catatan tambahan untuk penyesuaian penggajian..."><?= old('keterangan', $komponen['keterangan'] ?? '') ?></textarea>
            </div>

            <div style="border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
                <a href="<?= base_url('admin/komponen-gaji') ?>" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </div>

</div>

<?= $this->endSection() ?>
