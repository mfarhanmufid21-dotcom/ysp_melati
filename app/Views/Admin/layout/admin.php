<?php
/**
 * Layout Admin – tema "Clean Boutique" (selaras dengan halaman pelanggan).
 * Variabel opsional dari view: $title, $subtitle, $pendingCount
 */
$title    = $title    ?? 'Dashboard';
$subtitle = $subtitle ?? '';

// Jumlah pesanan baru (status Pending) untuk lencana di menu
if (!isset($pendingCount)) {
    $pendingCount = 0;
    try {
        $pendingCount = (int) \Config\Database::connect()
            ->table('transaksi')->where('status', 'Pending')->countAllResults();
    } catch (\Throwable $e) {
        $pendingCount = 0;
    }
}

$uri   = trim(uri_string(), '/');
$aktif = static function (string $path, bool $exact = false) use ($uri): string {
    if ($path === 'admin') {
        return ($uri === '' || $uri === 'admin' || $uri === 'admin/dashboard') ? 'on' : '';
    }
    if ($exact) {
        return $uri === $path ? 'on' : '';
    }
    return ($uri === $path || strpos($uri, $path . '/') === 0) ? 'on' : '';
};

$namaAdmin = session()->get('nama') ?? 'Administrator';
$inisial   = strtoupper(mb_substr($namaAdmin, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?> | Admin YSP Jasmine</title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=1') ?>">

    <!-- Font yang sama dengan halaman pelanggan -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Tema admin (token warna sama dengan mf-theme.css) -->
    <link href="<?= base_url('assets/css/mf-admin.css') ?>?v=2" rel="stylesheet">
</head>
<body class="mf-admin">

<div class="mf-app">

    <!-- ===================== SIDEBAR ===================== -->
    <aside class="mf-side" id="mfSide" aria-label="Menu admin">
        <div class="mf-side-head">
            <a class="mf-brand" href="<?= base_url('admin') ?>">
                <b>YSP Jasmine</b>
                <small>Panel Admin</small>
            </a>
            <a class="mf-brand-mini" href="<?= base_url('admin') ?>" aria-label="YSP Jasmine">Y</a>
            <button type="button" class="mf-collapse" id="mfCollapse" aria-label="Kecilkan atau besarkan menu" title="Kecilkan menu">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        <nav class="mf-side-scroll">
            <div class="mf-group">
                <div class="mf-group-title">Ringkasan</div>
                <a class="mf-link <?= $aktif('admin') ?>" href="<?= base_url('admin') ?>" title="Dashboard">
                    <i class="fas fa-house"></i><span class="lbl">Dashboard</span>
                </a>
            </div>

            <div class="mf-group">
                <div class="mf-group-title">Kelola Toko</div>
                <a class="mf-link <?= $aktif('admin/transaksi') ?>" href="<?= base_url('admin/transaksi') ?>" title="Pesanan &amp; Transaksi">
                    <i class="fas fa-bag-shopping"></i><span class="lbl">Pesanan &amp; Transaksi</span>
                    <?php if ($pendingCount > 0): ?>
                        <span class="mf-pill warn" title="<?= $pendingCount ?> pesanan baru menunggu"><?= $pendingCount ?></span>
                    <?php endif; ?>
                </a>
                <a class="mf-link <?= $aktif('admin/barang') ?>" href="<?= base_url('admin/barang') ?>" title="Data Barang">
                    <i class="fas fa-box-open"></i><span class="lbl">Data Barang</span>
                </a>
                <a class="mf-link <?= $aktif('admin/pelanggan') ?>" href="<?= base_url('admin/pelanggan') ?>" title="Data Pelanggan">
                    <i class="fas fa-user-group"></i><span class="lbl">Data Pelanggan</span>
                </a>
                <a class="mf-link <?= $aktif('admin/ulasan') ?>" href="<?= base_url('admin/ulasan') ?>" title="Ulasan Pelanggan">
                    <i class="fas fa-star"></i><span class="lbl">Ulasan Pelanggan</span>
                </a>
            </div>

            <div class="mf-group">
                <div class="mf-group-title">Laporan</div>
                <a class="mf-link <?= $aktif('admin/laporan', true) ?>" href="<?= base_url('admin/laporan') ?>" title="Ringkasan Laporan">
                    <i class="fas fa-chart-line"></i><span class="lbl">Ringkasan Laporan</span>
                </a>
                <a class="mf-link <?= $aktif('admin/laporan/transaksi') ?>" href="<?= base_url('admin/laporan/transaksi') ?>" title="Laporan Transaksi">
                    <i class="fas fa-file-invoice"></i><span class="lbl">Laporan Transaksi</span>
                </a>
                <a class="mf-link <?= $aktif('admin/laporan/barang') ?>" href="<?= base_url('admin/laporan/barang') ?>" title="Laporan Stok">
                    <i class="fas fa-boxes-stacked"></i><span class="lbl">Laporan Stok</span>
                </a>
            </div>
        </nav>

        <div class="mf-side-foot">
            <a class="mf-link" href="<?= base_url('/') ?>" target="_blank" rel="noopener" title="Lihat Toko">
                <i class="fas fa-arrow-up-right-from-square"></i><span class="lbl">Lihat Toko</span>
            </a>
            <a class="mf-link danger" href="#" data-bs-toggle="modal" data-bs-target="#mfLogout" title="Keluar">
                <i class="fas fa-right-from-bracket"></i><span class="lbl">Keluar</span>
            </a>
        </div>
    </aside>

    <!-- ===================== KONTEN ===================== -->
    <div class="mf-main" id="mfMain">

        <header class="mf-top">
            <div class="mf-top-l">
                <button type="button" class="mf-burger" id="mfBurger" aria-label="Buka menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="mf-crumb">
                    <small><a href="<?= base_url('admin') ?>">Admin</a> &nbsp;/&nbsp; <?= esc($subtitle !== '' ? $subtitle : $title) ?></small>
                    <h1><?= esc($title) ?></h1>
                </div>
            </div>

            <div class="mf-top-r">
                <a class="mf-shop-btn" href="<?= base_url('/') ?>" target="_blank" rel="noopener">
                    <i class="fas fa-store"></i><span>Lihat Toko</span>
                </a>

                <div class="dropdown mf-user">
                    <button type="button" class="mf-user-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="mf-avatar"><?= esc($inisial) ?></span>
                        <span class="mf-user-info">
                            <b><?= esc($namaAdmin) ?></b>
                            <span>Administrator</span>
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end mf-menu">
                        <li class="who"><strong><?= esc($namaAdmin) ?></strong>Administrator</li>
                        <li><a class="dropdown-item" href="<?= base_url('/') ?>" target="_blank" rel="noopener"><i class="fas fa-store"></i> Lihat Toko</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item danger" href="#" data-bs-toggle="modal" data-bs-target="#mfLogout"><i class="fas fa-right-from-bracket"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="mf-content">
            <?= $this->renderSection('content') ?>
        </main>

        <footer class="mf-foot">
            <span><b>YSP Jasmine</b> &nbsp;&copy; <?= date('Y') ?> &middot; Panel Admin</span>
            <span>
                <a href="<?= base_url('admin/transaksi') ?>">Pesanan</a>
                <a href="<?= base_url('admin/barang') ?>">Barang</a>
                <a href="<?= base_url('admin/laporan') ?>">Laporan</a>
            </span>
        </footer>
    </div>
</div>

<div class="mf-overlay" id="mfOverlay"></div>

<!-- Konfirmasi keluar -->
<div class="modal fade" id="mfLogout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Keluar dari admin?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" style="color:var(--mf-muted);font-size:.92rem">
                Anda harus masuk lagi untuk membuka panel admin.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('logout') ?>" class="btn btn-primary">Ya, keluar</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';
    var side = document.getElementById('mfSide');
    var overlay = document.getElementById('mfOverlay');
    var KEY = 'mfAdminSideMini';

    function safeGet(k){ try { return localStorage.getItem(k); } catch(e){ return null; } }
    function safeSet(k,v){ try { localStorage.setItem(k,v); } catch(e){} }

    // Ingat pilihan menu kecil/besar (desktop)
    if (window.innerWidth > 820 && safeGet(KEY) === '1') side.classList.add('mini');

    document.getElementById('mfCollapse').addEventListener('click', function () {
        var mini = side.classList.toggle('mini');
        safeSet(KEY, mini ? '1' : '0');
    });

    // Menu geser di HP
    function openSide(){ side.classList.add('open'); overlay.classList.add('on'); document.body.style.overflow = 'hidden'; }
    function closeSide(){ side.classList.remove('open'); overlay.classList.remove('on'); document.body.style.overflow = ''; }
    document.getElementById('mfBurger').addEventListener('click', openSide);
    overlay.addEventListener('click', closeSide);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeSide(); });
    side.querySelectorAll('a.mf-link[href]:not([data-bs-toggle])').forEach(function (a) {
        a.addEventListener('click', closeSide);
    });
    window.addEventListener('resize', function () { if (window.innerWidth > 820) closeSide(); });
});
</script>
</body>
</html>
