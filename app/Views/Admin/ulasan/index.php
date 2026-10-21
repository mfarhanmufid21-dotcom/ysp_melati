<?= $this->extend('Admin/layout/admin') ?>
<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h4 class="fw-bold"><i class="fas fa-star me-2" style="color: var(--gold);"></i> Kelola Ulasan Pelanggan</h4>
            <p class="text-muted">Kelola dan moderasi ulasan pelanggan</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #EAF3EE;">
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Pelanggan</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ulasan)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-star fa-2x text-muted mb-2 d-block"></i>
                                    Belum ada ulasan pelanggan
                                 </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($ulasan as $u): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($u['nama_barang'] ?? '-') ?></td>
                                <td><?= esc($u['nama_pelanggan'] ?? $u['username'] ?? '-') ?></td>
                                <td>
                                    <div class="text-warning"><?= str_repeat('⭐', (int)($u['rating'] ?? 0)) ?></div>
                                    <small><?= ($u['rating'] ?? 0) ?>/5</small>
                                </td>
                                <td style="max-width: 250px;">
                                    <strong><?= esc($u['komentar'] ?? '') ?></strong>
                                    <?php if (!empty($u['balasan'])): ?>
                                        <div class="mt-2 pt-2 border-top">
                                            <small class="text-success"><i class="fas fa-reply me-1"></i> Balasan Admin:</small><br>
                                            <small><?= esc($u['balasan']) ?></small>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <select class="form-select form-select-sm status-select" data-id="<?= $u['id'] ?>" style="width: 130px;">
                                        <option value="pending" <?= ($u['status'] ?? 'pending') == 'pending' ? 'selected' : '' ?>>⏳ Pending</option>
                                        <option value="approved" <?= ($u['status'] ?? '') == 'approved' ? 'selected' : '' ?>>✅ Disetujui</option>
                                        <option value="rejected" <?= ($u['status'] ?? '') == 'rejected' ? 'selected' : '' ?>>❌ Ditolak</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success balas-btn mb-1" data-id="<?= $u['id'] ?>" data-balasan="<?= esc($u['balasan'] ?? '') ?>">
                                        <i class="fas fa-reply me-1"></i> Balas
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger hapus-btn" data-id="<?= $u['id'] ?>">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.status-select').forEach(function(select) {
    select.addEventListener('change', async function() {
        var id = this.dataset.id;
        var status = this.value;
        
        try {
            var response = await fetch('<?= base_url("admin/ulasan/update-status") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({id: id, status: status})
            });
            var data = await response.json();
            if (data.success) {
                Swal.fire('Berhasil', data.message, 'success');
            } else {
                Swal.fire('Gagal', data.message || 'Terjadi kesalahan', 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Gagal menghubungi server', 'error');
        }
    });
});

document.querySelectorAll('.balas-btn').forEach(function(btn) {
    btn.addEventListener('click', async function() {
        var currentBalasan = this.dataset.balasan || '';
        
        var result = await Swal.fire({
            title: 'Balas Ulasan',
            input: 'textarea',
            inputLabel: 'Tulis balasan untuk pelanggan',
            inputValue: currentBalasan,
            inputPlaceholder: 'Terima kasih atas ulasannya...',
            showCancelButton: true,
            confirmButtonText: 'Kirim Balasan',
            cancelButtonText: 'Batal'
        });
        
        if (result.value !== undefined) {
            try {
                var response = await fetch('<?= base_url("admin/ulasan/balas") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({id: this.dataset.id, balasan: result.value})
                });
                var data = await response.json();
                if (data.success) {
                    Swal.fire('Berhasil', data.message, 'success').then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal', data.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Gagal menghubungi server', 'error');
            }
        }
    });
});

document.querySelectorAll('.hapus-btn').forEach(function(btn) {
    btn.addEventListener('click', async function() {
        var id = this.dataset.id;
        
        var result = await Swal.fire({
            title: 'Hapus Ulasan?',
            text: 'Ulasan yang dihapus tidak dapat dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        });
        
        if (result.isConfirmed) {
            try {
                var response = await fetch('<?= base_url("admin/ulasan/hapus") ?>/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                var data = await response.json();
                if (data.success) {
                    Swal.fire('Terhapus!', data.message, 'success').then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                Swal.fire('Error!', 'Gagal menghubungi server', 'error');
            }
        }
    });
});
</script>

<?= $this->endSection() ?>