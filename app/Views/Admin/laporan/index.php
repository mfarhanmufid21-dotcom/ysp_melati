<?= $this->extend('Admin/layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2" style="color: var(--gold);"></i> Dashboard Laporan</h4>
                    <p class="text-muted mt-1">Ringkasan data penjualan dan statistik</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FORM FILTER & PDF -->
    <form action="<?= base_url('admin/laporan/cetakpdf_penjualan') ?>" method="GET" target="_blank" class="row g-3 mb-4 align-items-end" id="formLaporan">
        <div class="col-md-3">
            <label class="form-label small">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="<?= $start_date ?? '' ?>" id="start_date">
        </div>
        <div class="col-md-3">
            <label class="form-label small">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" value="<?= $end_date ?? '' ?>" id="end_date">
        </div>
        <div class="col-md-6 d-flex align-items-end gap-2">
            <button type="submit" formaction="<?= base_url('admin/laporan') ?>" class="btn btn-primary" id="btnFilter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="<?= base_url('admin/laporan') ?>" class="btn btn-secondary">Reset</a>
            
            <!-- Tombol PDF -->
            <button type="submit" class="btn btn-danger" style="border-radius: 12px;" id="btnPDF">
                <i class="fas fa-file-pdf me-2"></i> Download PDF
            </button>
        </div>
    </form>

    <!-- Statistik Cards -->
    <div class="row mt-4 g-4">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Total Transaksi</span>
                            <h2 class="mt-2 mb-0 fw-bold"><?= number_format($total_transaksi ?? 0) ?></h2>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-receipt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Total Pendapatan</span>
                            <h2 class="mt-2 mb-0 fw-bold">Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?></h2>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Total Pelanggan</span>
                            <h2 class="mt-2 mb-0 fw-bold"><?= number_format($total_pelanggan ?? 0) ?></h2>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold"><i class="fas fa-trophy me-2" style="color: var(--gold);"></i> Produk Terlaris</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Terjual</th>
                                    <th class="text-end">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($produk_terlaris)): ?>
                                    <?php foreach ($produk_terlaris as $p): ?>
                                        <tr>
                                            <td><?= esc($p['nama_barang']) ?></td>
                                            <td class="text-center"><?= $p['total_terjual'] ?> pcs</td>
                                            <td class="text-end">Rp <?= number_format($p['total_pendapatan'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold"><i class="fas fa-chart-line me-2" style="color: var(--gold);"></i> Menu Laporan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="list-group">
                        <a href="<?= base_url('admin/laporan/transaksi') ?>" class="list-group-item list-group-item-action border-0 rounded-3 mb-2">
                            <i class="fas fa-file-invoice me-3" style="color: var(--gold);"></i>
                            Laporan Transaksi
                            <small class="text-muted d-block mt-1">Lihat dan filter transaksi per periode</small>
                        </a>
                        <a href="<?= base_url('admin/laporan/barang') ?>" class="list-group-item list-group-item-action border-0 rounded-3">
                            <i class="fas fa-boxes me-3" style="color: var(--gold);"></i>
                            Laporan Stok Barang
                            <small class="text-muted d-block mt-1">Pantau stok barang yang tersedia</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tombol PDF - biarkan form submit ke URL yang sudah ditentukan
    // Tidak perlu preventDefault()
});
</script>

<?= $this->endSection() ?>