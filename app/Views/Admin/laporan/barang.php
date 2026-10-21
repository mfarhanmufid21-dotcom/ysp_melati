<?= $this->extend('Admin/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h4 class="fw-bold"><i class="fas fa-boxes me-2" style="color: var(--gold);"></i> Laporan Stok Barang</h4>
            <p class="text-muted">Pantau stok barang yang tersedia</p>
            <a href="<?= base_url('admin/laporan/cetakpdf_barang') ?>" 
       class="btn btn-danger" style="border-radius: 12px;" target="_blank">
        <i class="fas fa-file-pdf me-2"></i> Download PDF Laporan
    </a>
        </div>
    </div>

    <!-- Statistik Stok -->
    <div class="row mt-4 g-4">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="fas fa-box fa-2x text-danger"></i>
                    </div>
                    <h2 class="fw-bold mb-0"><?= $stok_habis ?? 0 ?></h2>
                    <p class="text-muted mb-0">Stok Habis</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                    <h2 class="fw-bold mb-0"><?= $stok_menipis ?? 0 ?></h2>
                    <p class="text-muted mb-0">Stok Menipis (≤ 10)</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="fas fa-warehouse fa-2x text-success"></i>
                    </div>
                    <h2 class="fw-bold mb-0"><?= $total_barang ?? 0 ?></h2>
                    <p class="text-muted mb-0">Total Produk</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Stok Barang -->
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #EAF3EE;">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Gambar</th>
                            <th class="p-3">Nama Produk</th>
                            <th class="p-3">Harga</th>
                            <th class="p-3">Stok</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($barang)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($barang as $b): ?>
                                <tr>
                                    <td class="p-3"><?= $no++ ?></td>
                                    <td class="p-3">
                                        <img src="<?= base_url('uploads/' . ($b['gambar'] ?? 'default.png')) ?>" 
                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;"
                                             onerror="this.src='<?= base_url('uploads/default.png') ?>'">
                                    </td>
                                    <td class="p-3"><?= esc($b['nama_barang']) ?></td>
                                    <td class="p-3">Rp <?= number_format($b['harga'], 0, ',', '.') ?></td>
                                    <td class="p-3 fw-bold <?= $b['stok'] <= 0 ? 'text-danger' : ($b['stok'] <= 10 ? 'text-warning' : 'text-success') ?>">
                                        <?= $b['stok'] ?> unit
                                    </td>
                                    <td class="p-3">
                                        <?php if ($b['stok'] <= 0): ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php elseif ($b['stok'] <= 10): ?>
                                            <span class="badge bg-warning text-dark">Menipis</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Tersedia</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-box-open fa-2x text-muted mb-2 d-block"></i>
                                    Belum ada produk
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>