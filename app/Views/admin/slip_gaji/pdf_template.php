<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - <?= esc($slip['nama_karyawan']) ?> - <?= esc($slip['nama_periode']) ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.4;
        }
        
        .slip-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px double #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .company-subtitle {
            font-size: 11px;
            color: #666;
            margin: 2px 0 0 0;
        }

        .slip-title {
            text-align: right;
            margin: 0;
        }

        .slip-title h2 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            color: #111;
        }

        .slip-title p {
            font-size: 12px;
            color: #555;
            margin: 4px 0 0 0;
            font-weight: 500;
        }

        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .info-table td.label {
            width: 35%;
            color: #666;
            font-weight: 500;
        }

        .info-table td.value {
            font-weight: 600;
            color: #111;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .details-box {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }

        .details-box-header {
            background: #f5f5f5;
            font-weight: 700;
            padding: 10px 14px;
            border-bottom: 1px solid #e0e0e0;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 8px 14px;
            border-bottom: 1px solid #f0f0f0;
        }

        .details-table tr:last-child td {
            border-bottom: none;
        }

        .details-table td.amount {
            text-align: right;
            font-weight: 600;
            font-family: monospace;
            font-size: 13px;
        }

        .total-row {
            background: #fafafa;
            font-weight: 700;
            border-top: 1px solid #e0e0e0;
        }

        .total-row td {
            padding: 10px 14px !important;
            font-size: 13px;
        }

        .take-home-pay-box {
            background: #f0fdf4;
            border: 2px solid #bbf7d0;
            padding: 16px 20px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .thp-title {
            font-size: 14px;
            font-weight: 700;
            color: #14532d;
            text-transform: uppercase;
            margin: 0;
        }

        .thp-amount {
            font-size: 20px;
            font-weight: 800;
            color: #15803d;
            margin: 0;
            font-family: monospace;
        }

        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            text-align: center;
            margin-top: 50px;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 5px;
            font-weight: 600;
            color: #333;
        }

        .signature-title {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }

        @media print {
            body {
                padding: 0;
                background: #white;
            }
            .slip-container {
                border: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- Print Toolbar (Only visible in browser preview, not on printed paper) -->
<div class="no-print" style="max-width:800px; margin: 0 auto 20px auto; padding: 12px 20px; background:#f1f5f9; border-radius:6px; display:flex; justify-content:space-between; align-items:center; border:1px solid #cbd5e1;">
    <span style="font-weight:600; color:#334155; font-size:13px;">📄 Slip Gaji Mode Pratinjau Cetak</span>
    <button onclick="window.print()" style="background:#6366f1; color:white; border:none; padding:8px 16px; border-radius:6px; font-weight:600; cursor:pointer; font-size:13px;">🖨️ Cetak Dokumen</button>
</div>

<div class="slip-container">
    <!-- Header -->
    <div class="header">
        <div>
            <h1 class="company-title">PT. MAJU BERSAMA JAYA</h1>
            <p class="company-subtitle">Jl. Jenderal Sudirman No. 45, Jakarta Selatan | Telp: (021) 555-0192</p>
        </div>
        <div class="slip-title">
            <h2>Slip Gaji Karyawan</h2>
            <p>Periode: <?= esc($slip['nama_periode']) ?></p>
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">NIK</td>
                <td class="value">: <?= esc($slip['nik'] ?: '-') ?></td>
            </tr>
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="value">: <?= esc($slip['nama_karyawan']) ?></td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="value">: <?= esc($slip['nama_jabatan'] ?? '-') ?></td>
            </tr>
            <tr>
                <td class="label">Departemen</td>
                <td class="value">: <?= esc($slip['nama_departemen'] ?? '-') ?></td>
            </tr>
        </table>
        <table class="info-table">
            <tr>
                <td class="label">Nama Bank</td>
                <td class="value">: <?= esc($slip['nama_bank'] ?: '-') ?></td>
            </tr>
            <tr>
                <td class="label">No. Rekening</td>
                <td class="value">: <?= esc($slip['no_rekening'] ?: '-') ?></td>
            </tr>
            <tr>
                <td class="label">NPWP</td>
                <td class="value">: <?= esc($slip['npwp'] ?: '-') ?></td>
            </tr>
            <tr>
                <td class="label">Status Pajak</td>
                <td class="value">: <?= esc(($slip['status_pernikahan'] ?? 'TK') ?: 'TK') ?> (PTKP)</td>
            </tr>
        </table>
    </div>

    <!-- Earnings & Deductions Details -->
    <div class="details-grid">
        <!-- Pendapatan -->
        <div class="details-box">
            <div class="details-box-header">I. Pendapatan (Earnings)</div>
            <table class="details-table">
                <tr>
                    <td>Gaji Pokok</td>
                    <td class="amount">Rp <?= number_format($slip['gaji_pokok'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Tunjangan Tetap</td>
                    <td class="amount">Rp <?= number_format($slip['tunjangan_tetap'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Tunjangan Tidak Tetap</td>
                    <td class="amount">Rp <?= number_format($slip['tunjangan_tidak_tetap'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Bonus & Insentif</td>
                    <td class="amount">Rp <?= number_format($slip['bonus'], 0, ',', '.') ?></td>
                </tr>
                <!-- Koreksi Positif -->
                <?php if ($slip['is_koreksi'] && $slip['koreksi_nominal'] >= 0): ?>
                    <tr>
                        <td>Penyesuaian (<?= esc($slip['koreksi_keterangan']) ?>)</td>
                        <td class="amount" style="color: #16a34a;">Rp <?= number_format($slip['koreksi_nominal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endif; ?>
                
                <!-- Spacer to keep lists clean -->
                <?php if ($slip['is_koreksi'] && $slip['koreksi_nominal'] < 0): ?>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                <?php endif; ?>
                
                <tr class="total-row">
                    <td>Total Pendapatan (A)</td>
                    <td class="amount">
                        <?php
                            $totalPend = $slip['gaji_pokok'] + $slip['tunjangan_tetap'] + $slip['tunjangan_tidak_tetap'] + $slip['bonus'];
                            if ($slip['is_koreksi'] && $slip['koreksi_nominal'] >= 0) $totalPend += $slip['koreksi_nominal'];
                            echo 'Rp ' . number_format($totalPend, 0, ',', '.');
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Potongan -->
        <div class="details-box">
            <div class="details-box-header">II. Potongan (Deductions)</div>
            <table class="details-table">
                <tr>
                    <td>Pajak Penghasilan (PPh 21)</td>
                    <td class="amount">Rp <?= number_format($slip['potongan_pph21'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>BPJS Kesehatan (1%)</td>
                    <td class="amount">Rp <?= number_format($slip['potongan_bpjs_kes_karyawan'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>BPJS Ketenagakerjaan JHT (2%)</td>
                    <td class="amount">Rp <?= number_format($slip['potongan_bpjs_tk_jht'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>BPJS Ketenagakerjaan JP (1%)</td>
                    <td class="amount">Rp <?= number_format($slip['potongan_bpjs_tk_jp'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Potongan Lain-Lain</td>
                    <td class="amount">Rp <?= number_format($slip['potongan_lain'], 0, ',', '.') ?></td>
                </tr>
                <!-- Koreksi Negatif -->
                <?php if ($slip['is_koreksi'] && $slip['koreksi_nominal'] < 0): ?>
                    <tr>
                        <td>Penyesuaian (<?= esc($slip['koreksi_keterangan']) ?>)</td>
                        <td class="amount" style="color: #dc2626;">Rp <?= number_format(abs($slip['koreksi_nominal']), 0, ',', '.') ?></td>
                    </tr>
                <?php endif; ?>
                
                <!-- Spacer alignment -->
                <?php if ($slip['is_koreksi'] && $slip['koreksi_nominal'] >= 0): ?>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                <?php endif; ?>
                
                <tr class="total-row">
                    <td>Total Potongan (B)</td>
                    <td class="amount">
                        <?php
                            $totalPot = $slip['potongan_pph21'] + $slip['potongan_bpjs_kes_karyawan'] + $slip['potongan_bpjs_tk_jht'] + $slip['potongan_bpjs_tk_jp'] + $slip['potongan_lain'];
                            if ($slip['is_koreksi'] && $slip['koreksi_nominal'] < 0) $totalPot += abs($slip['koreksi_nominal']);
                            echo 'Rp ' . number_format($totalPot, 0, ',', '.');
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Take Home Pay (Net Salary) -->
    <div class="take-home-pay-box">
        <h3 class="thp-title">Gaji Bersih Diterima (Take Home Pay)</h3>
        <h2 class="thp-amount">Rp <?= number_format($slip['gaji_bersih'], 0, ',', '.') ?></h2>
    </div>

    <p style="font-size: 11px; color:#555; font-style:italic; margin-bottom: 20px;">* BPJS iuran perusahaan ditanggung oleh PT. MAJU BERSAMA JAYA sebesar Rp <?= number_format($slip['bpjs_kes_perusahaan'] + $slip['bpjs_tk_perusahaan'], 0, ',', '.') ?> (tidak memotong gaji bersih).</p>

    <!-- Signatures -->
    <div class="signatures">
        <div>
            <p>Penerima Gaji,</p>
            <div class="signature-line"><?= esc($slip['nama_karyawan']) ?></div>
            <div class="signature-title">Karyawan</div>
        </div>
        <div>
            <p>Jakarta, <?= date('d F Y', strtotime($slip['created_at'])) ?></p>
            <div class="signature-line">Administrator HR</div>
            <div class="signature-title">HR & Payroll Department</div>
        </div>
    </div>
</div>

</body>
</html>
