<?php
helper('akun');

$nama      = trim((string) ($nama ?? session()->get('nama') ?? '')) ?: 'Pengguna';
$pelanggan = $pelanggan ?? [];
$terbaru   = $pesanan_terbaru ?? [];
$namaDepan = explode(' ', $nama)[0];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya | YSP Jasmine</title>
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
            <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; Akun Saya</div>
            <h1>Akun Saya</h1>
        </div>

        <div class="us-wrap">
            <div class="us-layout">

                <?= view('User/layout/akun_menu', [
                    'akunActive' => 'dashboard',
                    'akunNama'   => $nama,
                    'akunEmail'  => $pelanggan['email'] ?? '',
                ]) ?>

                <section class="us-main">

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="us-flash success" role="status"><i class="fas fa-check-circle"></i><span><?= esc(session()->getFlashdata('success')) ?></span></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="us-flash error" role="alert"><i class="fas fa-exclamation-circle"></i><span><?= esc(session()->getFlashdata('error')) ?></span></div>
                    <?php endif; ?>

                    <!-- Sambutan -->
                    <div class="us-hero">
                        <div>
                            <span class="us-eyebrow">Selamat datang kembali</span>
                            <h2>Halo, <?= esc($namaDepan) ?></h2>
                            <p>Pantau pesanan Anda dan kelola data akun di sini.</p>
                        </div>
                        <div class="us-hero-actions">
                            <a href="<?= base_url('shop') ?>" class="mf-btn solid sm"><i class="fas fa-shopping-bag"></i> Belanja Lagi</a>
                            <button type="button" class="mf-btn sm" data-bs-toggle="modal" data-bs-target="#editProfileModalNavbar"><i class="far fa-id-card"></i> Edit Profil</button>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div class="us-stats">
                        <a class="us-stat" href="<?= base_url('shop/riwayat') ?>">
                            <span class="ic"><i class="fas fa-shopping-bag"></i></span>
                            <span><span class="num"><?= (int) ($total_pesanan ?? 0) ?></span><span class="lbl">Total Pesanan</span></span>
                        </a>
                        <a class="us-stat" href="<?= base_url('shop/riwayat') ?>#proses">
                            <span class="ic"><i class="fas fa-box-open"></i></span>
                            <span><span class="num"><?= (int) ($pesanan_diproses ?? 0) ?></span><span class="lbl">Dalam Proses</span></span>
                        </a>
                        <a class="us-stat" href="<?= base_url('shop/riwayat') ?>#selesai">
                            <span class="ic"><i class="fas fa-check-circle"></i></span>
                            <span><span class="num"><?= (int) ($pesanan_selesai ?? 0) ?></span><span class="lbl">Selesai</span></span>
                        </a>
                    </div>

                    <!-- Pesanan terbaru -->
                    <div class="us-sec-head">
                        <h2>Pesanan Terbaru</h2>
                        <?php if (!empty($terbaru)): ?>
                            <a href="<?= base_url('shop/riwayat') ?>" class="us-link">Lihat semua</a>
                        <?php endif; ?>
                    </div>

                    <?php if (empty($terbaru)): ?>
                        <div class="us-empty">
                            <i class="fas fa-receipt"></i>
                            <h3>Belum ada pesanan</h3>
                            <p>Pesanan Anda akan muncul di sini setelah Anda berbelanja.</p>
                            <a href="<?= base_url('shop') ?>" class="mf-btn solid">Mulai Belanja</a>
                        </div>
                    <?php else: ?>
                        <div class="us-row head" aria-hidden="true">
                            <span>Pesanan</span><span>Total</span><span>Status</span><span></span>
                        </div>
                        <?php foreach ($terbaru as $p):
                            [$stLabel, $stClass, $stIcon] = us_status($p['status'] ?? '');
                            [$pyLabel, $pyClass, $pyIcon] = us_pay($p);
                        ?>
                            <div class="us-row">
                                <div class="c-inv">
                                    <a class="inv" href="<?= base_url('shop/nota/' . $p['id']) ?>"><?= esc(us_invoice($p)) ?></a>
                                    <span class="dt"><?= esc(us_tanggal($p['tanggal'] ?? null)) ?></span>
                                </div>
                                <div class="c-tot tot"><?= us_rp(($p['total_akhir'] ?? 0) ?: ($p['total'] ?? 0)) ?></div>
                                <div class="c-bdg us-badges">
                                    <span class="us-badge <?= $stClass ?>"><i class="fas <?= $stIcon ?>"></i> <?= esc($stLabel) ?></span>
                                    <span class="us-badge <?= $pyClass ?>"><i class="fas <?= $pyIcon ?>"></i> <?= esc($pyLabel) ?></span>
                                </div>
                                <div class="c-act">
                                    <a href="<?= base_url('shop/nota/' . $p['id']) ?>" class="mf-btn sm">Detail</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Data akun -->
                    <div class="us-sec-head" style="margin-top:44px">
                        <h2>Data Akun</h2>
                        <button type="button" class="us-link" style="background:none;border-width:0 0 1px" data-bs-toggle="modal" data-bs-target="#editProfileModalNavbar">Ubah</button>
                    </div>
                    <dl class="us-info">
                        <div>
                            <dt>Nama</dt>
                            <dd><?= esc($nama) ?></dd>
                        </div>
                        <div>
                            <dt>Email</dt>
                            <dd class="<?= empty($pelanggan['email']) ? 'empty' : '' ?>"><?= !empty($pelanggan['email']) ? esc($pelanggan['email']) : 'Belum diisi' ?></dd>
                            <dt style="margin-top:14px">No. Telepon</dt>
                            <dd class="<?= empty($pelanggan['telepon']) ? 'empty' : '' ?>"><?= !empty($pelanggan['telepon']) ? esc($pelanggan['telepon']) : 'Belum diisi' ?></dd>
                        </div>
                        <div>
                            <dt>Alamat Pengiriman</dt>
                            <dd class="<?= empty($pelanggan['alamat']) ? 'empty' : '' ?>"><?= !empty($pelanggan['alamat']) ? nl2br(esc($pelanggan['alamat'])) : 'Belum diisi' ?></dd>
                        </div>
                    </dl>

                </section>
            </div>
        </div>
    </main>

    <?= view('layout/mf_footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
