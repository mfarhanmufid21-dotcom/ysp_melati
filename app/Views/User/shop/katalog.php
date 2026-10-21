<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk | YSP Jasmine</title>
    <meta name="description" content="Katalog melati segar dan rangkaian melati premium YSP Jasmine. Belanja mudah, pengiriman cepat.">
    <link rel="icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">
</head>

<body class="mf-body">

<?= view('layout/mf_header', ['mfActive' => 'produk']) ?>

<?php
$barang   = $barang ?? [];
$qSearch  = trim((string) ($_GET['search'] ?? ''));
$qSort    = (string) ($_GET['sort'] ?? '');
$qStock   = (string) ($_GET['stock'] ?? '');
$isLogged = session()->get('pelanggan_id') !== null;

/* Bangun URL filter dengan mempertahankan parameter lain */
$mkUrl = function (array $override) use ($qSearch, $qSort, $qStock) {
    $params = array_filter(array_merge(
        ['search' => $qSearch, 'sort' => $qSort, 'stock' => $qStock],
        $override
    ), function ($v) { return $v !== '' && $v !== null; });
    return base_url('katalog') . ($params ? '?' . http_build_query($params) : '');
};

/* Deteksi produk roncean / pre-order (logika sama seperti sebelumnya) */
$isPO = function (array $item) {
    $n = strtolower($item['nama_barang'] ?? '');
    return strpos($n, 'ronce') !== false || strpos($n, 'pengantin') !== false
        || strpos($n, 'gelang') !== false || strpos($n, 'set') !== false;
};
?>

<main id="main">

    <div class="mf-pagehead">
        <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; Produk</div>
        <h1>Semua Produk</h1>
    </div>

    <div class="mf-wrap" style="padding-top:8px">

        <!-- ===== Toolbar: filter status (chip) + cari + urutkan ===== -->
        <div class="mf-toolbar">
            <div class="mf-chips" role="group" aria-label="Filter status">
                <a class="mf-chip <?= $qStock === '' ? 'on' : '' ?>" href="<?= $mkUrl(['stock' => '']) ?>">Semua</a>
                <a class="mf-chip <?= $qStock === 'tersedia' ? 'on' : '' ?>" href="<?= $mkUrl(['stock' => 'tersedia']) ?>">Tersedia</a>
                <a class="mf-chip <?= $qStock === 'po' ? 'on' : '' ?>" href="<?= $mkUrl(['stock' => 'po']) ?>">Pre-Order</a>
            </div>
            <form action="<?= base_url('katalog') ?>" method="GET" id="searchForm" style="display:flex;gap:8px;flex-wrap:wrap">
                <input type="text" name="search" placeholder="Cari produk…" value="<?= esc($qSearch) ?>" aria-label="Cari produk">
                <select id="sortSelect" aria-label="Urutkan">
                    <option value="">Urutkan: Default</option>
                    <option value="newest" <?= $qSort === 'newest' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="popular" <?= $qSort === 'popular' ? 'selected' : '' ?>>Terlaris</option>
                    <option value="price_asc" <?= $qSort === 'price_asc' ? 'selected' : '' ?>>Harga: Rendah ke Tinggi</option>
                    <option value="price_desc" <?= $qSort === 'price_desc' ? 'selected' : '' ?>>Harga: Tinggi ke Rendah</option>
                </select>
                <input type="hidden" id="stockFilter" value="<?= esc($qStock) ?>">
                <button type="submit" class="mf-btn" style="padding:9px 18px"><i class="fas fa-search"></i> Cari</button>
            </form>
        </div>

        <div class="mf-count" style="margin-bottom:22px">
            <?php if (!empty($barang)): ?>
                Menampilkan <b><?= count($barang) ?></b> produk<?= $qSearch !== '' ? ' untuk “' . esc($qSearch) . '”' : '' ?>
                <?php if ($qStock === 'po'): ?>· <span title="Dikirim H+1, pesan sebelum 17.00 WIB">Pre-Order: kirim H+1, pesan sebelum 17.00 WIB</span><?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- ===== Grid produk ===== -->
        <?php if (!empty($barang)): ?>
            <div class="mf-grid" id="productContainer">
                <?php foreach ($barang as $item): ?>
                    <?php
                    $stok   = (int) ($item['stok'] ?? 0);
                    $po     = $isPO($item);
                    $promo  = !empty($item['is_promo']) && ($item['harga_diskon'] ?? 0) > 0;
                    $img    = (!empty($item['gambar']) && file_exists(FCPATH . 'uploads/' . $item['gambar'])) ? base_url('uploads/' . $item['gambar']) : null;
                    $detail = base_url('shop/detail/' . $item['id']);
                    ?>
                    <article class="mf-card">
                        <a class="mf-card-img" href="<?= $detail ?>" aria-label="Lihat <?= esc($item['nama_barang']) ?>">
                            <?php if ($img): ?>
                                <img src="<?= $img ?>" alt="<?= esc($item['nama_barang']) ?>" loading="lazy">
                            <?php else: ?>
                                <div class="ph">🌸</div>
                            <?php endif; ?>
                            <div class="mf-badges">
                                <?php if ($promo): ?><span class="mf-badge sale">-<?= round((($item['harga'] - $item['harga_diskon']) / $item['harga']) * 100) ?>%</span><?php endif; ?>
                                <?php if ($po): ?><span class="mf-badge po">Pre-Order</span>
                                <?php elseif ($stok <= 0): ?><span class="mf-badge out">Habis</span>
                                <?php elseif ($stok <= 5): ?><span class="mf-badge low">Sisa <?= $stok ?></span><?php endif; ?>
                            </div>
                        </a>
                        <div class="mf-card-body">
                            <h3 class="mf-card-name"><a href="<?= $detail ?>"><?= esc($item['nama_barang']) ?></a></h3>
                            <div class="mf-price">
                                <?php if ($promo): ?>
                                    <s>Rp <?= number_format($item['harga'], 0, ',', '.') ?></s><em>Rp <?= number_format($item['harga_diskon'], 0, ',', '.') ?></em>
                                <?php else: ?>
                                    Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                <?php endif; ?>
                            </div>
                            <div class="mf-meta">
                                <?php if ($po): ?>Kirim H+1 · PO sebelum 17.00 WIB
                                <?php elseif ($stok > 0): ?>Stok <?= $stok ?> unit
                                <?php else: ?>Stok habis<?php endif; ?>
                            </div>

                            <div class="mf-card-actions">
                                <?php if ($isLogged): ?>
                                    <?php if ($stok > 0 || $po): ?>
                                        <button type="button" class="mf-btn add-to-cart-btn"
                                                data-id="<?= $item['id'] ?>"
                                                data-name="<?= esc($item['nama_barang']) ?>"
                                                data-roncean="<?= $po ? '1' : '0' ?>">
                                            <i class="fas fa-shopping-bag"></i> Tambah ke Keranjang
                                        </button>
                                    <?php else: ?>
                                        <button class="mf-btn" disabled>Stok Habis</button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?= base_url('login') ?>" class="mf-btn"><i class="fas fa-lock"></i> Login untuk Beli</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mf-empty">
                <i class="fas fa-seedling"></i>
                <h3 style="font-family:var(--mf-serif);color:var(--mf-ink)">Produk tidak ditemukan</h3>
                <p>Coba kata kunci lain atau hapus filter yang aktif.</p>
                <a href="<?= base_url('katalog') ?>" class="mf-btn">Lihat semua produk</a>
            </div>
        <?php endif; ?>

        <?php if (isset($pagination) && $pagination): ?>
            <div class="pagination-custom" style="margin-top:34px;text-align:center"><?= $pagination ?></div>
        <?php endif; ?>
    </div>
