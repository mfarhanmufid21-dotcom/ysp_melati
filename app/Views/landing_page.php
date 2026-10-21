<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YSP Jasmine – Toko Bunga Melati Premium Online | Best Seller</title>
    
    <!-- ========== SEO META TAGS ========== -->
    <meta name="description" content="Toko bunga melati online YSP Jasmine menyediakan rangkaian melati segar berkualitas premium. Best seller produk melati untuk wedding, souvenir, dan acara spesial. Belanja mudah, pengiriman cepat.">
    <meta name="keywords" content="toko bunga melati, bunga melati online, rangkaian melati, YSP Jasmine, bunga segar, bunga wedding, souvenir pernikahan, melati premium, best seller bunga">
    <meta name="author" content="YSP Jasmine">
    <meta name="robots" content="index, follow">
    <meta name="language" content="id">
    <meta name="revisit-after" content="3 days">
    <meta name="geo.placename" content="Pemalang, Jawa Tengah, Indonesia">
    <meta name="geo.region" content="ID-JT">
    
    <!-- ========== OPEN GRAPH ========== -->
    <meta property="og:title" content="YSP Jasmine - Toko Bunga Melati Online Premium & Best Seller">
    <meta property="og:description" content="Toko bunga melati online dengan kualitas premium. Best seller produk melati segar untuk berbagai acara. Fresh dari kebun langsung ke tangan Anda.">
    <meta property="og:image" content="<?= base_url('uploads/gambar2.png') ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="<?= base_url() ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="YSP Jasmine">
    <meta property="og:locale" content="id_ID">
    
    <!-- ========== TWITTER CARD ========== -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="YSP Jasmine - Toko Bunga Melati Online Premium">
    <meta name="twitter:description" content="Toko bunga melati online dengan kualitas premium. Best seller produk melati segar.">
    <meta name="twitter:image" content="<?= base_url('uploads/gambar2.png') ?>">
    
    <!-- ========== SCHEMA MARKUP ========== -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "YSP Jasmine",
        "image": "<?= base_url('uploads/gambar2.png') ?>",
        "description": "Toko bunga melati online premium menyediakan rangkaian melati segar berkualitas untuk berbagai acara.",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Jl. Desa Kertosari Rt 03 Rw 02",
            "addressLocality": "Pemalang",
            "addressRegion": "Jawa Tengah",
            "postalCode": "52314",
            "addressCountry": "ID"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "-6.8457286",
            "longitude": "109.5604386"
        },
        "url": "<?= base_url() ?>",
        "telephone": "+6285647695804",
        "priceRange": "Rp 50.000 - Rp 500.000",
        "openingHours": "Mo-Su 08:00-17:00",
        "sameAs": [
            "https://www.instagram.com/yspjasmine_pekalongan/",
            "https://wa.me/6285647695804"
        ]
    }
    </script>
    
    <!-- ========== CANONICAL & FAVICON ========== -->
    <link rel="canonical" href="<?= base_url() ?>">
    <link rel="icon" type="image/png" href="<?= base_url('favicon.ico') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">
</head>
<body class="mf-body">

<?= view('layout/mf_header', ['mfActive' => 'home']) ?>

<?php
/* ------------------------------------------------------------------
   Data produk: Best Seller (terjual / rating tertinggi) & Produk Unggulan
   ------------------------------------------------------------------ */
$produk = $produk ?? [];

$bestSellerProducts = [];
if (!empty($produk)) {
    $sorted = $produk;
    usort($sorted, function ($a, $b) {
        $sa = (int) ($a['terjual'] ?? 0);
        $sb = (int) ($b['terjual'] ?? 0);
        if ($sa !== $sb) return $sb <=> $sa;
        return ((float) ($b['rating'] ?? 0)) <=> ((float) ($a['rating'] ?? 0));
    });
    $bestSellerProducts = array_slice($sorted, 0, 4);
}

$unggulanProducts = [];
if (!empty($produk)) {
    $bestIds = array_column($bestSellerProducts, 'id');
    $rest = array_values(array_filter($produk, function ($p) use ($bestIds) {
        return !in_array($p['id'], $bestIds);
    }));
    usort($rest, function ($a, $b) {
        if ($a['stok'] <= 0 && $b['stok'] > 0) return 1;
        if ($a['stok'] > 0 && $b['stok'] <= 0) return -1;
        return ((int) ($b['id'] ?? 0)) <=> ((int) ($a['id'] ?? 0));
    });
    $unggulanProducts = array_slice($rest, 0, 4);
    if (count($unggulanProducts) < 4) {
        $unggulanProducts = array_merge($unggulanProducts, array_slice($bestSellerProducts, 0, 4 - count($unggulanProducts)));
    }
}

