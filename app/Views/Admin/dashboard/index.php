<?= $this->extend('Admin/layout/admin') ?>
<?= $this->section('content') ?>

<style>
    /* ===== CUSTOM STYLES ===== */
    :root {
        --primary-green: #164534;
        --secondary-green: #1F5C46;
        --gold: #B8963E;
        --gold-light: #D4B766;
        --font-base: 16px;
    }

    .dashboard-wrapper {
        padding: 20px 24px;
        font-size: var(--font-base);
    }

    /* ===== WELCOME BANNER ===== */
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        border-radius: 16px;
        padding: 36px 42px;
        margin-bottom: 28px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::after {
        content: '🌸';
        position: absolute;
        right: 30px;
        bottom: -20px;
        font-size: 140px;
        opacity: 0.08;
    }

    .welcome-title {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .welcome-sub {
        color: rgba(255,255,255,0.8);
        font-size: 17px;
        margin-bottom: 20px;
        max-width: 500px;
    }

    .welcome-stats {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .welcome-stat-item {
        background: rgba(255,255,255,0.12);
        padding: 10px 22px;
        border-radius: 12px;
        backdrop-filter: blur(4px);
    }

    .welcome-stat-item small {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        opacity: 0.7;
        letter-spacing: 0.8px;
    }

    .welcome-stat-item strong {
        font-size: 22px;
        font-weight: 700;
        color: var(--gold-light);
    }

    /* ===== PROFIT CARDS ===== */
    .profit-card {
        border-radius: 16px;
        padding: 24px 28px;
        color: white;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .profit-card.green { background: linear-gradient(135deg, #164534, #1F5C46); }
    .profit-card.gold { background: linear-gradient(135deg, #B8963E, #D4B766); }
    .profit-card.blue { background: linear-gradient(135deg, #1976d2, #42a5f5); }

    .profit-card .profit-label {
        font-size: 13px;
        text-transform: uppercase;
        opacity: 0.85;
        letter-spacing: 0.8px;
        font-weight: 500;
    }

    .profit-card .profit-value {
        font-size: 34px;
        font-weight: 800;
        margin: 6px 0;
        letter-spacing: -0.5px;
    }

    .profit-card .profit-detail {
        font-size: 15px;
        opacity: 0.85;
    }

    /* ===== STATISTIC CARDS ===== */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px 28px;
        border: 1px solid #E9E7E2;
        transition: all 0.25s ease;
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0,0,0,0.08);
        border-color: var(--gold);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-icon.green { background: #EAF3EE; color: var(--secondary-green); }
    .stat-icon.gold { background: #F6EFD9; color: var(--gold); }
    .stat-icon.blue { background: #e3f2fd; color: #1976d2; }
    .stat-icon.orange { background: #fff3e0; color: #e65100; }

    .stat-value {
        font-size: 34px;
        font-weight: 800;
        color: #1B1B1B;
        margin: 6px 0;
        letter-spacing: -0.5px;
    }

    .stat-label {
        font-size: 15px;
        color: #6D6D6D;
        font-weight: 500;
    }

    .stat-trend {
        font-size: 14px;
        font-weight: 600;
        color: var(--secondary-green);
        background: #EAF3EE;
        padding: 4px 14px;
        border-radius: 20px;
    }

    /* ===== PANEL CARDS ===== */
    .panel-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #E9E7E2;
        overflow: hidden;
        height: 100%;
        transition: all 0.25s ease;
    }

    .panel-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .panel-header {
        padding: 18px 24px;
        border-bottom: 1px solid #F1EFE9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .panel-title {
        font-size: 18px;
        font-weight: 700;
        color: #1B1B1B;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .panel-title i {
        color: var(--gold);
        font-size: 20px;
    }

    .panel-badge {
        font-size: 13px;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 20px;
        background: #F7F5F0;
        color: #6D6D6D;
    }

    .panel-body {
        padding: 24px;
    }

    /* ===== CHART ===== */
    .chart-container {
        position: relative;
        height: 280px;
        width: 100%;
    }

    .chart-container-sm {
        height: 200px;
    }

    /* ===== QUICK ACTIONS ===== */
    .quick-action {
        background: #F7F5F0;
        border-radius: 14px;
        padding: 20px 16px;
        text-align: center;
        text-decoration: none;
        color: #1B1B1B;
        transition: all 0.25s ease;
        border: 1px solid transparent;
        display: block;
    }

    .quick-action:hover {
        background: white;
        border-color: var(--gold);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }

    .quick-action i {
        font-size: 28px;
        color: var(--gold);
        margin-bottom: 8px;
        display: block;
    }

    .quick-action span {
        font-size: 15px;
        font-weight: 600;
        display: block;
    }

    .quick-action small {
        font-size: 13px;
        color: #6D6D6D;
    }

    /* ===== STOCK LIST ===== */
    .stock-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #F1EFE9;
    }

    .stock-item:last-child {
        border-bottom: none;
    }

    .stock-name {
        font-weight: 600;
        font-size: 16px;
        color: #1B1B1B;
    }

    .stock-category {
        font-size: 14px;
        color: #6D6D6D;
    }

    .stock-badge {
        font-size: 14px;
        font-weight: 700;
        padding: 5px 16px;
        border-radius: 20px;
    }

    .stock-badge.danger { background: #fce4ec; color: #c62828; }
    .stock-badge.warning { background: #fff3e0; color: #e65100; }

    /* ===== PRODUCT RANK ===== */
    .product-rank {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #F1EFE9;
    }

    .product-rank:last-child {
        border-bottom: none;
    }

    .rank-number {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #F7F5F0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        color: #6D6D6D;
        flex-shrink: 0;
    }

    .rank-number.gold {
        background: var(--gold);
        color: white;
    }

    .product-rank-name {
        font-weight: 600;
        font-size: 16px;
        color: #1B1B1B;
    }

    .product-rank-meta {
        font-size: 14px;
        color: #6D6D6D;
    }

    .product-rank-sales {
        font-weight: 700;
        color: var(--secondary-green);
        font-size: 16px;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 36px 20px;
    }

    .empty-state i {
        font-size: 56px;
        color: #dee2e6;
        margin-bottom: 14px;
    }

    .empty-state h6 {
        font-weight: 700;
        font-size: 18px;
        color: #1B1B1B;
    }

    .empty-state p {
        font-size: 15px;
        color: #6D6D6D;
        margin-bottom: 0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 12px 16px;
        }
        .welcome-banner {
            padding: 24px 28px;
        }
        .welcome-title {
            font-size: 24px;
        }
        .welcome-sub {
            font-size: 15px;
        }
        .stat-value {
            font-size: 26px;
        }
        .profit-card .profit-value {
            font-size: 26px;
        }
        .chart-container {
            height: 220px;
        }
        .chart-container-sm {
            height: 170px;
        }
        .panel-title {
            font-size: 16px;
        }
    }

    @media (max-width: 576px) {
        .stat-card {
            padding: 18px 20px;
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            font-size: 18px;
        }
        .stat-value {
            font-size: 22px;
        }
        .panel-body {
            padding: 16px;
        }
        .quick-action {
            padding: 14px 12px;
        }
        .quick-action i {
            font-size: 22px;
        }
        .quick-action span {
            font-size: 13px;
        }
        .profit-card .profit-value {
            font-size: 22px;
        }
        .welcome-title {
            font-size: 20px;
        }
    }

    /* ===== UTILITY ===== */
    .text-gold { color: var(--gold); }
    .bg-gold-light { background: #F6EFD9; }
    .border-gold { border-color: var(--gold) !important; }
    .fs-large { font-size: 18px; }
    .fw-700 { font-weight: 700; }
    .fw-800 { font-weight: 800; }
</style>

<div class="dashboard-wrapper">

    <!-- ===== WELCOME BANNER ===== -->
    <div class="welcome-banner">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-spa text-gold" style="font-size: 20px;"></i>
                    <small class="text-uppercase fw-semibold" style="opacity:0.7; letter-spacing:1.5px; font-size: 13px;">YSP Jasmine</small>
                </div>
                <?php
                    $jam = (int) date('G');
                    if ($jam >= 5 && $jam < 11)       { $ucapan = 'Selamat Pagi'; }
                    elseif ($jam >= 11 && $jam < 15)  { $ucapan = 'Selamat Siang'; }
                    elseif ($jam >= 15 && $jam < 18)  { $ucapan = 'Selamat Sore'; }
                    else                              { $ucapan = 'Selamat Malam'; }
                ?>
                <h1 class="welcome-title"><?= $ucapan ?>, Admin!</h1>
                <p class="welcome-sub">Kelola bisnis Anda dengan mudah. Pantau performa toko dalam satu dashboard.</p>
                <div class="welcome-stats">
                <div class="welcome-stat-item">
    <small>Hari Ini</small>
    <strong>
        <?php
        $namaBulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        echo date('d') . ' ' . $namaBulan[(int)date('m')] . ' ' . date('Y');
        ?>
    </strong>
</div>
                    <div class="welcome-stat-item">
                        <small>Jam</small>
                        <strong id="realtimeClock">--:--</strong>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-end">
            <div class="bg-white bg-opacity-10 rounded-3 p-4 d-inline-block">
    <?php
    $namaBulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    ?>
    <div style="font-size: 40px; font-weight: 800;"><?= date('d') ?></div>
    <div style="font-size: 15px; opacity:0.7; font-weight: 500;">
        <?= $namaBulan[(int)date('m')] . ' ' . date('Y') ?>
    </div>
</div>
            </div>
        </div>
    </div>

    <!-- ===== PROFIT CARDS ===== -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="profit-card green">
                <div class="profit-label"><i class="fas fa-coins me-1"></i> Laba Bulan Ini</div>
                <div class="profit-value">Rp <?= number_format($labaBulanIni, 0, ',', '.') ?></div>
                <div class="profit-detail">Pendapatan Rp <?= number_format($pendapatanBulanIni, 0, ',', '.') ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="profit-card gold">
                <div class="profit-label"><i class="fas fa-receipt me-1"></i> Transaksi Bulan Ini</div>
                <div class="profit-value"><?= number_format($transaksiBulanIni) ?></div>
                <div class="profit-detail">Pesanan selesai</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="profit-card blue">
                <div class="profit-label"><i class="fas fa-boxes me-1"></i> Total Stok</div>
                <div class="profit-value"><?= number_format($totalStokTersedia) ?></div>
                <div class="profit-detail">Siap dijual</div>
            </div>
        </div>
    </div>

    <!-- ===== STATISTIC CARDS ===== -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/barang') ?>" class="stat-card">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="stat-label">Total Produk</div>
                        <div class="stat-value"><?= number_format($totalBarang) ?></div>
                    </div>
                    <div class="stat-icon green"><i class="fas fa-box"></i></div>
                </div>
                <div class="mt-2">
                    <span class="stat-trend"><i class="fas fa-check-circle me-1"></i> Aktif</span>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/pelanggan') ?>" class="stat-card">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="stat-label">Pelanggan</div>
                        <div class="stat-value"><?= number_format($totalPelanggan) ?></div>
                    </div>
                    <div class="stat-icon gold"><i class="fas fa-users"></i></div>
                </div>
                <div class="mt-2">
                    <span class="stat-trend"><i class="fas fa-user-plus me-1"></i> Bertumbuh</span>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/transaksi') ?>" class="stat-card">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="stat-label">Total Transaksi</div>
                        <div class="stat-value"><?= number_format($totalTransaksi) ?></div>
                    </div>
                    <div class="stat-icon blue"><i class="fas fa-receipt"></i></div>
                </div>
                <div class="mt-2">
                    <span class="stat-trend"><i class="fas fa-chart-line me-1"></i> +12%</span>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="<?= base_url('admin/transaksi') ?>" class="stat-card">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="stat-label">Item Terjual</div>
                        <div class="stat-value"><?= number_format($totalDetail) ?></div>
                    </div>
                    <div class="stat-icon orange"><i class="fas fa-shopping-bag"></i></div>
                </div>
                <div class="mt-2">
                    <span class="stat-trend"><i class="fas fa-fire me-1"></i> Laris</span>
                </div>
            </a>
        </div>
    </div>

    <!-- ===== QUICK ACTIONS ===== -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="panel-card">
                <div class="panel-header">
                    <h6 class="panel-title"><i class="fas fa-bolt"></i> Aksi Cepat</h6>
                    <span class="panel-badge">Shortcut</span>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <a href="<?= base_url('admin/barang') ?>" class="quick-action">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Barang</span>
                                <small>Produk baru</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= base_url('admin/transaksi') ?>" class="quick-action">
                                <i class="fas fa-eye"></i>
                                <span>Lihat Transaksi</span>
                                <small>Monitoring</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= base_url('admin/laporan/transaksi') ?>" class="quick-action">
                                <i class="fas fa-file-invoice"></i>
                                <span>Laporan</span>
                                <small>Export PDF</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= base_url('admin/ulasan') ?>" class="quick-action">
                                <i class="fas fa-star"></i>
                                <span>Ulasan</span>
                                <small>Moderasi</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CHARTS SECTION ===== -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4">
            <div class="panel-card">
                <div class="panel-header">
                    <h6 class="panel-title"><i class="fas fa-calendar-day"></i> Penjualan Harian</h6>
                    <span class="panel-badge">7 Hari</span>
                </div>
                <div class="panel-body">
                    <div class="chart-container chart-container-sm">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="panel-card">
                <div class="panel-header">
                    <h6 class="panel-title"><i class="fas fa-calendar-alt"></i> Penjualan Bulanan</h6>
                    <span class="panel-badge">6 Bulan</span>
                </div>
                <div class="panel-body">
                    <div class="chart-container chart-container-sm">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="panel-card">
                <div class="panel-header">
                    <h6 class="panel-title"><i class="fas fa-coins"></i> Laba Bulanan</h6>
                    <span class="panel-badge">6 Bulan</span>
                </div>
                <div class="panel-body">
                    <div class="chart-container chart-container-sm">
                        <canvas id="profitChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== PENDAPATAN ===== -->
    <div class="row g-3">
        <div class="col-xl-5">
            <div class="panel-card">
                <div class="panel-header">
                    <h6 class="panel-title"><i class="fas fa-chart-line"></i> Pendapatan Tahunan</h6>
                    <span class="panel-badge"><?= date('Y') ?></span>
                </div>
                <div class="panel-body">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
    <div class="panel-card">
        <div class="panel-header">
            <h6 class="panel-title"><i class="fas fa-crown"></i> Produk Terlaris</h6>
            <span class="panel-badge">Top 5</span>
        </div>
        <div class="panel-body">
            <?php if (empty($produkTerlaris)) : ?>
                <div class="empty-state">
                    <i class="fas fa-shopping-bag"></i>
                    <h6>Belum Ada Penjualan</h6>
                    <p>Produk terlaris akan muncul setelah ada transaksi.</p>
                </div>
            <?php else : ?>
                <?php foreach ($produkTerlaris as $index => $produk) : ?>
                    <div class="product-rank">
                        <div class="rank-number <?= $index < 3 ? 'gold' : '' ?>">
                            <?= $index + 1 ?>
                        </div>
                        <div class="flex-grow-1">
                            <div class="product-rank-name"><?= esc($produk['nama_barang'] ?? 'Produk #' . $produk['id']) ?></div>
                            <div class="product-rank-meta">
                                <i class="fas fa-tag me-1"></i>
                                <?= number_format($produk['harga_jual'] ?? 0, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="product-rank-sales">
                            <i class="fas fa-shopping-bag me-1"></i>
                            <?= number_format($produk['total_terjual'] ?? 0) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
    

        <!-- ===== PERINGATAN STOK (LIMIT 3) ===== -->
<div class="col-xl-3">
    <div class="panel-card">
        <div class="panel-header">
            <h6 class="panel-title"><i class="fas fa-exclamation-triangle"></i> Peringatan Stok</h6>
            <?php if (!empty($stokRendah)) : ?>
                <span class="panel-badge" style="background:#fce4ec; color:#c62828; font-size: 14px; font-weight: 700;">
                    <?= count($stokRendah) ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="panel-body">
            <?php if (empty($stokRendah)) : ?>
                <div class="empty-state">
                    <i class="fas fa-check-circle" style="color: var(--secondary-green);"></i>
                    <h6>Stok Aman!</h6>
                    <p>Tidak ada produk dengan stok ≤ 3 unit.</p>
                </div>
            <?php else : ?>
                <?php foreach ($stokRendah as $s) : ?>
                    <div class="stock-item">
                        <div>
                            <div class="stock-name"><?= esc($s['nama_barang']) ?></div>
                            <div class="stock-category">
                                <?php if ($s['stok'] <= 0) : ?>
                                    <span class="text-danger fw-bold">❌ STOK HABIS</span>
                                <?php elseif ($s['stok'] <= 3) : ?>
                                    <span class="text-warning fw-bold">⚠️ STOK MENIPIS (≤3)</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <span class="stock-badge <?= ($s['stok'] <= 0) ? 'danger' : 'warning' ?>">
                            <?= number_format($s['stok']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
                <a href="<?= base_url('admin/barang') ?>" class="btn btn-outline-success btn-sm w-100 mt-3" style="font-size: 14px; font-weight: 600; padding: 10px;">
                    <i class="fas fa-box me-1"></i> Kelola Produk
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>



</div>

<!-- ===== SCRIPTS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
(function() {
    'use strict';

    // ===== CLOCK =====
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const el = document.getElementById('realtimeClock');
        if (el) el.textContent = h + ':' + m;
    }
    updateClock();
    setInterval(updateClock, 10000);

    // ===== CHART HELPER =====
    function createChart(id, labels, data, color, isCurrency = true) {
        const ctx = document.getElementById(id);
        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: color + '80',
                    borderColor: color,
                    borderWidth: 1.5,
                    borderRadius: 6,
                    barPercentage: 0.7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.85)',
                        padding: 12,
                        cornerRadius: 10,
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 14, weight: '700' },
                        callbacks: {
                            label: function(ctx) {
                                let val = ctx.raw;
                                return isCurrency ? 'Rp ' + val.toLocaleString('id-ID') : val.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { 
                            font: { size: 11, weight: '500' }, 
                            maxRotation: 30 
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            font: { size: 11, weight: '500' },
                            callback: function(val) {
                                if (isCurrency && val >= 1000000) return 'Rp' + (val/1000000).toFixed(1) + 'jt';
                                if (isCurrency && val >= 1000) return 'Rp' + (val/1000).toFixed(0) + 'rb';
                                return val.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    // ===== RENDER CHARTS =====
    const dailyLabels = <?= $labelsHarian ?>;
    const dailyData = <?= $penjualanHarian ?>;
    createChart('dailyChart', dailyLabels, dailyData, '#1F5C46', true);

    const monthlyLabels = <?= $labelsBulanan ?>;
    const monthlyData = <?= $penjualanBulanan ?>;
    createChart('monthlyChart', monthlyLabels, monthlyData, '#B8963E', true);

    const profitLabels = <?= $labelsLaba ?>;
    const profitData = <?= $labaBulanan ?>;
    createChart('profitChart', profitLabels, profitData, '#8A6D2B', true);

    // ===== REVENUE CHART (LINE) =====
    const revenueData = <?= $grafikData ?>;
    const months = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nov","Des"];
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const grad = ctx.createLinearGradient(0, 0, 0, 280);
    grad.addColorStop(0, 'rgba(31,92,70,0.25)');
    grad.addColorStop(0.5, 'rgba(31,92,70,0.08)');
    grad.addColorStop(1, 'rgba(31,92,70,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                data: revenueData,
                fill: true,
                backgroundColor: grad,
                borderColor: '#1F5C46',
                borderWidth: 3,
                pointBackgroundColor: '#B8963E',
                pointBorderColor: '#fff',
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 8,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    padding: 14,
                    cornerRadius: 10,
                    titleFont: { size: 13, weight: '600' },
                    bodyFont: { size: 15, weight: '700' },
                    callbacks: {
                        label: function(ctx) {
                            return 'Rp ' + ctx.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { 
                        font: { size: 12, weight: '500' } 
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        font: { size: 12, weight: '500' },
                        callback: function(val) {
                            if (val >= 1000000) return 'Rp' + (val/1000000).toFixed(1) + 'jt';
                            if (val >= 1000) return 'Rp' + (val/1000).toFixed(0) + 'rb';
                            return 'Rp' + val.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

})();
</script>

<?= $this->endSection() ?>