<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">➕ Buka Periode Penggajian Baru</h2>
        <a href="<?= base_url('admin/payroll') ?>" class="btn btn-ghost btn-sm">⬅️ Kembali</a>
    </div>

    <form action="<?= base_url('admin/payroll/run') ?>" method="post">
        <?= csrf_field() ?>

        <div class="alert alert-info" style="font-size: 13px; line-height: 1.4; margin-bottom: 20px;">
            ℹ️ Sistem akan secara otomatis menghitung Gaji Pokok, Tunjangan Tetap, BPJS, Pajak PPh 21, serta komponen gaji tambahan lain yang telah diatur untuk seluruh karyawan aktif pada periode yang dipilih.
        </div>

        <div class="form-group">
            <label class="form-label" for="bulan">Pilih Bulan Periode</label>
            <select class="form-control" id="bulan" name="bulan" required>
                <?php
                    $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $currentBulan = (int) date('m');
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = ($i === $currentBulan) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>{$namaBulan[$i]}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="tahun">Pilih Tahun Periode</label>
            <select class="form-control" id="tahun" name="tahun" required>
                <?php
                    $currentYear = (int) date('Y');
                    for ($y = $currentYear - 2; $y <= $currentYear + 2; $y++) {
                        $selected = ($y === $currentYear) ? 'selected' : '';
                        echo "<option value=\"$y\" $selected>$y</option>";
                    }
                ?>
            </select>
        </div>

        <div style="margin-top: 24px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
            <a href="<?= base_url('admin/payroll') ?>" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">⚡ Proses Penggajian Baru</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