$isLoggedCustomer = session()->get('pelanggan_id') !== null;

/* Kartu produk (dipakai ulang di dua section) */
$renderCard = function (array $p, string $label = '') use ($isLoggedCustomer) {
    $stok   = (int) ($p['stok'] ?? 0);
    $promo  = !empty($p['is_promo']) && ($p['harga_diskon'] ?? 0) > 0;
    $img    = (!empty($p['gambar']) && file_exists(FCPATH . 'uploads/' . $p['gambar'])) ? base_url('uploads/' . $p['gambar']) : null;
    $detail = base_url('shop/detail/' . $p['id']);
    ob_start(); ?>
    <article class="mf-card mf-reveal">
        <a class="mf-card-img" href="<?= $detail ?>" aria-label="Lihat <?= esc($p['nama_barang']) ?>">
            <?php if ($img): ?>
                <img src="<?= $img ?>" alt="<?= esc($p['nama_barang']) ?> – Bunga Melati YSP Jasmine" loading="lazy">
            <?php else: ?>
                <div class="ph">🌸</div>
            <?php endif; ?>
            <div class="mf-badges">
                <?php if ($label): ?><span class="mf-badge best"><?= esc($label) ?></span><?php endif; ?>
                <?php if ($promo): ?><span class="mf-badge sale">-<?= round((($p['harga'] - $p['harga_diskon']) / $p['harga']) * 100) ?>%</span><?php endif; ?>
                <?php if ($stok <= 0): ?><span class="mf-badge out">Habis</span>
                <?php elseif ($stok <= 5): ?><span class="mf-badge low">Sisa <?= $stok ?></span><?php endif; ?>
            </div>
        </a>
        <div class="mf-card-body">
            <h3 class="mf-card-name"><a href="<?= $detail ?>"><?= esc($p['nama_barang']) ?></a></h3>
            <?php if (!empty($p['rating']) && $p['rating'] > 0): ?>
                <div class="mf-rate"><i class="fas fa-star"></i> <?= number_format($p['rating'], 1) ?></div>
            <?php endif; ?>
            <div class="mf-price">
                <?php if ($promo): ?>
                    <s>Rp <?= number_format($p['harga'], 0, ',', '.') ?></s><em>Rp <?= number_format($p['harga_diskon'], 0, ',', '.') ?></em>
                <?php else: ?>
                    Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($p['terjual'])): ?><div class="mf-meta"><?= (int) $p['terjual'] ?> terjual</div><?php endif; ?>

            <div class="mf-card-actions">
                <?php if ($isLoggedCustomer): ?>
                    <?php if ($stok > 0): ?>
                        <form action="<?= base_url('shop/addToCart/' . $p['id']) ?>" method="post" class="add-to-cart-form">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="mf-btn"><i class="fas fa-shopping-bag"></i> Tambah ke Keranjang</button>
                        </form>
                    <?php else: ?>
                        <button class="mf-btn" disabled>Stok Habis</button>
                    <?php endif; ?>
                <?php else: ?>
                    <button type="button" class="mf-btn" onclick="showAuthAlert()"><i class="fas fa-lock"></i> Login untuk Beli</button>
                <?php endif; ?>
            </div>
        </div>
    </article>
    <?php return ob_get_clean();
};
?>

<main id="main">

