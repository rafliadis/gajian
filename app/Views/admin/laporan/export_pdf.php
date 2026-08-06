<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Gaji - <?= esc($periode['nama_periode']) ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 20px;
            font-size: 11px;
            line-height: 1.3;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0 0 4px 0;
            text-transform: uppercase;
        }

        .header p {
            font-size: 11px;
            color: #666;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background: #f5f5f5;
            color: #333;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            padding: 8px 6px;
            border: 1px solid #ddd;
            text-align: left;
        }

        td {
            padding: 8px 6px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        td.number {
            text-align: right;
            font-family: monospace;
            font-size: 10px;
        }

        .total-row {
            background: #fafafa;
            font-weight: 700;
        }

        .total-row td {
            font-size: 10px;
            border-top: 2px solid #333;
        }

        .signatures-container {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-box {
            text-align: center;
            width: 250px;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 5px;
            font-weight: 600;
        }

        .no-print-toolbar {
            max-width: 100%;
            margin: 0 auto 20px auto;
            padding: 12px 20px;
            background: #f1f5f9;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #cbd5e1;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print-toolbar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- Print Toolbar -->
<div class="no-print-toolbar">
    <span style="font-weight:600; color:#334155; font-size:12px;">📊 Laporan Rekap Gaji Bulanan (Landscape)</span>
    <button onclick="window.print()" style="background:#6366f1; color:white; border:none; padding:6px 12px; border-radius:6px; font-weight:600; cursor:pointer; font-size:12px;">🖨️ Cetak Rekap</button>
</div>

<div class="header">
    <h1>Rekapitulasi Gaji Karyawan</h1>
    <p>Periode: <?= esc($periode['nama_periode']) ?> | PT. MAJU BERSAMA JAYA</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Tunj. Tetap</th>
            <th>Tunj. Var</th>
            <th>Bonus</th>
            <th>Pot. BPJS (Kar)</th>
            <th>Pot. PPh21</th>
            <th>Pot. Lain</th>
            <th>Gaji Bersih</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $no = 1;
            $sumGajiPokok = 0;
            $sumTunjTetap = 0;
            $sumTunjVar = 0;
            $sumBonus = 0;
            $sumBpjs = 0;
            $sumPph = 0;
            $sumLain = 0;
            $sumBersih = 0;

            foreach ($detail as $d):
                $bpjsTotal = $d['potongan_bpjs_kes_karyawan'] + $d['potongan_bpjs_tk_jht'] + $d['potongan_bpjs_tk_jp'];
                $sumGajiPokok += $d['gaji_pokok'];
                $sumTunjTetap += $d['tunjangan_tetap'];
                $sumTunjVar   += $d['tunjangan_tidak_tetap'];
                $sumBonus     += $d['bonus'];
                if ($d['is_koreksi'] && $d['koreksi_nominal'] >= 0) $sumBonus += $d['koreksi_nominal']; // Map positive adjustment to bonus/extra
                $sumBpjs      += $bpjsTotal;
                $sumPph       += $d['potongan_pph21'];
                
                $potLainActual = $d['potongan_lain'];
                if ($d['is_koreksi'] && $d['koreksi_nominal'] < 0) $potLainActual += abs($d['koreksi_nominal']); // Map negative adjustment to other deductions
                $sumLain      += $potLainActual;
                
                $sumBersih    += $d['gaji_bersih'];
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td style="font-family: monospace;"><?= esc($d['nik'] ?: '-') ?></td>
                <td style="font-weight: 600;"><?= esc($d['nama_karyawan']) ?></td>
                <td><?= esc($d['nama_jabatan'] ?? '-') ?></td>
                <td class="number">Rp <?= number_format($d['gaji_pokok'], 0, ',', '.') ?></td>
                <td class="number">Rp <?= number_format($d['tunjangan_tetap'], 0, ',', '.') ?></td>
                <td class="number">Rp <?= number_format($d['tunjangan_tidak_tetap'], 0, ',', '.') ?></td>
                <td class="number">
                    <?php
                        $bonusVal = $d['bonus'];
                        if ($d['is_koreksi'] && $d['koreksi_nominal'] >= 0) $bonusVal += $d['koreksi_nominal'];
                        echo 'Rp ' . number_format($bonusVal, 0, ',', '.');
                    ?>
                </td>
                <td class="number">Rp <?= number_format($bpjsTotal, 0, ',', '.') ?></td>
                <td class="number">Rp <?= number_format($d['potongan_pph21'], 0, ',', '.') ?></td>
                <td class="number">
                    <?php
                        echo 'Rp ' . number_format($potLainActual, 0, ',', '.');
                    ?>
                </td>
                <td class="number" style="font-weight: 600; color: #16a34a;">Rp <?= number_format($d['gaji_bersih'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        
        <tr class="total-row">
            <td colspan="4" style="text-align: center; font-weight: 700;">TOTAL</td>
            <td class="number">Rp <?= number_format($sumGajiPokok, 0, ',', '.') ?></td>
            <td class="number">Rp <?= number_format($sumTunjTetap, 0, ',', '.') ?></td>
            <td class="number">Rp <?= number_format($sumTunjVar, 0, ',', '.') ?></td>
            <td class="number">Rp <?= number_format($sumBonus, 0, ',', '.') ?></td>
            <td class="number">Rp <?= number_format($sumBpjs, 0, ',', '.') ?></td>
            <td class="number">Rp <?= number_format($sumPph, 0, ',', '.') ?></td>
            <td class="number">Rp <?= number_format($sumLain, 0, ',', '.') ?></td>
            <td class="number">Rp <?= number_format($sumBersih, 0, ',', '.') ?></td>
        </tr>
    </tbody>
</table>

<div class="signatures-container">
    <div class="signature-box">
        <p>Disetujui Oleh,</p>
        <div class="signature-line">Administrator Keuangan</div>
        <p style="margin: 3px 0 0 0; font-size: 10px; color: #666;">Direktur Keuangan / HRD</p>
    </div>
</div>

</body>
</html>
