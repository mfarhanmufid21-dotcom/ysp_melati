<?= view('layout/mf_head', [
    'title'       => 'Cara Pemesanan',
    'description' => 'Cara memesan melati di YSP Jasmine: buat akun, pilih produk, tambah keranjang, lalu bayar dan konfirmasi.',
]) ?>
<body class="mf-body">

<?= view('layout/mf_header', ['mfActive' => 'cara-pesan']) ?>

<?php
$isLoggedCustomer = session()->get('pelanggan_id') !== null;
$steps = [
    ['Buat Akun',          'Daftar gratis, hanya butuh beberapa menit.'],
    ['Pilih Produk',       'Jelajahi koleksi melati dan pilih yang Anda suka.'],
    ['Tambah Keranjang',   'Masukkan ke keranjang lalu lengkapi data pengiriman.'],
    ['Bayar & Konfirmasi', 'Bayar lalu pilih ambil di tempat atau kirim ke alamat Anda.'],
];
?>

<main id="main">
    <div class="mf-pagehead">
        <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; Cara Pesan</div>
        <h1>Cara Pemesanan</h1>
    </div>

    <section class="mf-section soft">
        <div class="mf-wrap">
            <div class="mf-sec-head">
                <p>Mudah dan cepat, hanya 4 langkah.</p>
            </div>
            <div class="mf-steps">
                <?php foreach ($steps as $i => $s): ?>
                    <div class="mf-step mf-reveal">
                        <div class="n"><?= $i + 1 ?></div>
                        <h3><?= $s[0] ?></h3>
                        <p><?= $s[1] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mf-sec-foot">
                <?php if (!$isLoggedCustomer): ?>
                    <a href="<?= base_url('register') ?>" class="mf-btn solid">Daftar gratis</a>
                <?php endif; ?>
                <a href="<?= base_url('shop') ?>" class="mf-btn">Mulai belanja</a>
            </div>
        </div>
    </section>
</main>

<?= view('layout/mf_footer') ?>
<?= view('layout/mf_reveal') ?>
</body>
</html>