<!-- ================= HERO SLIDER ================= -->
<section class="mf-hero" id="hero" aria-label="Banner utama">
    <div class="mf-slides" id="mfSlides">
        <div class="mf-slide">
            <img src="<?= base_url('uploads/gambar1.png') ?>" alt="YSP Jasmine – Pure Elegance, Exquisite Blooms">
            <a class="mf-slide-link" href="<?= base_url('shop') ?>" aria-label="Lihat koleksi"></a>
        </div>
        <div class="mf-slide">
            <img src="<?= base_url('uploads/gambar2.png') ?>" alt="Rangkaian melati pengantin YSP Jasmine" loading="lazy">
            <div class="mf-slide-cap dark">
                <h2>Rangkaian Melati Pengantin</h2>
                <p>Roncean, gelang, dan set lengkap untuk hari bahagia Anda.</p>
                <a class="mf-btn solid" href="<?= base_url('shop?stock=po') ?>">Lihat Koleksi</a>
            </div>
        </div>
        <div class="mf-slide">
            <img src="<?= base_url('uploads/melati1.png') ?>" alt="Melati segar pilihan YSP Jasmine" loading="lazy">
            <div class="mf-slide-cap">
                <h2>Melati Segar Setiap Hari</h2>
                <p>Dipetik dari kebun pilihan, dikemas rapi sampai ke tangan Anda.</p>
                <a class="mf-btn light" href="<?= base_url('shop?stock=tersedia') ?>">Belanja Sekarang</a>
            </div>
        </div>
    </div>
    <button class="mf-arrow prev" type="button" aria-label="Sebelumnya"><i class="fas fa-chevron-left"></i></button>
    <button class="mf-arrow next" type="button" aria-label="Berikutnya"><i class="fas fa-chevron-right"></i></button>
    <div class="mf-dots" id="mfDots"></div>
</section>

<!-- ================= KEUNGGULAN RINGKAS ================= -->
<section class="mf-trust" aria-label="Keunggulan">
    <div class="mf-wrap">
        <div class="mf-trust-item"><i class="fas fa-leaf"></i><div><b>100% Melati Asli</b><span>Segar, tanpa bahan kimia</span></div></div>
        <div class="mf-trust-item"><i class="fas fa-truck-fast"></i><div><b>Pengiriman Cepat</b><span>Area terdekat hari yang sama</span></div></div>
        <div class="mf-trust-item"><i class="fas fa-hand-holding-heart"></i><div><b>Harga Terjangkau</b><span>Langsung dari kebun</span></div></div>
        <div class="mf-trust-item"><i class="fab fa-whatsapp"></i><div><b>Bantuan via WhatsApp</b><span>Respon cepat setiap hari</span></div></div>
    </div>
</section>

<!-- ================= BEST SELLER ================= -->
<section class="mf-section" id="best-seller">
    <div class="mf-wrap">
        <div class="mf-sec-head mf-reveal">
            <h2>Best Seller</h2>
            <p>Pilihan favorit pelanggan kami.</p>
        </div>
        <?php if (!empty($bestSellerProducts)): ?>
            <div class="mf-grid">
                <?php foreach ($bestSellerProducts as $i => $p): ?>
                    <?= $renderCard($p, 'Terlaris #' . ($i + 1)) ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mf-empty"><i class="fas fa-seedling"></i><p>Produk akan segera hadir.</p></div>
        <?php endif; ?>
        <div class="mf-sec-foot"><a href="<?= base_url('shop') ?>" class="mf-btn">Lihat semua produk</a></div>
    </div>
</section>

<!-- ================= PRODUK UNGGULAN ================= -->
<section class="mf-section" id="produk">
    <div class="mf-wrap">
        <div class="mf-sec-head mf-reveal">
            <h2>Produk Unggulan</h2>
            <p>Koleksi melati terbaru dan siap dipesan.</p>
        </div>
        <?php if (!empty($unggulanProducts)): ?>
            <div class="mf-grid">
                <?php foreach ($unggulanProducts as $p): ?>
                    <?= $renderCard($p) ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mf-empty"><i class="fas fa-seedling"></i><p>Belum ada produk.</p></div>
        <?php endif; ?>
        <div class="mf-sec-foot"><a href="<?= base_url('shop') ?>" class="mf-btn solid">Jelajahi katalog</a></div>
    </div>
</section>

<!-- ================= TENTANG ================= -->
<section class="mf-section" id="tentang">
    <div class="mf-wrap">
        <div class="mf-about">
            <img src="<?= base_url('uploads/melati1.png') ?>" alt="Melati segar YSP Jasmine" loading="lazy">
            <div class="mf-reveal">
                <span class="mf-eyebrow">Cerita Kami</span>
                <h2>Lebih dari Sekadar Bunga Melati</h2>
                <p><b>YSP Jasmine</b> lahir dari kecintaan pada keindahan dan aroma melati nusantara. Sejak 2001, kami menghadirkan produk melati berkualitas yang dipilih langsung dari kebun terpercaya untuk setiap momen istimewa Anda.</p>
                <p>Dari roncean hingga melati segar, setiap produk dikemas dengan standar premium dan dikirim dengan penuh perhatian. Kami juga mendukung petani melati lokal dengan harga yang adil.</p>
                <a href="<?= base_url('shop') ?>" class="mf-btn" style="margin-top:10px">Belanja sekarang</a>
            </div>
        </div>
    </div>
