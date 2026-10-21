<?= view('layout/mf_head', [
    'title'       => 'Testimoni',
    'description' => 'Ulasan nyata dari pembeli YSP Jasmine tentang melati segar dan rangkaian melati premium kami.',
]) ?>
<body class="mf-body">

<?= view('layout/mf_header', ['mfActive' => 'testimoni']) ?>

<?php $testimoni = $testimoni ?? []; ?>

<main id="main">
    <div class="mf-pagehead">
        <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; Testimoni</div>
        <h1>Kata Pelanggan</h1>
    </div>

    <section class="mf-section">
        <div class="mf-wrap">
            <div class="mf-sec-head">
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
                <?php if (isset($pager)): ?>
                    <div style="margin-top:32px;text-align:center"><?= $pager->links('default', 'default_full') ?></div>
                <?php endif; ?>
            <?php else: ?>
                <div class="mf-empty"><i class="far fa-comment-dots"></i><p>Belum ada testimoni. Jadilah yang pertama!</p><a href="<?= base_url('shop') ?>" class="mf-btn">Belanja Sekarang</a></div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?= view('layout/mf_footer') ?>
<?= view('layout/mf_reveal') ?>
</body>
</html>
