<?= $this->extend('layout/karyawan') ?>
<?= $this->section('content') ?>

<?php
    $totalPend = $slip['gaji_pokok'] + $slip['tunjangan_tetap'] + $slip['tunjangan_tidak_tetap'] + $slip['bonus'];
    if ($slip['is_koreksi'] && $slip['koreksi_nominal'] >= 0) $totalPend += $slip['koreksi_nominal'];

    $totalPot = $slip['potongan_pph21'] + $slip['potongan_bpjs_kes_karyawan'] + $slip['potongan_bpjs_tk_jht'] + $slip['potongan_bpjs_tk_jp'] + $slip['potongan_lain'];
    if ($slip['is_koreksi'] && $slip['koreksi_nominal'] < 0) $totalPot += abs($slip['koreksi_nominal']);

    $takeHomeRatio = $totalPend > 0 ? ($slip['gaji_bersih'] / $totalPend) * 100 : 0;
?>

<div style="max-width: 800px; margin: 0 auto;">
    
    <!-- Take Home Pay Header Card -->
    <div class="card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-color: #bbf7d0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <span style="font-size: 11px; color: #166534; text-transform: uppercase; letter-spacing: 0.05em;">Gaji Bersih Diterima</span>
                <h2 style="font-size: 28px; font-weight: 800; color: #15803d; margin-top: 4px;">Rp <?= number_format($slip['gaji_bersih'], 0, ',', '.') ?></h2>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 11px; color: #166534; text-transform: uppercase; display: block;">Periode</span>
                <span style="font-size: 15px; font-weight: 700; color: #14532d;"><?= esc($slip['nama_periode']) ?></span>
            </div>
        </div>

        <!-- Progress Bar (Earnings vs Deductions) -->
        <div style="margin-bottom: 6px;">
            <div style="display: flex; justify-content: space-between; font-size: 12px; color: #166534; margin-bottom: 6px;">
                <span>Rasio Take Home Pay</span>
                <span><?= number_format($takeHomeRatio, 1) ?>% dari total pendapatan</span>
            </div>
            <div style="width: 100%; height: 8px; background: rgba(0, 0, 0, 0.06); border-radius: 4px; overflow: hidden;">
                <div style="width: <?= $takeHomeRatio ?>%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--success)); border-radius: 4px;"></div>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
        
        <!-- Pendapatan (Earnings) -->
        <div class="card">
            <h3 style="font-size: 14px; color: var(--primary); border-bottom: 1px solid var(--card-border); padding-bottom: 8px; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">I. Pendapatan</h3>
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">Gaji Pokok</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['gaji_pokok'], 0, ',', '.') ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">Tunjangan Tetap</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['tunjangan_tetap'], 0, ',', '.') ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">Tunjangan Tidak Tetap</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['tunjangan_tidak_tetap'], 0, ',', '.') ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">Bonus & Insentif</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['bonus'], 0, ',', '.') ?></span>
                </div>

                <!-- Koreksi Positif -->
                <?php if ($slip['is_koreksi'] && $slip['koreksi_nominal'] >= 0): ?>
                    <div style="display: flex; justify-content: space-between; font-size: 14px; background: #d1fae5; padding: 8px; border-radius: 6px; border: 1px solid #a7f3d0;">
                        <span style="color: #047857; font-weight: 500;">Penyesuaian (<?= esc($slip['koreksi_keterangan']) ?>)</span>
                        <span style="font-weight: 600; color: #047857;">+Rp <?= number_format($slip['koreksi_nominal'], 0, ',', '.') ?></span>
                    </div>
                <?php endif; ?>

                <div style="border-top: 1px solid var(--card-border); padding-top: 14px; display: flex; justify-content: space-between; font-size: 14px; font-weight: 700;">
                    <span style="color: var(--text);">Total Pendapatan</span>
                    <span style="color: var(--text);">Rp <?= number_format($totalPend, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <!-- Potongan (Deductions) -->
        <div class="card">
            <h3 style="font-size: 14px; color: var(--primary); border-bottom: 1px solid var(--card-border); padding-bottom: 8px; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">II. Potongan</h3>
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">Pajak PPh 21</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['potongan_pph21'], 0, ',', '.') ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">BPJS Kesehatan (1%)</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['potongan_bpjs_kes_karyawan'], 0, ',', '.') ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">BPJS TK JHT (2%)</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['potongan_bpjs_tk_jht'], 0, ',', '.') ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">BPJS TK JP (1%)</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['potongan_bpjs_tk_jp'], 0, ',', '.') ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 14px;">
                    <span style="color: var(--text-muted);">Potongan Lain-Lain</span>
                    <span style="font-weight: 600; color: var(--text);">Rp <?= number_format($slip['potongan_lain'], 0, ',', '.') ?></span>
                </div>

                <!-- Koreksi Negatif -->
                <?php if ($slip['is_koreksi'] && $slip['koreksi_nominal'] < 0): ?>
                    <div style="display: flex; justify-content: space-between; font-size: 14px; background: #fee2e2; padding: 8px; border-radius: 6px; border: 1px solid #fca5a5;">
                        <span style="color: #b91c1c; font-weight: 500;">Penyesuaian (<?= esc($slip['koreksi_keterangan']) ?>)</span>
                        <span style="font-weight: 600; color: #b91c1c;">-Rp <?= number_format(abs($slip['koreksi_nominal']), 0, ',', '.') ?></span>
                    </div>
                <?php endif; ?>

                <div style="border-top: 1px solid var(--card-border); padding-top: 14px; display: flex; justify-content: space-between; font-size: 14px; font-weight: 700;">
                    <span style="color: var(--text);">Total Potongan</span>
                    <span style="color: var(--text);">Rp <?= number_format($totalPot, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

    </div>

    <!-- Actions Footer -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--card-border); padding-top: 20px;">
        <a href="<?= base_url('karyawan/slip-gaji') ?>" class="btn btn-ghost">⬅️ Kembali ke Riwayat</a>
        <a href="<?= base_url('karyawan/slip-gaji/download/' . $slip['id_detail']) ?>" target="_blank" class="btn btn-primary">
            🖨️ Cetak / Download PDF
        </a>
    </div>

</div>

<?= $this->endSection() ?>
