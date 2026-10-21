<?= $this->extend('Admin/layout/admin') ?>
<?= $this->section('content') ?>

<style>
    /* ===== DETAIL TRANSACTION STYLES ===== */
    :root {
        --gold: #B8963E;
        --gold-light: #D4B766;
        --gold-pale: #F3ECD9;
        --green-deep: #164534;
        --green-mid: #1F5C46;
        --green-pale: #EAF3EE;
        --cream: #F7F5F0;
        --white: #FFFFFF;
        --radius-card: 20px;
        --radius-pill: 50px;
        --transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
    }

    .page-header {
        background: linear-gradient(135deg, var(--green-deep) 0%, var(--green-mid) 100%);
        border-radius: 24px;
        padding: 28px 32px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '🧾';
        position: absolute;
        top: -30px;
        right: -20px;
        font-size: 120px;
        opacity: 0.06;
    }
    
    .page-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 500;
        color: white;
        margin-bottom: 8px;
    }
    
    .page-subtitle {
        color: rgba(255,255,255,0.7);
        font-size: 0.9rem;
    }

    .info-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .info-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--green-deep);
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--gold-pale);
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }
    
    .info-label {
        width: 140px;
        font-weight: 600;
        color: var(--text-mid);
    }
    
    .info-value {
        flex: 1;
        color: var(--text-dark);
    }
    
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-pending { background: rgba(245,166,35,0.1); color: #F5A623; }
    .badge-diproses { background: rgba(67,97,238,0.1); color: #4361EE; }
    .badge-dikirim { background: rgba(6,194,112,0.1); color: #06C270; }
    .badge-selesai { background: rgba(6,194,112,0.15); color: #059669; }
    
    .table-detail {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-detail thead th {
        background: var(--green-pale);
        color: var(--green-deep);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
    }
    
    .table-detail tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0,0,0,0.04);
    }
    
    .table-detail tbody tr:hover {
        background: var(--green-pale);
    }
    
    .total-row {
        background: var(--cream);
        font-weight: bold;
    }
    
    .btn-back {
        background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
        border: none;
        border-radius: 12px;
        padding: 10px 28px;
        color: white;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22,69,52,0.2);
        color: white;
    }
    
    .btn-print {
        background: transparent;
        border: 1.5px solid var(--green-mid);
        border-radius: 12px;
        padding: 10px 28px;
        color: var(--green-mid);
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-print:hover {
        background: var(--green-mid);
        color: white;
    }
    
    @media (max-width: 768px) {
        .info-row {
            flex-direction: column;
        }
        .info-label {
            width: 100%;
            margin-bottom: 4px;
        }
        .table-detail {
            font-size: 0.8rem;
        }
        .page-header {
            padding: 20px 24px;
        }
        .page-title {
            font-size: 1.4rem;
        }
    }
</style>

<div class="detail-transaksi">
    
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Transaksi</h1>
            <p class="page-subtitle">Informasi lengkap pesanan pelanggan</p>
        </div>
    </div>
    
    <!-- Info Cards -->
    <div class="row g-4">
        <!-- Info Pelanggan -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="info-title">
                    <i class="fas fa-user me-2" style="color: var(--gold);"></i> Data Pelanggan
                </h5>
                <div class="info-row">
                    <div class="info-label">Nama Pelanggan</div>
                    <div class="info-value">: <?= esc($transaksi['nama_pelanggan'] ?? '-') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">: <?= esc($transaksi['alamat'] ?? '-') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Telepon</div>
                    <div class="info-value">: <?= esc($transaksi['telepon'] ?? '-') ?></div>
                </div>
            </div>
        </div>
        
        <!-- Info Transaksi -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="info-title">
                    <i class="fas fa-receipt me-2" style="color: var(--gold);"></i> Informasi Transaksi
                </h5>
                <div class="info-row">
                    <div class="info-label">Invoice</div>
                    <div class="info-value">: #INV-<?= str_pad($transaksi['id'], 6, '0', STR_PAD_LEFT) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Transaksi</div>
                    <div class="info-value">: <?= date('d F Y, H:i', strtotime($transaksi['tanggal'] ?? $transaksi['created_at'] ?? 'now')) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status Pesanan</div>
                    <div class="info-value">
                        <?php
                        $status = strtolower($transaksi['status'] ?? 'pending');
                        $badgeClass = 'badge-pending';
                        $statusText = 'Pending';
                        if ($status == 'diproses') { $badgeClass = 'badge-diproses'; $statusText = 'Diproses'; }
                        elseif ($status == 'dikirim') { $badgeClass = 'badge-dikirim'; $statusText = 'Dikirim'; }
                        elseif ($status == 'selesai') { $badgeClass = 'badge-selesai'; $statusText = 'Selesai'; }
                        ?>
                        <span class="badge-status <?= $badgeClass ?>">
                            <i class="fas <?= $status == 'pending' ? 'fa-clock' : ($status == 'dikirim' ? 'fa-truck' : 'fa-check-circle') ?> me-1"></i>
                            <?= $statusText ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Metode Pengiriman</div>
                    <div class="info-value">: <?= ($transaksi['metode_pengiriman'] ?? 'ambil') == 'delivery' ? '🚚 Delivery' : '📦 Ambil di Toko' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Metode Pembayaran</div>
                    <div class="info-value">: <?= strtoupper($transaksi['metode_pembayaran'] ?? 'COD') ?></div>
                </div>
                <?php if (!empty($transaksi['alamat_tujuan'])): ?>
                <div class="info-row">
                    <div class="info-label">Alamat Tujuan</div>
                    <div class="info-value">: <?= esc($transaksi['alamat_tujuan']) ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Detail Produk -->
    <div class="info-card">
        <h5 class="info-title">
            <i class="fas fa-box me-2" style="color: var(--gold);"></i> Detail Produk
        </h5>
        
        <div class="table-responsive">
            <table class="table-detail">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Produk</th>
                        <th style="width: 150px;">Harga</th>
                        <th style="width: 80px;">Jumlah</th>
                        <th style="width: 150px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($detail)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($detail as $d): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($d['nama_barang']) ?></td>
                                <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                                <td class="text-center"><?= $d['jumlah'] ?></td>
                                <td>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-box-open me-2"></i> Tidak ada detail produk
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4" class="text-end fw-bold">Subtotal</td>
                        <td class="fw-bold">Rp <?= number_format($transaksi['total'] ?? 0, 0, ',', '.') ?></td>
                    </tr>
                    <?php if (!empty($transaksi['ongkir'])): ?>
                    <tr>
                        <td colspan="4" class="text-end">Ongkos Kirim</td>
                        <td>Rp <?= number_format($transaksi['ongkir'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="total-row" style="background: var(--gold-pale);">
                        <td colspan="4" class="text-end fw-bold">Total Bayar</td>
                        <td class="fw-bold text-success" style="font-size: 1.1rem;">
                            Rp <?= number_format($transaksi['total_akhir'] ?? $transaksi['total'] ?? 0, 0, ',', '.') ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="d-flex justify-content-between gap-3 mt-4 flex-wrap">
        <a href="<?= base_url('admin/transaksi') ?>" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
        <div class="d-flex gap-3">
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print me-2"></i> Cetak
            </button>
            <?php if (!empty($transaksi['telepon'])): ?>
            <a href="https://wa.me/<?= $transaksi['telepon'] ?>?text=Halo%20<?= urlencode($transaksi['nama_pelanggan'] ?? '') ?>%2C%20pesanan%20Anda%20sedang%20<?= $statusText ?>" 
               target="_blank" class="btn-print" style="background: #25D366; border-color: #25D366; color: white;">
                <i class="fab fa-whatsapp me-2"></i> Hubungi
            </a>
            <?php endif; ?>
        </div>
    </div>
    
</div>

<?= $this->endSection() ?>