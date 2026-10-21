<?php
/**
 * Header bersama bergaya "boutique" (topbar + logo tengah + menu + drawer mobile + pencarian)
 * Variabel opsional:
 *   $mfActive       : 'home' | 'best-seller' | 'produk' | 'tentang' | 'cara-pesan' | 'testimoni' | 'kontak' | '' (menandai menu aktif)
 *   $mfProfileModal : true bila halaman memuat modal #editProfileModalNavbar
 */
$mfActive       = $mfActive ?? '';
$mfProfileModal = $mfProfileModal ?? false;

$mfLoggedIn = (session()->get('pelanggan_id') !== null) || session()->get('id_user') || session()->get('logged_in') == true;
$mfName     = session()->get('nama') ?: (session()->get('username') ?: 'Akun');

$mfCartCount = 0;
$mfCart = session()->get('cart');
if ($mfCart && is_array($mfCart)) {
    foreach ($mfCart as $mfItem) { $mfCartCount += (int) ($mfItem['qty'] ?? 0); }
}

$mfHome = base_url();

/* Format: [label, url, kunci_aktif, grup_submenu(opsional)]
   grup_submenu: ['Judul Grup' => [[label, url], ...], ...] -> tampil sebagai dropdown 2 tingkat */
$mfShop = base_url('shop');
$mfMenu = [
    ['Beranda',       $mfHome,                       'home'],
    ['Best Seller',   base_url('best-seller'),       'best-seller', [
        'Terlaris' => [
            ['Semua Best Seller',        base_url('best-seller')],
            ['Melati Segar Terlaris',    $mfShop . '?stock=tersedia&sort=popular'],
            ['Roncean & Pengantin',      $mfShop . '?stock=po&sort=popular'],
        ],
        'Melati Segar' => [
            ['Melati Segar',             $mfShop . '?search=' . rawurlencode('Melati Segar')],
            ['Melati Karuk',             $mfShop . '?search=Karuk'],
            ['Melati Putih Polos',       $mfShop . '?search=' . rawurlencode('Putih Polos')],
            ['Melati Curah',             $mfShop . '?search=Curah'],
        ],
        'Roncean & Set' => [
            ['Ronce Melati',             $mfShop . '?search=ronce'],
            ['Gelang Ronce',             $mfShop . '?search=gelang'],
            ['Set Pengantin Jawa',       $mfShop . '?search=Jawa'],
            ['Set Pengantin Sunda',      $mfShop . '?search=Sunda'],
        ],
    ]],
    ['Semua Produk',  $mfShop,                       'produk', [
        'Status' => [
            ['Semua Produk',             $mfShop],
            ['Tersedia (Melati Segar)',  $mfShop . '?stock=tersedia'],
            ['Pre-Order (Roncean)',      $mfShop . '?stock=po'],
        ],
        'Jenis Produk' => [
            ['Melati Segar',             $mfShop . '?stock=tersedia'],
            ['Ronce Melati',             $mfShop . '?search=ronce'],
            ['Gelang Ronce',             $mfShop . '?search=gelang'],
            ['Set Pengantin',            $mfShop . '?search=set'],
        ],
        'Urutkan' => [
            ['Terbaru',                  $mfShop . '?sort=newest'],
            ['Terlaris',                 $mfShop . '?sort=popular'],
            ['Harga: Rendah ke Tinggi',  $mfShop . '?sort=price_asc'],
            ['Harga: Tinggi ke Rendah',  $mfShop . '?sort=price_desc'],
        ],
    ]],
    ['Tentang Kami',  base_url('tentang-kami'),      'tentang'],
    ['Cara Pesan',    base_url('cara-pesan'),        'cara-pesan'],
    ['Testimoni',     base_url('testimoni'),         'testimoni'],
    ['Kontak',        base_url('kontak'),            'kontak'],
];
?>
<link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">

<div class="mf-topbar">
    <span class="mf-hide-sm">Gratis konsultasi pesanan via WhatsApp &nbsp;·&nbsp; </span>Buka setiap hari 08.00–17.00
    <a href="https://wa.me/6285647695804?text=Halo%20YSP%20Jasmine,%20saya%20ingin%20tanya%20produk" target="_blank" rel="noopener">Chat sekarang</a>
</div>

