<?php
/**
 * Laporan Stok Barang - YSP Jasmine (untuk Dompdf)
 * Variabel yang dipakai: $barang, $stok_habis, $stok_menipis, $total_barang
 */
$barang       = $barang ?? [];
$stok_habis   = (int) ($stok_habis ?? 0);
$stok_menipis = (int) ($stok_menipis ?? 0);
$total_barang = (int) ($total_barang ?? count($barang));
$tersedia     = max(0, $total_barang - $stok_habis - $stok_menipis);

$total_unit = 0;
foreach ($barang as $row) {
    $total_unit += max(0, (int) $row['stok']);
}

// Logo (di-embed base64 supaya pasti tampil di PDF)
$logo_base64 = '';
$logo_path   = ROOTPATH . 'public/uploads/logo.png';
if (is_file($logo_path)) {
    $logo_data = @file_get_contents($logo_path);
    if ($logo_data !== false) {
        $logo_base64 = base64_encode($logo_data);
    }
}

$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tanggal_cetak = date('d') . ' ' . $bulan[(int) date('n') - 1] . ' ' . date('Y');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Barang - YSP Jasmine</title>
    <style>
        @page { margin: 30pt 34pt 52pt 34pt; }

        body, div, p, table, th, td { margin: 0; padding: 0; }

        body {
            font-family: 'DejaVu Sans', Helvetica, Arial, sans-serif;
            font-size: 9px;
            color: #1b1b1b;
            line-height: 1.45;
            background: #ffffff;
        }

        .serif { font-family: 'DejaVu Serif', Georgia, 'Times New Roman', serif; }
        .right { text-align: right; }
        .center { text-align: center; }

        /* ===== KOP ===== */
        .kop { width: 100%; border-collapse: collapse; }
        .kop td { vertical-align: middle; border: none; padding: 0; }
        .kop .logo-cell { width: 62px; }
        .kop .logo-cell img { height: 48px; width: auto; }
        .brand-name {
            font-size: 17px;
            letter-spacing: 2px;
            color: #164534;
            text-transform: uppercase;
        }
        .brand-tag {
            font-size: 7px;
            letter-spacing: 3px;
            color: #b8963e;
            margin-top: 2px;
        }
        .brand-addr { font-size: 7.5px; color: #6d6d6d; margin-top: 4px; }
        .doc-label {
            font-size: 7px;
            letter-spacing: 2px;
            color: #6d6d6d;
            text-transform: uppercase;
        }
        .doc-title { font-size: 15px; color: #164534; margin-top: 2px; }
        .doc-date  { font-size: 8px; color: #6d6d6d; margin-top: 3px; }

        .rule-gold  { height: 2px; background: #b8963e; margin: 12px 0 0 0; }
        .rule-green { height: 4px; background: #164534; margin: 0 0 16px 0; }

        /* ===== RINGKASAN ===== */
        .sum { width: 103%; border-collapse: separate; border-spacing: 8px 0; margin-left: -8px; }
        .sum td {
            width: 25%;
            background: #f7f5f0;
            border: 1px solid #e9e7e2;
            padding: 10px 12px;
            vertical-align: top;
        }
        .sum .lbl {
            font-size: 7px;
            letter-spacing: 1.3px;
            text-transform: uppercase;
            color: #6d6d6d;
        }
        .sum .num { font-size: 21px; margin-top: 3px; line-height: 1.1; }
        .sum .sub { font-size: 7px; color: #8a8a8a; margin-top: 2px; }
        .c-total { color: #164534; }
        .c-ok    { color: #1f5c46; }
        .c-warn  { color: #b26a00; }
        .c-out   { color: #c0392b; }
        .bar-total { border-top: 3px solid #164534 !important; }
        .bar-ok    { border-top: 3px solid #1f5c46 !important; }
        .bar-warn  { border-top: 3px solid #d99a2b !important; }
        .bar-out   { border-top: 3px solid #c0392b !important; }

        /* ===== CATATAN ===== */
        .note {
            margin-top: 14px;
            padding: 8px 12px;
            font-size: 8.5px;
            border-left: 3px solid #b8963e;
            background: #fbf8f0;
            color: #4a4a4a;
        }
        .note.alert { border-left-color: #c0392b; background: #fdf3f1; }
        .note b { color: #1b1b1b; }

        /* ===== JUDUL BAGIAN ===== */
        .sec { margin: 18px 0 8px 0; }
        .sec .t {
            font-size: 12px;
            color: #164534;
        }
        .sec .d { font-size: 8px; color: #6d6d6d; margin-top: 1px; }

        /* ===== TABEL ===== */
        table.data { width: 100%; border-collapse: collapse; }
        table.data thead th {
            background: #164534;
            color: #ffffff;
            font-size: 7.5px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 8px 9px;
            border: none;
            text-align: left;
        }
        table.data thead th.right  { text-align: right; }
        table.data thead th.center { text-align: center; }
        table.data tbody td {
            padding: 7px 9px;
            border-bottom: 1px solid #e9e7e2;
            vertical-align: middle;
            font-size: 9px;
        }
        table.data tbody tr { page-break-inside: avoid; }
        table.data tbody tr.alt td { background: #faf9f6; }
        table.data tbody tr.row-habis td { background: #fdf3f1; }
        table.data tfoot td {
            padding: 9px;
            background: #f7f5f0;
            border-top: 2px solid #b8963e;
            font-weight: bold;
            color: #164534;
            font-size: 9px;
        }
        .nm { font-weight: bold; color: #1b1b1b; }

        /* ===== BADGE ===== */
        .badge {
            display: inline-block;
            padding: 2px 9px;
            font-size: 7px;
            font-weight: bold;
            letter-spacing: .6px;
            text-transform: uppercase;
            border-radius: 9px;
        }
        .b-ok   { background: #e4efe9; color: #1f5c46; }
        .b-warn { background: #fbefd5; color: #9a5b00; }
        .b-out  { background: #f8dcd7; color: #b03021; }

        .qty-out  { color: #c0392b; font-weight: bold; }
        .qty-warn { color: #b26a00; font-weight: bold; }
        .qty-ok   { color: #1b1b1b; }

        /* ===== KETERANGAN ===== */
        .legend { margin-top: 12px; font-size: 7.5px; color: #6d6d6d; }
        .legend .badge { margin-right: 3px; }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            left: 0; right: 0; bottom: -38pt;
            border-top: 1px solid #e9e7e2;
            padding-top: 6px;
            font-size: 7px;
            color: #8a8a8a;
        }
        .footer table { width: 100%; border-collapse: collapse; }
        .footer td { border: none; padding: 0; font-size: 7px; color: #8a8a8a; }
        .pagenum:before { content: counter(page); }
    </style>
</head>
<body>

<div class="footer">
    <table>
        <tr>
            <td>&copy; <?= date('Y') ?> YSP Jasmine &middot; Laporan dicetak otomatis oleh sistem</td>
            <td class="right">Halaman <span class="pagenum"></span></td>
        </tr>
    </table>
</div>

<!-- ===== KOP ===== -->
<table class="kop">
    <tr>
        <?php if ($logo_base64 !== ''): ?>
        <td class="logo-cell">
            <img src="data:image/png;base64,<?= $logo_base64 ?>" alt="Logo">
        </td>
        <?php endif; ?>
        <td>
            <div class="brand-name serif">YSP Jasmine</div>
            <div class="brand-tag">PREMIUM QUALITY FLOWERS</div>
            <div class="brand-addr">Jl. Desa Kertosari, Pemalang &nbsp;&middot;&nbsp; Telp: 0856 4769 5804</div>
        </td>
        <td class="right" style="width: 34%;">
            <div class="doc-label">Laporan</div>
            <div class="doc-title serif">Stok Barang</div>
            <div class="doc-date">Dicetak: <?= $tanggal_cetak ?>, <?= date('H:i') ?> WIB</div>
        </td>
    </tr>
</table>
<div class="rule-gold"></div>
<div class="rule-green"></div>

<!-- ===== RINGKASAN ===== -->
<table class="sum">
    <tr>
        <td class="bar-total">
            <div class="lbl">Total Produk</div>
            <div class="num serif c-total"><?= number_format($total_barang, 0, ',', '.') ?></div>
            <div class="sub"><?= number_format($total_unit, 0, ',', '.') ?> unit di gudang</div>
        </td>
        <td class="bar-ok">
            <div class="lbl">Tersedia</div>
            <div class="num serif c-ok"><?= number_format($tersedia, 0, ',', '.') ?></div>
            <div class="sub">stok di atas 10</div>
        </td>
        <td class="bar-warn">
            <div class="lbl">Stok Menipis</div>
            <div class="num serif c-warn"><?= number_format($stok_menipis, 0, ',', '.') ?></div>
            <div class="sub">stok 1 &ndash; 10</div>
        </td>
        <td class="bar-out">
            <div class="lbl">Stok Habis</div>
            <div class="num serif c-out"><?= number_format($stok_habis, 0, ',', '.') ?></div>
            <div class="sub">stok 0</div>
        </td>
    </tr>
</table>

<?php if ($stok_habis > 0 || $stok_menipis > 0): ?>
    <div class="note <?= $stok_habis > 0 ? 'alert' : '' ?>">
        <b>Perlu perhatian:</b>
        <?php if ($stok_habis > 0): ?><?= $stok_habis ?> produk sudah habis<?php endif; ?><?php if ($stok_habis > 0 && $stok_menipis > 0): ?> dan <?php endif; ?><?php if ($stok_menipis > 0): ?><?= $stok_menipis ?> produk stoknya menipis<?php endif; ?>.
        Produk dengan stok paling sedikit ditampilkan paling atas agar mudah diprioritaskan untuk restok.
    </div>
<?php else: ?>
    <div class="note">
        <b>Semua aman.</b> Seluruh produk memiliki stok yang cukup.
    </div>
<?php endif; ?>

<!-- ===== DAFTAR STOK ===== -->
<div class="sec">
    <div class="t serif">Daftar Stok Barang</div>
    <div class="d">Diurutkan dari stok paling sedikit</div>
</div>

<table class="data">
    <thead>
        <tr>
            <th class="center" style="width: 7%;">No</th>
            <th style="width: 43%;">Nama Produk</th>
            <th class="right" style="width: 20%;">Harga</th>
            <th class="right" style="width: 15%;">Stok</th>
            <th class="center" style="width: 15%;">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($barang)): ?>
            <?php $no = 1; foreach ($barang as $b):
                $stok = (int) $b['stok'];
                if ($stok <= 0)       { $qc = 'qty-out';  $bc = 'b-out';  $bt = 'Habis';   $rc = 'row-habis'; }
                elseif ($stok <= 10)  { $qc = 'qty-warn'; $bc = 'b-warn'; $bt = 'Menipis'; $rc = ($no % 2 === 0) ? 'alt' : ''; }
                else                  { $qc = 'qty-ok';   $bc = 'b-ok';   $bt = 'Tersedia'; $rc = ($no % 2 === 0) ? 'alt' : ''; }
            ?>
            <tr class="<?= $rc ?>">
                <td class="center" style="color:#8a8a8a;"><?= $no++ ?></td>
                <td class="nm"><?= esc($b['nama_barang']) ?></td>
                <td class="right">Rp <?= number_format((float) $b['harga'], 0, ',', '.') ?></td>
                <td class="right <?= $qc ?>"><?= number_format($stok, 0, ',', '.') ?> unit</td>
                <td class="center"><span class="badge <?= $bc ?>"><?= $bt ?></span></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="center" style="padding: 28px; color: #8a8a8a;">
                    Belum ada data produk
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
    <?php if (!empty($barang)): ?>
    <tfoot>
        <tr>
            <td colspan="3" class="right">TOTAL</td>
            <td class="right"><?= number_format($total_unit, 0, ',', '.') ?> unit</td>
            <td class="center"><?= number_format($total_barang, 0, ',', '.') ?> produk</td>
        </tr>
    </tfoot>
    <?php endif; ?>
</table>

<div class="legend">
    Keterangan:
    <span class="badge b-ok">Tersedia</span> stok lebih dari 10 &nbsp;
    <span class="badge b-warn">Menipis</span> stok 1 &ndash; 10 &nbsp;
    <span class="badge b-out">Habis</span> stok 0
</div>

</body>
</html>