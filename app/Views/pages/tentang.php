<?= view('layout/mf_head', [
    'title'       => 'Tentang Kami',
    'description' => 'Kenali YSP Jasmine, penyedia melati segar dan rangkaian melati premium dari Pemalang sejak 2001.',
]) ?>
<body class="mf-body">

<?= view('layout/mf_header', ['mfActive' => 'tentang']) ?>

<main id="main">
    <div class="mf-pagehead">
        <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; Tentang Kami</div>
        <h1>Tentang Kami</h1>
    </div>

    <section class="mf-section">
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

    <section class="mf-trust" aria-label="Keunggulan">
        <div class="mf-wrap">
            <div class="mf-trust-item"><i class="fas fa-leaf"></i><div><b>100% Melati Asli</b><span>Segar, tanpa bahan kimia</span></div></div>
            <div class="mf-trust-item"><i class="fas fa-truck-fast"></i><div><b>Pengiriman Cepat</b><span>Area terdekat hari yang sama</span></div></div>
            <div class="mf-trust-item"><i class="fas fa-hand-holding-heart"></i><div><b>Harga Terjangkau</b><span>Langsung dari kebun</span></div></div>
            <div class="mf-trust-item"><i class="fab fa-whatsapp"></i><div><b>Bantuan via WhatsApp</b><span>Respon cepat setiap hari</span></div></div>
        </div>
    </section>
</main>

<?= view('layout/mf_footer') ?>
<?= view('layout/mf_reveal') ?>
</body>
</html>
