<?php
helper('akun');

$transaksi = $transaksi ?? [];
$nama      = trim((string) session()->get('nama')) ?: (session()->get('username') ?: 'Pengguna');
$email     = (string) (session()->get('email') ?? '');

/* Hitung jumlah per kelompok (untuk chip filter) + kumpulkan pesanan selesai */
$jumlah     = ['all' => count($transaksi), 'proses' => 0, 'selesai' => 0, 'batal' => 0];
$selesaiIds = [];
foreach ($transaksi as $row) {
    $g = us_group($row['status'] ?? '');
    $jumlah[$g]++;
    if (($row['status'] ?? '') === 'Selesai') { $selesaiIds[] = $row['id']; }
}

/* Satu query untuk tahu pesanan mana yang sudah diulas (sebelumnya 1 query per pesanan) */
$sudahDiulas = [];
if ($selesaiIds) {
    $rows = (new \App\Models\UlasanModel())
        ->select('transaksi_id')
        ->where('id_user', session()->get('id_user'))
        ->whereIn('transaksi_id', $selesaiIds)
        ->findAll();
    $sudahDiulas = array_map('intval', array_column($rows, 'transaksi_id'));
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan | YSP Jasmine</title>
    <link rel="icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-user.css') ?>?v=1">
</head>

<body class="mf-body">

    <?= view('User/layout/navbar', ['navActive' => '']) ?>

    <main class="us-page" id="main">

        <div class="mf-pagehead">
            <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; <a href="<?= base_url('user/dashboard') ?>">Akun Saya</a> &nbsp;/&nbsp; Riwayat Pesanan</div>
            <h1>Riwayat Pesanan</h1>
        </div>

        <div class="us-wrap">
            <div class="us-layout">

                <?= view('User/layout/akun_menu', [
                    'akunActive' => 'riwayat',
                    'akunNama'   => $nama,
                    'akunEmail'  => $email,
                ]) ?>

                <section class="us-main">

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="us-flash success" role="status"><i class="fas fa-check-circle"></i><span><?= esc(session()->getFlashdata('success')) ?></span></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="us-flash error" role="alert"><i class="fas fa-exclamation-circle"></i><span><?= esc(session()->getFlashdata('error')) ?></span></div>
                    <?php endif; ?>

                    <?php if (!empty($transaksi)): ?>

                        <!-- Filter + pencarian -->
                        <div class="us-toolbar">
                            <div class="mf-chips" role="group" aria-label="Filter status pesanan">
                                <button type="button" class="mf-chip on" data-filter="all">Semua<span class="n"><?= $jumlah['all'] ?></span></button>
                                <button type="button" class="mf-chip" data-filter="proses">Dalam Proses<span class="n"><?= $jumlah['proses'] ?></span></button>
                                <button type="button" class="mf-chip" data-filter="selesai">Selesai<span class="n"><?= $jumlah['selesai'] ?></span></button>
                                <?php if ($jumlah['batal'] > 0): ?>
                                    <button type="button" class="mf-chip" data-filter="batal">Dibatalkan<span class="n"><?= $jumlah['batal'] ?></span></button>
                                <?php endif; ?>
                            </div>
                            <label class="us-search">
                                <i class="fas fa-search"></i>
                                <input type="search" id="orderSearch" placeholder="Cari invoice atau produk…" aria-label="Cari pesanan" autocomplete="off">
                            </label>
                        </div>

                        <!-- Daftar pesanan -->
                        <div id="orderList">
                            <?php foreach ($transaksi as $t):
                                [$stLabel, $stClass, $stIcon] = us_status($t['status'] ?? '');
                                [$pyLabel, $pyClass, $pyIcon] = us_pay($t);
                                $details = $t['details'] ?? [];
                                $tampil  = array_slice($details, 0, 2);
                                $sisa    = count($details) - count($tampil);
                                $cari    = strtolower(us_invoice($t) . ' ' . implode(' ', array_column($details, 'nama_barang')));
                                $bisaUlas = ($t['status'] ?? '') === 'Selesai' && !in_array((int) $t['id'], $sudahDiulas, true);
                                $dataUlas = array_map(function ($d) {
                                    return ['nama_barang' => $d['nama_barang'] ?? 'Produk', 'jumlah' => $d['jumlah'] ?? 1];
                                }, $details);
                                $isDelivery = ($t['metode_pengiriman'] ?? '') === 'delivery';
                                $metodeBayar = strtoupper($t['metode_pembayaran'] ?? 'COD');
                            ?>
                                <article class="us-order" data-group="<?= us_group($t['status'] ?? '') ?>" data-search="<?= esc($cari, 'attr') ?>">
                                    <div class="us-order-head">
                                        <div>
                                            <span class="no"><?= esc(us_invoice($t)) ?></span>
                                            <span class="dt"><i class="far fa-calendar-alt"></i> <?= esc(us_tanggal($t['tanggal'] ?? null)) ?></span>
                                        </div>
                                        <div class="us-badges">
                                            <span class="us-badge <?= $stClass ?>"><i class="fas <?= $stIcon ?>"></i> <?= esc($stLabel) ?></span>
                                            <span class="us-badge <?= $pyClass ?>"><i class="fas <?= $pyIcon ?>"></i> <?= esc($pyLabel) ?></span>
                                        </div>
                                    </div>

                                    <?php if ($tampil): ?>
                                        <?php foreach ($tampil as $d): ?>
                                            <div class="us-item">
                                                <img src="<?= base_url('uploads/' . ($d['gambar'] ?? 'default.png')) ?>" alt="<?= esc($d['nama_barang'] ?? 'Produk') ?>" loading="lazy"
                                                     onerror="this.onerror=null;this.src='<?= base_url('uploads/default.png') ?>'">
                                                <div>
                                                    <div class="nm"><?= esc($d['nama_barang'] ?? 'Produk') ?></div>
                                                    <div class="qty"><?= (int) ($d['jumlah'] ?? 1) ?> × <?= us_rp($d['harga'] ?? 0) ?></div>
                                                </div>
                                                <div class="pr"><?= us_rp((int) ($d['jumlah'] ?? 1) * (int) ($d['harga'] ?? 0)) ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                        <?php if ($sisa > 0): ?>
                                            <div class="us-more">+ <?= $sisa ?> produk lainnya — <a class="us-link" href="<?= base_url('shop/nota/' . $t['id']) ?>">lihat semua</a></div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="us-more" style="border-top:0">Detail produk tidak tersedia.</div>
                                    <?php endif; ?>

                                    <div class="us-order-foot">
                                        <div class="us-meta">
                                            <span><i class="fas <?= $isDelivery ? 'fa-truck' : 'fa-store' ?>"></i><b><?= $isDelivery ? 'Delivery' : 'Ambil di Toko' ?></b></span>
                                            <span><i class="fas <?= $metodeBayar === 'COD' ? 'fa-money-bill-wave' : 'fa-university' ?>"></i><b><?= esc($metodeBayar) ?></b></span>
                                        </div>
                                        <div class="us-foot-right">
                                            <div class="us-total">
                                                <small>Total</small>
                                                <strong><?= us_rp(($t['total_akhir'] ?? 0) ?: ($t['total'] ?? 0)) ?></strong>
                                            </div>
                                            <div class="us-actions">
                                                <?php if ($bisaUlas): ?>
                                                    <button type="button" class="mf-btn sm gold js-review" data-id="<?= (int) $t['id'] ?>" data-details="<?= esc(json_encode($dataUlas), 'attr') ?>">
                                                        <i class="fas fa-star"></i> Beri Ulasan
                                                    </button>
                                                <?php endif; ?>
                                                <a href="<?= base_url('shop/nota/' . $t['id']) ?>" class="mf-btn sm solid">Detail Pesanan</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>

                        <!-- Tampil bila filter/pencarian tidak menemukan apa pun -->
                        <div class="us-empty" id="noResult" style="display:none">
                            <i class="fas fa-search"></i>
                            <h3>Pesanan tidak ditemukan</h3>
                            <p>Coba ubah filter atau kata kunci pencarian Anda.</p>
                        </div>

                    <?php else: ?>
                        <div class="us-empty">
                            <i class="fas fa-receipt"></i>
                            <h3>Belum ada pesanan</h3>
                            <p>Anda belum melakukan pemesanan apa pun.</p>
                            <a href="<?= base_url('shop') ?>" class="mf-btn solid">Mulai Belanja</a>
                        </div>
                    <?php endif; ?>

                </section>
            </div>
        </div>
    </main>

    <?= view('layout/mf_footer') ?>

    <!-- Modal Beri Ulasan -->
    <div class="modal fade us-modal" id="reviewModal" tabindex="-1" aria-labelledby="reviewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="reviewTitle">Beri Ulasan</h5>
                        <span class="modal-sub">Ceritakan pengalaman Anda agar membantu pembeli lain.</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="reviewProductsList"></div>
                    <form id="reviewForm" novalidate>
                        <input type="hidden" name="transaksi_id" id="reviewTransaksiId">
                        <input type="hidden" name="rating" id="ratingValue">

                        <div class="us-field">
                            <label>Rating</label>
                            <div class="us-rating" id="ratingInput" role="radiogroup" aria-label="Rating bintang">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <button type="button" data-rating="<?= $i ?>" role="radio" aria-checked="false" aria-label="<?= $i ?> bintang"><i class="fas fa-star"></i></button>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="us-field">
                            <label for="reviewKomentar">Komentar</label>
                            <textarea class="form-control" id="reviewKomentar" name="komentar" rows="3" placeholder="Tulis pengalaman Anda…"></textarea>
                        </div>
                        <div class="us-field">
                            <label for="reviewFoto">Foto <em>(opsional)</em></label>
                            <input type="file" class="form-control" id="reviewFoto" name="foto_ulasan" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mf-btn" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="mf-btn solid" id="submitReviewBtn">Kirim Ulasan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        /* ===== Filter + pencarian ===== */
        var chips   = document.querySelectorAll('.mf-chip[data-filter]');
        var cards   = document.querySelectorAll('.us-order');
        var search  = document.getElementById('orderSearch');
        var noRes   = document.getElementById('noResult');
        var current = 'all';

        function apply() {
            var q = search ? search.value.trim().toLowerCase() : '';
            var shown = 0;
            cards.forEach(function (c) {
                var okGroup = current === 'all' || c.getAttribute('data-group') === current;
                var okText  = !q || (c.getAttribute('data-search') || '').indexOf(q) !== -1;
                var show = okGroup && okText;
                c.style.display = show ? '' : 'none';
                if (show) shown++;
            });
            if (noRes) noRes.style.display = (cards.length && !shown) ? '' : 'none';
        }
        function setFilter(f) {
            current = f;
            chips.forEach(function (b) { b.classList.toggle('on', b.getAttribute('data-filter') === f); });
            apply();
        }
        chips.forEach(function (b) { b.addEventListener('click', function () { setFilter(b.getAttribute('data-filter')); }); });
        if (search) search.addEventListener('input', apply);

        // Dari dashboard: riwayat#proses / riwayat#selesai
        var h = location.hash.replace('#', '');
        if (['proses', 'selesai', 'batal'].indexOf(h) !== -1 && document.querySelector('.mf-chip[data-filter="' + h + '"]')) setFilter(h);

        /* ===== Ulasan ===== */
        var reviewEl = document.getElementById('reviewModal');
        if (!reviewEl) return;
        var stars   = document.querySelectorAll('#ratingInput button');
        var ratingV = document.getElementById('ratingValue');

        function setRating(n) {
            ratingV.value = n || '';
            stars.forEach(function (s) {
                var on = n && parseInt(s.getAttribute('data-rating'), 10) <= n;
                s.classList.toggle('on', !!on);
                s.setAttribute('aria-checked', (n && parseInt(s.getAttribute('data-rating'), 10) === n) ? 'true' : 'false');
            });
        }
        stars.forEach(function (s) { s.addEventListener('click', function () { setRating(parseInt(s.getAttribute('data-rating'), 10)); }); });

        document.querySelectorAll('.js-review').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var details = [];
                try { details = JSON.parse(btn.getAttribute('data-details') || '[]'); } catch (e) {}
                document.getElementById('reviewForm').reset();
                document.getElementById('reviewTransaksiId').value = btn.getAttribute('data-id');
                setRating(0);

                var box = document.getElementById('reviewProductsList');
                box.innerHTML = '';
                if (details.length) {
                    var wrap = document.createElement('div'); wrap.className = 'us-review-list';
                    var sm = document.createElement('small'); sm.textContent = 'Produk dalam pesanan'; wrap.appendChild(sm);
                    var ul = document.createElement('ul');
                    details.forEach(function (d) {
                        var li = document.createElement('li');
                        li.textContent = (d.nama_barang || 'Produk') + ' × ' + (d.jumlah || 1);
                        ul.appendChild(li);
                    });
                    wrap.appendChild(ul); box.appendChild(wrap);
                }
                bootstrap.Modal.getOrCreateInstance(reviewEl).show();
            });
        });

        document.getElementById('submitReviewBtn').addEventListener('click', async function () {
            var btn = this;
            if (!ratingV.value) {
                Swal.fire({ icon: 'warning', title: 'Pilih rating dulu', text: 'Tap bintang untuk memberi nilai.', confirmButtonColor: '#1f5c46' });
                return;
            }
            var fd = new FormData(document.getElementById('reviewForm'));
            <?php if (csrf_token()): ?>
            fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            <?php endif; ?>

            var label = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            try {
                var res  = await fetch('<?= base_url('ulasan/tambah') ?>', { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                var data = await res.json();
                if (data.success) {
                    bootstrap.Modal.getInstance(reviewEl).hide();
                    Swal.fire({ icon: 'success', title: 'Terima kasih!', text: data.message || 'Ulasan Anda terkirim.', confirmButtonColor: '#1f5c46' })
                        .then(function () { location.reload(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan.', confirmButtonColor: '#1f5c46' });
                }
            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat menghubungi server.', confirmButtonColor: '#1f5c46' });
            } finally {
                btn.disabled = false;
                btn.innerHTML = label;
            }
        });
    })();
    </script>
</body>

</html>
