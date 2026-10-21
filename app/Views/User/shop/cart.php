<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | YSP Jasmine</title>
    <link rel="icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-shop.css') ?>?v=1">
</head>

<?php
$cart      = $cart ?? [];
$hasItems  = !empty($cart) && count($cart) > 0;

/* Produk roncean / pre-order (logika sama seperti sebelumnya) */
$isPreOrder = function (array $item) {
    $n = strtolower($item['nama_barang'] ?? '');
    return strpos($n, 'ronce') !== false || strpos($n, 'pengantin') !== false
        || strpos($n, 'gelang') !== false || strpos($n, 'set') !== false;
};

$total = 0;
$hasPO = false;
foreach ($cart as $it) {
    $total += ($it['harga'] ?? 0) * ($it['qty'] ?? 0);
    if ($isPreOrder($it)) { $hasPO = true; }
}
?>

<body class="mf-body<?= $hasItems ? ' sh-has-bar' : '' ?>">

    <!-- ========== NAVBAR ========== -->
    <?= $this->include('User/layout/navbar') ?>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <div class="spinner-border mb-3" role="status"></div>
            <p class="mb-0 fw-bold">Memproses...</p>
            <small class="text-muted">Mohon tunggu sebentar</small>
        </div>
    </div>

    <main class="sh-page" id="main">

        <div class="mf-pagehead">
            <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; Keranjang</div>
            <h1>Keranjang Belanja</h1>
        </div>

        <?= view('layout/sh_steps', ['shStep' => 1]) ?>

        <div class="sh-wrap">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert mf-alert success alert-dismissible fade show" role="alert" style="margin-top:26px">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert mf-alert error alert-dismissible fade show" role="alert" style="margin-top:26px">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <?php if ($hasItems): ?>
                <div class="sh-layout">

                    <!-- ===== Daftar produk ===== -->
                    <section aria-label="Produk di keranjang">

                        <?php if ($hasPO): ?>
                            <div class="sh-notice">
                                <i class="fas fa-clock"></i>
                                <div><b>Ada produk Pre-Order.</b> Produk berlabel Pre-Order dikirim <b>H+1</b> (besok). Pesan sebelum pukul <b>17.00 WIB</b>.</div>
                            </div>
                        <?php endif; ?>

                        <div class="sh-list-head">
                            <h2>Pesanan Anda</h2>
                            <span><span id="cartCount"><?= count($cart) ?></span> produk</span>
                        </div>

                        <div id="cart-items-container">
                            <?php foreach ($cart as $id => $item):
                                $productName  = $item['nama_barang'] ?? $item['nama'] ?? 'Produk';
                                $productPrice = $item['harga'];
                                $productQty   = $item['qty'];
                                $subtotal     = $productPrice * $productQty;
                                $isPO         = $isPreOrder($item);

                                $gambarPath = FCPATH . 'uploads/' . ($item['gambar'] ?? '');
                                $gambar = (!empty($item['gambar']) && file_exists($gambarPath))
                                    ? base_url('uploads/' . $item['gambar'])
                                    : 'https://placehold.co/200x200/f7f5f0/1f5c46?text=YSP';
                                $detailUrl = base_url('shop/detail/' . $id);
                            ?>
                                <article class="sh-item" id="cart-row-<?= $id ?>">
                                    <a class="sh-item-img" href="<?= $detailUrl ?>" aria-label="Lihat <?= esc($productName) ?>">
                                        <img src="<?= $gambar ?>" alt="<?= esc($productName) ?>" loading="lazy">
                                    </a>

                                    <div class="sh-item-info">
                                        <?php if ($isPO): ?>
                                            <span class="sh-tag"><i class="fas fa-clock"></i> Pre-Order</span>
                                        <?php endif; ?>
                                        <h3 class="sh-item-name"><a href="<?= $detailUrl ?>"><?= esc($productName) ?></a></h3>
                                        <div class="sh-item-unit">Rp <?= number_format($productPrice, 0, ',', '.') ?> / item</div>
                                        <?php if ($isPO): ?>
                                            <div class="sh-po-note">Dikirim besok (H+1)</div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="sh-item-qty">
                                        <div class="sh-qty" role="group" aria-label="Jumlah <?= esc($productName) ?>">
                                            <button type="button" class="update-cart-btn" data-id="<?= $id ?>" data-action="minus" aria-label="Kurangi jumlah">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="qty-value cart-qty-<?= $id ?>" aria-live="polite"><?= $productQty ?></span>
                                            <button type="button" class="update-cart-btn" data-id="<?= $id ?>" data-action="plus" aria-label="Tambah jumlah">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="sh-item-sub subtotal-cell">Rp <?= number_format($subtotal, 0, ',', '.') ?></div>

                                    <div class="sh-item-rm">
                                        <button type="button" class="sh-remove remove-item-btn" data-id="<?= $id ?>" data-name="<?= esc($productName) ?>" aria-label="Hapus <?= esc($productName) ?>">
                                            <i class="far fa-trash-alt"></i> <span>Hapus</span>
                                        </button>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>

                        <input type="hidden" id="csrf_token_ajax" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                        <a href="<?= base_url('shop') ?>" class="sh-back"><i class="fas fa-arrow-left"></i> Lanjut Belanja</a>
                    </section>

                    <!-- ===== Ringkasan ===== -->
                    <aside class="sh-aside" aria-label="Ringkasan belanja">
                        <div class="sh-summary">
                            <h2>Ringkasan Belanja</h2>

                            <div class="sh-sum-row">
                                <span class="muted">Subtotal produk</span>
                                <span id="subtotalAmount">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                            <div class="sh-sum-row">
                                <span class="muted">Ongkos kirim</span>
                                <span class="soft">Dihitung di checkout</span>
                            </div>

                            <div class="sh-sum-total">
                                <span class="lbl">Total</span>
                                <span class="val js-total" id="totalAmount">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>

                            <p class="sh-sum-note">Ongkos kirim dan biaya proteksi ditentukan setelah Anda memilih metode pengiriman di halaman checkout.</p>

                            <div class="sh-cta">
                                <button type="button" class="mf-btn solid js-checkout" id="checkoutBtn">
                                    Lanjut ke Checkout <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>

                            <div class="sh-trust">
                                <div><i class="fas fa-leaf"></i> Melati segar, dikemas rapi</div>
                                <div><i class="fas fa-lock"></i> Pembayaran aman &amp; terverifikasi</div>
                                <div><i class="fab fa-whatsapp"></i> Bingung? <a href="https://wa.me/6285647695804?text=Halo%20YSP%20Jasmine,%20saya%20butuh%20bantuan%20pesanan" target="_blank" rel="noopener">Chat kami</a></div>
                            </div>
                        </div>
                    </aside>
                </div>

                <!-- Bar bawah (HP) -->
                <div class="sh-mobilebar">
                    <div class="tot"><small>Total</small><b class="js-total">Rp <?= number_format($total, 0, ',', '.') ?></b></div>
                    <button type="button" class="mf-btn solid js-checkout">Checkout <i class="fas fa-arrow-right"></i></button>
                </div>

            <?php else: ?>
                <!-- Keranjang kosong -->
                <div class="sh-empty">
                    <div class="ic"><i class="fas fa-shopping-bag"></i></div>
                    <h2>Keranjang Masih Kosong</h2>
                    <p>Yuk, mulai belanja kebutuhan bunga melati Anda.</p>
                    <a href="<?= base_url('shop') ?>" class="mf-btn solid"><i class="fas fa-shopping-bag"></i> Mulai Belanja</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?= view('layout/mf_footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loadingOverlay = document.getElementById('loadingOverlay');
        const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');

        function showLoading() { if (loadingOverlay) loadingOverlay.style.display = 'flex'; }
        function hideLoading() { if (loadingOverlay) loadingOverlay.style.display = 'none'; }

        // Perbarui semua tampilan total / subtotal / jumlah item / badge keranjang
        function setTotals(total) {
            const t = rupiah(total);
            const sub = document.getElementById('subtotalAmount');
            if (sub) sub.innerText = t;
            document.querySelectorAll('.js-total').forEach(el => el.innerText = t);
        }
        function refreshCount(cartQty) {
            const rows = document.querySelectorAll('.sh-item').length;
            const el = document.getElementById('cartCount');
            if (el) el.innerText = rows;
            if (cartQty !== undefined) {
                document.querySelectorAll('.mf-cart-count').forEach(b => { b.textContent = cartQty; });
            }
        }

        // ======================
        // UPDATE CART AJAX
        // ======================
        document.querySelectorAll('.update-cart-btn').forEach(btn => {
            btn.addEventListener('click', async function (e) {
                e.preventDefault();
                const productId = this.dataset.id;
                const action = this.dataset.action;
                const csrfInput = document.getElementById('csrf_token_ajax');

                showLoading();

                try {
                    const formData = new FormData();
                    formData.append('id', productId);
                    formData.append('action', action);
                    formData.append(csrfInput.getAttribute('name'), csrfInput.value);

                    const response = await fetch(`<?= base_url('shop/updateCart') ?>`, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    const result = await response.json();
                    if (result.csrf_hash) csrfInput.value = result.csrf_hash;

                    if (!result.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: result.message || 'Terjadi kesalahan',
                            confirmButtonColor: '#1f5c46'
                        });
                        return;
                    }

                    const qtyElement = document.querySelector(`.cart-qty-${productId}`);
                    if (qtyElement && result.qty !== undefined) qtyElement.innerText = result.qty;

                    const subtotalElement = document.querySelector(`#cart-row-${productId} .subtotal-cell`);
                    if (subtotalElement && result.subtotal !== undefined) subtotalElement.innerText = rupiah(result.subtotal);

                    setTotals(result.total);

                    if (result.removed) {
                        document.getElementById(`cart-row-${productId}`)?.remove();
                        if (result.cart_count <= 0) setTimeout(() => location.reload(), 500);
                    }
                    refreshCount(result.cart_count);

                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan koneksi', confirmButtonColor: '#1f5c46' });
                } finally {
                    hideLoading();
                }
            });
        });

        // ======================
        // REMOVE ITEM AJAX
        // ======================
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', async function (e) {
                e.preventDefault();
                const productId = this.dataset.id;
                const itemName = this.dataset.name;
                const csrfInput = document.getElementById('csrf_token_ajax');

                const confirmDelete = await Swal.fire({
                    title: 'Hapus produk?',
                    text: `Hapus "${itemName}" dari keranjang?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#c0392b',
                    cancelButtonColor: '#6d6d6d',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                });
                if (!confirmDelete.isConfirmed) return;

                showLoading();

                try {
                    const formData = new FormData();
                    formData.append('id', productId);
                    formData.append(csrfInput.getAttribute('name'), csrfInput.value);

                    const response = await fetch(`<?= base_url('shop/remove') ?>`, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    const result = await response.json();
                    if (result.csrf_hash) csrfInput.value = result.csrf_hash;

                    if (result.success) {
                        document.getElementById(`cart-row-${productId}`)?.remove();
                        if (result.total !== undefined) setTotals(result.total);
                        refreshCount(result.cart_count);

                        Swal.fire({
                            icon: 'success',
                            title: 'Produk dihapus',
                            timer: 1000,
                            showConfirmButton: false
                        });

                        if (result.cart_count <= 0) setTimeout(() => location.reload(), 1100);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: result.message, confirmButtonColor: '#1f5c46' });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghubungi server', confirmButtonColor: '#1f5c46' });
                } finally {
                    hideLoading();
                }
            });
        });

        // ======================
        // CHECKOUT BUTTON (desktop + bar bawah HP)
        // ======================
        document.querySelectorAll('.js-checkout').forEach(btn => {
            btn.addEventListener('click', function () {
                window.location.href = '<?= base_url('shop/checkout') ?>';
            });
        });
    </script>
</body>

</html>
