<?php
/**
 * Laporan Penjualan - YSP Jasmine (untuk Dompdf)
 * Variabel: $total_transaksi, $total_pendapatan, $total_pelanggan,
 *           $produk_terlaris, $rata_rata_item, $start_date, $end_date
 */
$produk_terlaris  = $produk_terlaris ?? [];
$start_date       = $start_date ?? '';
$end_date         = $end_date ?? '';
$total_transaksi  = (int) ($total_transaksi ?? 0);
$total_pendapatan = (float) ($total_pendapatan ?? 0);
$total_pelanggan  = (int) ($total_pelanggan ?? 0);
$rata_rata_item   = (float) ($rata_rata_item ?? 0);

$rata_transaksi = $total_transaksi > 0 ? ($total_pendapatan / $total_transaksi) : 0;

// Ringkasan dari daftar produk terlaris
$total_unit  = 0;
$total_omzet = 0.0;
foreach ($produk_terlaris as $row) {
    $total_unit  += (int) $row['total_terjual'];
    $total_omzet += (float) $row['total_pendapatan'];
}
$jumlah_produk = count($produk_terlaris);

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
$fmt_tgl = function ($d) use ($bulan) {
    $t = strtotime($d);
    return date('d', $t) . ' ' . $bulan[(int) date('n', $t) - 1] . ' ' . date('Y', $t);
};
$tanggal_cetak = $fmt_tgl('now');

if (!empty($start_date) && !empty($end_date)) {
    $periode = $fmt_tgl($start_date) . ' &ndash; ' . $fmt_tgl($end_date);
} elseif (!empty($start_date)) {
    $periode = 'Mulai ' . $fmt_tgl($start_date);
} elseif (!empty($end_date)) {
    $periode = 'Sampai ' . $fmt_tgl($end_date);
} else {
    $periode = 'Semua transaksi';
}