</section>

<!-- ================= CARA PEMESANAN ================= -->
<section class="mf-section soft" id="pemesanan">
    <div class="mf-wrap">
        <div class="mf-sec-head mf-reveal">
            <h2>Cara Pemesanan</h2>
            <p>Mudah dan cepat, hanya 4 langkah.</p>
        </div>
        <div class="mf-steps">
            <?php
            $steps = [
                ['Buat Akun',          'Daftar gratis, hanya butuh beberapa menit.'],
                ['Pilih Produk',       'Jelajahi koleksi melati dan pilih yang Anda suka.'],
                ['Tambah Keranjang',   'Masukkan ke keranjang lalu lengkapi data pengiriman.'],
                ['Bayar & Konfirmasi', 'Bayar lalu pilih ambil di tempat atau kirim ke alamat Anda.'],
            ];
            foreach ($steps as $i => $s): ?>
                <div class="mf-step mf-reveal">
                    <div class="n"><?= $i + 1 ?></div>
                    <h3><?= $s[0] ?></h3>
                    <p><?= $s[1] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (!$isLoggedCustomer): ?>
            <div class="mf-sec-foot"><a href="<?= base_url('register') ?>" class="mf-btn solid">Daftar gratis</a></div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= TESTIMONI ================= -->
<section class="mf-section" id="testimoni">
    <div class="mf-wrap">
        <div class="mf-sec-head mf-reveal">
            <h2>Kata Pelanggan</h2>
            <p>Ulasan nyata dari pembeli YSP Jasmine.</p>
        </div>
        <?php if (!empty($testimoni)): ?>
            <div class="mf-testi">
                <?php foreach ($testimoni as $t): ?>
                    <div class="mf-testi-card mf-reveal">
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?><i class="<?= $i <= ($t['rating'] ?? 5) ? 'fas' : 'far' ?> fa-star"></i><?php endfor; ?>
                        </div>
                        <q><?= esc($t['komentar']) ?></q>
                        <?php if (!empty($t['foto_ulasan']) && file_exists(FCPATH . 'uploads/ulasan/' . $t['foto_ulasan'])): ?>
                            <img src="<?= base_url('uploads/ulasan/' . $t['foto_ulasan']) ?>" alt="Foto ulasan <?= esc($t['nama_pelanggan'] ?? 'pelanggan') ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="who">
                            <span><b><?= esc($t['nama_pelanggan'] ?? $t['username'] ?? 'Pelanggan') ?></b><br><?= esc($t['nama_barang'] ?? 'Produk') ?></span>
                            <span><?= date('d M Y', strtotime($t['tanggal_ulasan'] ?? $t['created_at'] ?? 'now')) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mf-empty"><i class="far fa-comment-dots"></i><p>Belum ada testimoni. Jadilah yang pertama!</p><a href="<?= base_url('shop') ?>" class="mf-btn">Belanja Sekarang</a></div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= KONTAK ================= -->
<section class="mf-section soft" id="kontak">
    <div class="mf-wrap">
        <div class="mf-contact">
            <div class="mf-reveal">
                <h2>Temui Kami</h2>
                <dl>
                    <dt>Alamat</dt><dd>Jl. Desa Kertosari Rt 03 Rw 02, Pemalang, Jawa Tengah</dd>
                    <dt>WhatsApp</dt><dd>+62 856-4769-5804</dd>
                    <dt>Email</dt><dd>hello@yspjasmine.com</dd>
                    <dt>Jam Buka</dt><dd>Setiap hari, 08.00–17.00</dd>
                </dl>
                <div style="display:flex;flex-wrap:wrap;gap:10px">
                    <a class="mf-btn solid" target="_blank" rel="noopener" href="https://wa.me/6285647695804?text=Halo%20YSP%20Jasmine,%20saya%20ingin%20tanya%20stok%20bunga"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                    <a class="mf-btn" target="_blank" rel="noopener" href="https://maps.app.goo.gl/8UHdn7Evo1Zi1rwo6"><i class="fas fa-directions"></i> Petunjuk Arah</a>
                </div>
            </div>
            <div class="mf-map mf-reveal">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1198.3879134162535!2d109.56043863239978!3d-6.845728596932963!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fd79cd8c511af%3A0x541755363a758dbe!2sYSP%20Jasmine!5e0!3m2!1sid!2sid!4v1782621586379!5m2!1sid!2sid" allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin" title="Peta lokasi YSP Jasmine, Pemalang"></iframe>
            </div>
        </div>
    </div>
