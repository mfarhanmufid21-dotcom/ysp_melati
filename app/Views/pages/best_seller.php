<?= view('layout/mf_head', [
    'title'       => 'Best Seller',
    'description' => 'Produk melati terlaris YSP Jasmine, favorit pelanggan untuk pernikahan, souvenir, dan acara spesial.',
]) ?>
<body class="mf-body">

<?= view('layout/mf_header', ['mfActive' => 'best-seller']) ?>

<?php $produk = $produk ?? []; $isLoggedCustomer = session()->get('pelanggan_id') !== null; ?>

<main id="main">
    <div class="mf-pagehead">
        <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; Best Seller</div>
        <h1>Best Seller</h1>
    </div>

    <section class="mf-section">
        <div class="mf-wrap">
            <div class="mf-sec-head">
                <p>Pilihan favorit pelanggan kami, diurutkan dari yang paling banyak terjual.</p>
            </div>
            <?php if (!empty($produk)): ?>
                <div class="mf-grid">
                    <?php foreach ($produk as $i => $p): ?>
                        <?= view('layout/mf_card', [
                            'p'                => $p,
                            'label'            => $i < 3 ? 'Terlaris #' . ($i + 1) : '',
                            'isLoggedCustomer' => $isLoggedCustomer,
                        ]) ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="mf-empty"><i class="fas fa-seedling"></i><p>Produk akan segera hadir.</p></div>
            <?php endif; ?>
            <div class="mf-sec-foot"><a href="<?= base_url('shop') ?>" class="mf-btn solid">Lihat semua produk</a></div>
        </div>
    </section>
</main>

<?= view('layout/mf_footer') ?>

<div class="mf-toast" id="authToast"><i class="fas fa-lock"></i> Silakan <a href="<?= base_url('login') ?>">login</a> atau <a href="<?= base_url('register') ?>">daftar</a> dulu untuk berbelanja.</div>
<div class="mf-toast" id="successToast"><i class="fas fa-check-circle"></i> Produk ditambahkan ke keranjang. <a href="<?= base_url('shop/cart') ?>">Lihat keranjang</a></div>

<script>
function showAuthAlert() {
    var t = document.getElementById('authToast');
    t.classList.add('show'); setTimeout(function () { t.classList.remove('show'); }, 4000);
}
function showSuccessToast() {
    var t = document.getElementById('successToast');
    t.classList.add('show'); setTimeout(function () { t.classList.remove('show'); }, 3500);
}
function updateCartCount(count) {
    document.querySelectorAll('.cart-count').forEach(function (el) {
        el.textContent = count > 0 ? count : '0';
        el.classList.toggle('show', count > 0);
        el.classList.toggle('has', count > 0);
    });
}
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
                if (d.cart_count !== undefined) updateCartCount(d.cart_count);
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
</script>
<?= view('layout/mf_reveal') ?>
</body>
</html>