$rp = function ($n) { return 'Rp ' . number_format((float) $n, 0, ',', '.'); };
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - YSP Jasmine</title>
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
        .brand-name { font-size: 17px; letter-spacing: 2px; color: #164534; text-transform: uppercase; }
        .brand-tag  { font-size: 7px; letter-spacing: 3px; color: #b8963e; margin-top: 2px; }
        .brand-addr { font-size: 7.5px; color: #6d6d6d; margin-top: 4px; }
        .doc-label  { font-size: 7px; letter-spacing: 2px; color: #6d6d6d; text-transform: uppercase; }
        .doc-title  { font-size: 15px; color: #164534; margin-top: 2px; }
        .doc-date   { font-size: 8px; color: #6d6d6d; margin-top: 3px; }

        .rule-gold  { height: 2px; background: #b8963e; margin: 12px 0 0 0; }
        .rule-green { height: 4px; background: #164534; margin: 0 0 14px 0; }

        /* ===== PERIODE ===== */
        .periode { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .periode td {
            background: #f7f5f0;
            border: 1px solid #e9e7e2;
            padding: 7px 12px;
            font-size: 8.5px;
            color: #4a4a4a;
        }
        .periode b { color: #164534; }

        /* ===== RINGKASAN ===== */
        .sum { width: 103%; border-collapse: separate; border-spacing: 8px 0; margin-left: -8px; }
        .sum td {
            width: 25%;
            background: #f7f5f0;
            border: 1px solid #e9e7e2;
            padding: 10px 12px;
            vertical-align: top;
        }
        .sum .lbl { font-size: 7px; letter-spacing: 1.3px; text-transform: uppercase; color: #6d6d6d; }
        .sum .num { font-size: 18px; margin-top: 3px; line-height: 1.15; }
        .sum .num.sm { font-size: 14px; margin-top: 6px; }
        .sum .sub { font-size: 7px; color: #8a8a8a; margin-top: 2px; }
        .c-green { color: #164534; }
        .c-gold  { color: #9c7b2c; }
        .c-mid   { color: #1f5c46; }
        .c-blue  { color: #2b6279; }
        .bar-1 { border-top: 3px solid #164534 !important; }
        .bar-2 { border-top: 3px solid #b8963e !important; }
        .bar-3 { border-top: 3px solid #2b6279 !important; }
        .bar-4 { border-top: 3px solid #1f5c46 !important; }

        /* ===== JUDUL BAGIAN ===== */
        .sec { margin: 20px 0 8px 0; }
        .sec .t { font-size: 12px; color: #164534; }
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
        table.data tfoot td {
            padding: 9px;
            background: #f7f5f0;
            border-top: 2px solid #b8963e;
            font-weight: bold;
            color: #164534;
            font-size: 9px;
        }
        .nm    { font-weight: bold; color: #1b1b1b; }
        .amt   { font-weight: bold; color: #9c7b2c; }
        .muted { color: #8a8a8a; }

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
        .b-selesai { background: #e4efe9; color: #1f5c46; }
        .b-top     { background: #f3ead2; color: #86661a; }

        /* ===== KETERANGAN ===== */
        .legend { margin-top: 12px; font-size: 7.5px; color: #6d6d6d; }
        .legend .badge { margin-right: 2px; }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            left: 0; right: 0; bottom: -38pt;
            border-top: 1px solid #e9e7e2;
            padding-top: 6px;
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
            <td>&copy; <?= date('Y') ?> YSP Jasmine &middot; Dokumen ini dicetak otomatis oleh sistem</td>
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
            <div class="brand-addr">Jl. Desa Kertosari Rt 03 Rw 02, Pemalang, Jawa Tengah</div>
            <div class="brand-addr" style="margin-top: 1px;">Telp: 0856 4769 5804 &nbsp;&middot;&nbsp; Email: yspjasmine@gmail.com</div>
        </td>
        <td class="right" style="width: 34%;">
            <div class="doc-label">Laporan</div>
            <div class="doc-title serif">Penjualan</div>
            <div class="doc-date">Dicetak: <?= $tanggal_cetak ?>, <?= date('H:i') ?> WIB</div>
        </td>
    </tr>
</table>
<div class="rule-gold"></div>
<div class="rule-green"></div>

<!-- ===== PERIODE ===== -->
<table class="periode">
    <tr>
        <td><b>Periode laporan:</b> &nbsp;<?= $periode ?></td>
    </tr>
</table>

<!-- ===== RINGKASAN ===== -->
<table class="sum">
    <tr>
        <td class="bar-1">
            <div class="lbl">Total Transaksi</div>
            <div class="num serif c-green"><?= number_format($total_transaksi, 0, ',', '.') ?></div>
            <div class="sub">pesanan pada periode ini</div>
        </td>
        <td class="bar-2">
            <div class="lbl">Total Pendapatan</div>
            <div class="num sm serif c-gold"><?= $rp($total_pendapatan) ?></div>
            <div class="sub">seluruh transaksi</div>
        </td>
        <td class="bar-3">
            <div class="lbl">Total Pelanggan</div>
            <div class="num serif c-blue"><?= number_format($total_pelanggan, 0, ',', '.') ?></div>
            <div class="sub">pelanggan terdaftar</div>
        </td>
        <td class="bar-4">
            <div class="lbl">Rata-rata Transaksi</div>
            <div class="num sm serif c-mid"><?= $rp($rata_transaksi) ?></div>
            <div class="sub"><?= number_format($rata_rata_item, 2, ',', '.') ?> item per transaksi</div>
        </td>
    </tr>
</table>

<!-- ===== DAFTAR PRODUK TERLARIS ===== -->
<div class="sec">
    <div class="t serif">Daftar Produk Terlaris</div>
    <div class="d">Diurutkan dari jumlah terjual terbanyak</div>
</div>

<table class="data">
    <thead>
        <tr>
            <th class="center" style="width: 7%;">No</th>
            <th style="width: 45%;">Nama Produk</th>
            <th class="center" style="width: 20%;">Terjual</th>
            <th class="right" style="width: 28%;">Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($produk_terlaris)): ?>
            <?php $no = 1; foreach ($produk_terlaris as $p):
                $rc = ($no % 2 === 0) ? 'alt' : '';
            ?>
            <tr class="<?= $rc ?>">
                <td class="center muted"><?= $no++ ?></td>
                <td class="nm"><?= esc($p['nama_barang']) ?></td>
                <td class="center"><span class="badge b-selesai"><?= number_format((int) $p['total_terjual'], 0, ',', '.') ?> pcs</span></td>
                <td class="right amt"><?= $rp($p['total_pendapatan']) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="center" style="padding: 28px; color: #8a8a8a;">
                    Belum ada data produk terjual pada periode ini
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
    <?php if (!empty($produk_terlaris)): ?>
    <tfoot>
        <tr>
            <td colspan="2" class="right">TOTAL</td>
            <td class="center"><?= number_format($total_unit, 0, ',', '.') ?> pcs</td>
            <td class="right"><?= $rp($total_omzet) ?></td>
        </tr>
    </tfoot>
    <?php endif; ?>
</table>

<div class="legend">
    Keterangan: data di atas menampilkan <?= number_format($jumlah_produk, 0, ',', '.') ?> produk yang terjual pada periode laporan.
    Total pendapatan pada ringkasan dihitung dari seluruh transaksi.
</div>

</body>
</html>