</section>

</main>

<?= view('layout/mf_footer') ?>

<!-- Toast -->
<div class="mf-toast" id="authToast"><i class="fas fa-lock"></i> Silakan <a href="<?= base_url('login') ?>">login</a> atau <a href="<?= base_url('register') ?>">daftar</a> dulu untuk berbelanja.</div>
<div class="mf-toast" id="successToast"><i class="fas fa-check-circle"></i> Produk ditambahkan ke keranjang. <a href="<?= base_url('shop/cart') ?>">Lihat keranjang</a></div>

<script>
// ===== Toast =====
function showAuthAlert() {
    var t = document.getElementById('authToast');
    t.classList.add('show'); setTimeout(function () { t.classList.remove('show'); }, 4000);
}
function showSuccessToast() {
    var t = document.getElementById('successToast');
    t.classList.add('show'); setTimeout(function () { t.classList.remove('show'); }, 3500);
}

// ===== Jumlah keranjang =====
function updateCartCount(count) {
    document.querySelectorAll('.cart-count').forEach(function (el) {
        el.textContent = count > 0 ? count : '0';
        el.classList.toggle('show', count > 0);
        el.classList.toggle('has', count > 0);
    });
}
async function fetchCartCount() {
    try {
        var r = await fetch('<?= base_url("shop/getCartCount") ?>', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        var d = await r.json();
        if (d.success && d.count !== undefined) updateCartCount(d.count);
    } catch (e) { /* abaikan */ }
}

// ===== Tambah ke keranjang (AJAX) =====
document.querySelectorAll('.add-to-cart-form').forEach(function (form) {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        var original = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan…';
        try {
            var r = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            var d = await r.json();
            if (d.success) {
                showSuccessToast();
                if (d.cart_count !== undefined) updateCartCount(d.cart_count); else fetchCartCount();
            } else if (d.redirect) {
                window.location.href = d.redirect; return;
            } else {
                alert(d.message || 'Gagal menambahkan produk ke keranjang');
            }
        } catch (err) {
            alert('Terjadi kesalahan, silakan coba lagi');
        } finally {
            btn.disabled = false; btn.innerHTML = original;
        }
    });
});

// ===== Hero slider =====
(function () {
    var track = document.getElementById('mfSlides');
    var slides = track.children, n = slides.length, i = 0, timer;
    var dots = document.getElementById('mfDots');
    for (var k = 0; k < n; k++) {
        (function (k) {
            var b = document.createElement('button');
            b.setAttribute('aria-label', 'Slide ' + (k + 1));
            b.addEventListener('click', function () { go(k, true); });
            dots.appendChild(b);
        })(k);
    }
    function go(x, user) {
        i = (x + n) % n;
        track.style.transform = 'translateX(-' + (i * 100) + '%)';
        Array.prototype.forEach.call(dots.children, function (d, j) { d.classList.toggle('on', j === i); });
        if (user) restart();
    }
    function restart() { clearInterval(timer); timer = setInterval(function () { go(i + 1); }, 5500); }
    document.querySelector('.mf-arrow.prev').addEventListener('click', function () { go(i - 1, true); });
    document.querySelector('.mf-arrow.next').addEventListener('click', function () { go(i + 1, true); });
    var sx = 0;
    track.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', function (e) {
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 40) go(dx < 0 ? i + 1 : i - 1, true);
    });
    go(0); restart();
})();

// ===== Reveal on scroll =====
(function () {
    var els = document.querySelectorAll('.mf-reveal');
    if (!('IntersectionObserver' in window)) { els.forEach(function (e) { e.classList.add('visible'); }); return; }
    var io = new IntersectionObserver(function (en) {
        en.forEach(function (x) { if (x.isIntersecting) { x.target.classList.add('visible'); io.unobserve(x.target); } });
    }, { threshold: 0.1 });
    els.forEach(function (e) { io.observe(e); });
})();

document.addEventListener('DOMContentLoaded', fetchCartCount);
</script>
</body>
</html>
