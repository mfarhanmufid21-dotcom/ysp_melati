<?= $this->extend('Admin/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold"><i class="fas fa-file-invoice me-2" style="color: var(--gold);"></i> Laporan Transaksi</h4>
                    <p class="text-muted">Filter laporan transaksi berdasarkan periode tanggal</p>
                </div>
                <a href="<?= base_url('admin/laporan/cetakpdf_transaksi') . (!empty($start_date) ? '?start_date=' . $start_date . '&end_date=' . $end_date : '') ?>" 
                   class="btn btn-danger" style="border-radius: 12px;" target="_blank">
                    <i class="fas fa-file-pdf me-2"></i> Download PDF Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body p-4">
            <form method="GET" action="<?= base_url('admin/laporan/transaksi') ?>" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="<?= $start_date ?? '' ?>" style="border-radius: 12px;">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="<?= $end_date ?? '' ?>" style="border-radius: 12px;">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100" style="border-radius: 12px; background: #164534;">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #EAF3EE;">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Invoice</th>
                            <th class="p-3">Pelanggan</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($transaksi as $t): ?>
                                <tr>
                                    <td class="p-3"><?= $no++ ?></td>
                                    <td class="p-3">#INV-<?= $t['id'] ?></td>
                                    <td class="p-3"><?= esc($t['nama_pelanggan'] ?? '-') ?></td>
                                    <td class="p-3"><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                                    <td class="p-3 fw-bold text-success">Rp <?= number_format($t['total_akhir'] ?? $t['total'], 0, ',', '.') ?></td>
                                    <td class="p-3">
                                        <span class="badge bg-<?= $t['status'] == 'Selesai' ? 'success' : ($t['status'] == 'Pending' ? 'warning' : 'info') ?>">
                                            <?= $t['status'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                    Belum ada transaksi
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