</main>

<?= view('layout/mf_footer') ?>

<div class="mf-toast" id="cartToast"></div>

<script>
// ===== Filter: pertahankan semua parameter =====
function updateUrl() {
    var params = [];
    var search = document.querySelector('#searchForm input[name="search"]').value;
    var sort   = document.getElementById('sortSelect').value;
    var stock  = document.getElementById('stockFilter').value;
    if (search) params.push('search=' + encodeURIComponent(search));
    if (sort)   params.push('sort='   + encodeURIComponent(sort));
    if (stock)  params.push('stock='  + encodeURIComponent(stock));
    window.location.href = '<?= base_url("katalog") ?>' + (params.length ? '?' + params.join('&') : '');
}
document.getElementById('sortSelect').addEventListener('change', updateUrl);
document.getElementById('searchForm').addEventListener('submit', function (e) { e.preventDefault(); updateUrl(); });

// ===== Toast =====
function showCartToast(productName, isRoncean) {
    var t = document.getElementById('cartToast');
    t.innerHTML = '<i class="fas fa-check-circle"></i> ' + productName + ' ditambahkan' + (isRoncean ? ' (Pre-Order)' : '') +
                  '. <a href="<?= base_url("shop/cart") ?>">Lihat keranjang</a>';
    t.classList.add('show');
    setTimeout(function () { t.classList.remove('show'); }, 3500);
}

// ===== Jumlah keranjang =====
function updateCartCount(count) {
    document.querySelectorAll('.cart-count').forEach(function (el) {
        el.textContent = count > 0 ? count : '0';
        el.classList.toggle('show', count > 0);
        el.classList.toggle('has', count > 0);
    });
}

// ===== Tambah ke keranjang =====
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (e) {
        var button = e.target.closest('.add-to-cart-btn');
        if (!button) return;
        e.preventDefault();
        if (button.disabled) return;

        var productId = button.getAttribute('data-id');
        var productName = button.getAttribute('data-name');
        var isRoncean = button.getAttribute('data-roncean') === '1';
        if (!productId) { alert('Error: Product ID tidak ditemukan'); return; }

        var originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambah…';

        fetch('<?= base_url("shop/addToCart") ?>/' + productId, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
            body: 'qty=1'
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            button.disabled = false;
            button.innerHTML = originalText;
            if (data.success) {
                if (data.cart_count !== undefined) updateCartCount(data.cart_count);
                showCartToast(productName, isRoncean);
            } else if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Gagal menambahkan ke keranjang');
            }
        })
        .catch(function () {
            button.disabled = false;
            button.innerHTML = originalText;
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });
});
</script>
</body>

</html>
