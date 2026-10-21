<?= view('layout/mf_head', [
    'title'       => 'Kontak',
    'description' => 'Hubungi YSP Jasmine di Pemalang via WhatsApp atau kunjungi toko kami. Buka setiap hari 08.00–17.00.',
]) ?>
<body class="mf-body">

<?= view('layout/mf_header', ['mfActive' => 'kontak']) ?>

<main id="main">
    <div class="mf-pagehead">
        <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; Kontak</div>
        <h1>Kontak Kami</h1>
    </div>

    <section class="mf-section soft">
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
<?= view('layout/mf_reveal') ?>
</body>
</html>