<header class="mf-header" id="mainNav">
    <div class="mf-header-main">
        <div class="mf-left">
            <button class="mf-icon-btn mf-burger" type="button" aria-label="Buka menu" data-mf-open-drawer><i class="fas fa-bars"></i></button>
            <button class="mf-icon-btn" type="button" aria-label="Cari produk" data-mf-open-search><i class="fas fa-search"></i></button>
        </div>

        <a class="mf-logo" href="<?= $mfHome ?>" aria-label="YSP Jasmine - Beranda">
            YSP Jasmine
            <small>Pure Elegance</small>
        </a>

        <div class="mf-right">
            <?php if ($mfLoggedIn): ?>
                <div class="mf-dd" id="mfAccount">
                    <button class="mf-icon-btn" type="button" aria-label="Akun saya" aria-expanded="false" data-mf-dd><i class="far fa-user"></i></button>
                    <div class="mf-dd-menu">
                        <div class="who">Halo,<strong><?= esc($mfName) ?></strong></div>
                        <a href="<?= base_url('user/dashboard') ?>"><i class="fas fa-th-large"></i> Dashboard</a>
                        <?php if ($mfProfileModal): ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editProfileModalNavbar"><i class="far fa-id-card"></i> Edit Profil</a>
                        <?php endif; ?>
                        <a href="<?= base_url('shop/riwayat') ?>"><i class="fas fa-receipt"></i> Riwayat Pesanan</a>
                        <a href="<?= base_url('shop/cart') ?>"><i class="fas fa-shopping-bag"></i> Keranjang</a>
                        <a href="<?= base_url('logout') ?>" class="danger" onclick="return confirm('Yakin ingin logout?')"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="mf-login-link">Masuk</a>
                <a href="<?= base_url('login') ?>" class="mf-icon-btn" aria-label="Masuk" style="display:none" id="mfLoginIcon"><i class="far fa-user"></i></a>
            <?php endif; ?>

            <a href="<?= base_url('shop/cart') ?>" class="mf-icon-btn" aria-label="Keranjang belanja">
                <i class="fas fa-shopping-bag"></i>
                <span class="mf-cart-count cart-count<?= $mfCartCount > 0 ? ' show has' : '' ?>"><?= $mfCartCount ?></span>
            </a>
        </div>
    </div>

    <nav class="mf-nav" aria-label="Menu utama">
        <?php foreach ($mfMenu as $m):
            $isActive = ($m[2] !== '' && $m[2] === $mfActive);
            $groups   = $m[3] ?? []; ?>
            <div class="mf-nav-item<?= $groups ? ' has-mega' : '' ?>">
                <a href="<?= $m[1] ?>" class="<?= $isActive ? 'active' : '' ?>"><?= $m[0] ?></a>
                <?php if ($groups): ?>
                    <div class="mf-mega">
                        <ul class="mf-mega-l1">
                            <?php foreach ($groups as $gTitle => $links): ?>
                                <li>
                                    <span class="mf-mega-t" tabindex="0"><?= esc($gTitle) ?> <i class="fas fa-angle-right"></i></span>
                                    <ul class="mf-mega-l2">
                                        <?php foreach ($links as $l): ?>
                                            <li><a href="<?= $l[1] ?>"><?= esc($l[0]) ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </nav>
</header>

<!-- Pencarian -->
<div class="mf-search" id="mfSearch" role="dialog" aria-label="Pencarian produk">
    <button class="mf-close" type="button" aria-label="Tutup" data-mf-close-search>&times;</button>
    <form action="<?= base_url('shop') ?>" method="get">
        <input type="text" name="search" placeholder="Cari produk melati…" autocomplete="off" id="mfSearchInput">
        <button type="submit" aria-label="Cari"><i class="fas fa-search"></i></button>
        <p>Contoh: roncean, gelang, melati segar</p>
    </form>
</div>

<!-- Menu mobile -->
<div class="mf-drawer-bg" data-mf-close-drawer></div>
<aside class="mf-drawer" aria-label="Menu">
    <div class="mf-drawer-head">
        <span class="mf-logo" style="font-size:1.4rem">YSP Jasmine</span>
        <button class="mf-icon-btn" type="button" aria-label="Tutup menu" data-mf-close-drawer><i class="fas fa-times"></i></button>
    </div>
    <?php foreach ($mfMenu as $m):
        $isActive = ($m[2] !== '' && $m[2] === $mfActive);
        $groups   = $m[3] ?? []; ?>
        <?php if ($groups): ?>
            <div class="mf-acc">
                <div class="row">
                    <a class="item<?= $isActive ? ' active' : '' ?>" href="<?= $m[1] ?>"><?= $m[0] ?></a>
                    <button type="button" class="tg" aria-label="Buka pilihan <?= esc($m[0]) ?>" aria-expanded="false"><i class="fas fa-plus"></i></button>
                </div>
                <div class="panel">
                    <?php foreach ($groups as $gTitle => $links): ?>
                        <div class="gt"><?= esc($gTitle) ?></div>
                        <?php foreach ($links as $l): ?>
                            <a href="<?= $l[1] ?>"><?= esc($l[0]) ?></a>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <a class="item<?= $isActive ? ' active' : '' ?>" href="<?= $m[1] ?>"><?= $m[0] ?> <i class="fas fa-angle-right" style="color:#aaa"></i></a>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="sub">
        <?php if ($mfLoggedIn): ?>
            <a class="mf-btn block" href="<?= base_url('user/dashboard') ?>">Akun Saya</a>
            <a class="mf-btn block" href="<?= base_url('shop/riwayat') ?>">Riwayat Pesanan</a>
        <?php else: ?>
            <a class="mf-btn solid block" href="<?= base_url('login') ?>">Masuk</a>
            <a class="mf-btn block" href="<?= base_url('register') ?>">Daftar Gratis</a>
        <?php endif; ?>
    </div>
</aside>

<script>
(function () {
    var b = document.body;
    b.classList.add('mf-body');
    var $ = function (s, r) { return (r || document).querySelector(s); };
    var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

    $$('[data-mf-open-drawer]').forEach(function (e) { e.addEventListener('click', function () { b.classList.add('mf-drawer-open'); }); });
    $$('[data-mf-close-drawer]').forEach(function (e) { e.addEventListener('click', function () { b.classList.remove('mf-drawer-open'); }); });
    $$('.mf-drawer a.item').forEach(function (e) { e.addEventListener('click', function () { b.classList.remove('mf-drawer-open'); }); });

    $$('.mf-acc .tg').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var acc = btn.closest('.mf-acc');
            var open = acc.classList.toggle('open');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            btn.querySelector('i').className = open ? 'fas fa-minus' : 'fas fa-plus';
        });
    });
    $$('.mf-acc .panel a').forEach(function (e) { e.addEventListener('click', function () { b.classList.remove('mf-drawer-open'); }); });

    var s = $('#mfSearch');
    $$('[data-mf-open-search]').forEach(function (e) { e.addEventListener('click', function () { s.classList.add('open'); setTimeout(function () { $('#mfSearchInput').focus(); }, 50); }); });
    $$('[data-mf-close-search]').forEach(function (e) { e.addEventListener('click', function () { s.classList.remove('open'); }); });
    document.addEventListener('keydown', function (ev) { if (ev.key === 'Escape') { s.classList.remove('open'); b.classList.remove('mf-drawer-open'); } });

    var dd = $('#mfAccount');
    if (dd) {
        $('[data-mf-dd]', dd).addEventListener('click', function (ev) { ev.stopPropagation(); dd.classList.toggle('open'); });
        document.addEventListener('click', function (ev) { if (!dd.contains(ev.target)) dd.classList.remove('open'); });
    }


    // Sinkronkan tampilan badge keranjang dengan isinya (kompatibel dengan JS lama di tiap halaman)
    $$('.mf-cart-count').forEach(function (el) {
        var sync = function () {
            var n = parseInt(el.textContent, 10) || 0;
            el.classList.toggle('show', n > 0);
            el.classList.toggle('has', n > 0);
        };
        sync();
        new MutationObserver(sync).observe(el, { childList: true, characterData: true, subtree: true });
    });

    // Di HP: tampilkan ikon akun alih-alih tulisan "Masuk"
    var li = $('#mfLoginIcon');
    if (li && window.matchMedia('(max-width: 991px)').matches) li.style.display = 'inline-flex';
})();
</script>
