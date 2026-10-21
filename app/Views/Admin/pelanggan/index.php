<?= $this->extend('Admin/layout/admin') ?>
<?= $this->section('content') ?>

<style>
    /* ===== YSP JASMINE PELANGGAN STYLES ===== */
    :root {
        --gold: #B8963E;
        --gold-light: #D4B766;
        --gold-pale: #F3ECD9;
        --green-deep: #164534;
        --green-mid: #1F5C46;
        --green-pale: #EAF3EE;
        --cream: #F7F5F0;
        --white: #FFFFFF;
        --gray-50: #F7F5F0;
        --gray-100: #F1EFE9;
        --gray-200: #E9E7E2;
        --gray-500: #ADB5BD;
        --gray-600: #6D6D6D;
        --gray-700: #495057;
        --gray-800: #343A40;
        --gray-900: #212529;
        --radius: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --transition: all 0.3s ease;
    }

    /* ===== PAGE HEADER ===== */
    .page-header {
        background: linear-gradient(135deg, var(--green-deep) 0%, var(--green-mid) 100%);
        border-radius: var(--radius-xl);
        padding: 28px 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '👥';
        position: absolute;
        top: -30px;
        right: -10px;
        font-size: 130px;
        opacity: 0.06;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
    }

    .page-subtitle {
        color: rgba(255,255,255,0.7);
        font-size: 14px;
        margin-bottom: 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-export {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: var(--radius);
        padding: 10px 20px;
        color: white;
        font-weight: 500;
        font-size: 14px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-export:hover {
        background: rgba(255,255,255,0.2);
        color: white;
        transform: translateY(-2px);
    }

    .btn-export i {
        font-size: 16px;
    }

    /* ===== STATISTIC CARDS ===== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 20px 24px;
        border: 1px solid var(--gray-200);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border-color: var(--gold);
    }

    .stat-number {
        font-size: 28px;
        font-weight: 800;
        color: var(--green-deep);
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .stat-number .trend {
        font-size: 13px;
        font-weight: 600;
        color: var(--green-mid);
        background: var(--green-pale);
        padding: 2px 10px;
        border-radius: 20px;
        margin-left: 8px;
        display: inline-block;
        vertical-align: middle;
    }

    .stat-label {
        font-size: 13px;
        color: var(--gray-600);
        margin-top: 4px;
        font-weight: 500;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon.green { background: var(--green-pale); color: var(--green-mid); }
    .stat-icon.gold { background: var(--gold-pale); color: var(--gold); }
    .stat-icon.blue { background: #E3F2FD; color: #1976D2; }

    /* ===== DATA CARD ===== */
    .data-card {
        background: white;
        border-radius: var(--radius-xl);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .card-toolbar {
        padding: 16px 24px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        background: var(--gray-50);
    }

    .card-toolbar .info-text {
        font-size: 14px;
        color: var(--gray-600);
    }

    .card-toolbar .info-text strong {
        color: var(--gray-900);
    }

    /* ===== TABLE ===== */
    .table-custom {
        margin-bottom: 0;
    }

    .table-custom thead th {
        background: var(--gray-50);
        color: var(--gray-700);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .table-custom tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-100);
        font-size: 14px;
        color: var(--gray-800);
    }

    .table-custom tbody tr {
        transition: var(--transition);
    }

    .table-custom tbody tr:hover {
        background: var(--gray-50);
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== CUSTOMER AVATAR ===== */
    .customer-avatar {
        width: 42px;
        height: 42px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        color: white;
        flex-shrink: 0;
    }

    .customer-avatar.green { background: linear-gradient(135deg, var(--green-deep), var(--green-mid)); }
    .customer-avatar.gold { background: linear-gradient(135deg, var(--gold), var(--gold-light)); }
    .customer-avatar.blue { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .customer-avatar.purple { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .customer-avatar.orange { background: linear-gradient(135deg, #E65100, #FF9800); }
    .customer-avatar.teal { background: linear-gradient(135deg, #00695C, #26A69A); }

    .customer-name {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 14px;
    }

    .customer-email {
        font-size: 13px;
        color: var(--gray-500);
    }

    /* ===== WHATSAPP LINK ===== */
    .wa-link {
        color: #25D366;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .wa-link:hover {
        color: #128C7E;
        text-decoration: underline;
    }

    .wa-link i {
        font-size: 16px;
    }

    /* ===== BADGE ===== */
    .badge-status {
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-status.active {
        background: var(--green-pale);
        color: var(--green-mid);
    }

    .badge-status.inactive {
        background: #FCE4EC;
        color: #C62828;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: var(--gray-50);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .empty-state-icon i {
        font-size: 32px;
        color: var(--gray-400);
    }

    .empty-state h5 {
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 4px;
    }

    .empty-state p {
        color: var(--gray-500);
        font-size: 14px;
        margin-bottom: 0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .page-header {
            padding: 20px 24px;
        }
        .page-title {
            font-size: 20px;
        }
        .page-subtitle {
            font-size: 13px;
        }
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .stat-card {
            padding: 16px 20px;
        }
        .stat-number {
            font-size: 22px;
        }
        .card-toolbar {
            padding: 12px 16px;
            flex-direction: column;
            align-items: stretch;
        }
        .table-custom thead th {
            font-size: 10px;
            padding: 10px 12px;
        }
        .table-custom tbody td {
            padding: 10px 12px;
            font-size: 13px;
        }
        .header-actions {
            width: 100%;
        }
        .btn-export {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
        .customer-avatar {
            width: 36px;
            height: 36px;
            font-size: 13px;
        }
        .customer-name {
            font-size: 13px;
        }
        .customer-email {
            font-size: 12px;
        }
    }

    /* ===== UTILITY ===== */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }
    .fw-500 { font-weight: 500; }
    .fw-600 { font-weight: 600; }
    .fw-700 { font-weight: 700; }
</style>

<div class="pelanggan-management">

    <!-- ===== PAGE HEADER ===== -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-users me-2" style="color: var(--gold);"></i>
                    Data Pelanggan
                </h1>
                <p class="page-subtitle">
                    Kelola dan pantau semua data pelanggan YSP Jasmine
                </p>
            </div>
            <div class="col-md-4">
                <div class="header-actions">
                    <button class="btn-export" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn-export" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== STATISTIC CARDS ===== -->
    <div class="stats-row">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon green">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-number">
                    <?= count($pelanggan ?? []) ?>
                </div>
                <div class="stat-label">Total Pelanggan</div>
            </div>
        </div>

        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon gold">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <div class="stat-number">
                    <?php 
                    $aktif = 0;
                    foreach ($pelanggan as $p) {
                        if (!empty($p['telepon']) || !empty($p['alamat'])) $aktif++;
                    }
                    echo $aktif;
                    ?>
                    <span class="trend">
                        <i class="fas fa-check-circle"></i> Aktif
                    </span>
                </div>
                <div class="stat-label">Data Lengkap</div>
            </div>
        </div>

        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon blue">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div>
                <div class="stat-number">
                    <?php 
                    $thisMonth = 0;
                    foreach ($pelanggan as $p) {
                        if (isset($p['created_at']) && date('Y-m', strtotime($p['created_at'])) == date('Y-m')) $thisMonth++;
                    }
                    echo $thisMonth;
                    ?>
                    <span class="trend">
                        <i class="fas fa-calendar-alt"></i> Baru
                    </span>
                </div>
                <div class="stat-label">Bulan Ini</div>
            </div>
        </div>
    </div>

    <!-- ===== DATA TABLE ===== -->
    <div class="data-card">
        <div class="card-toolbar">
            <div class="info-text">
                <i class="fas fa-info-circle me-1" style="color: var(--gold);"></i>
                Menampilkan <strong><?= count($pelanggan ?? []) ?></strong> data pelanggan
            </div>
            <div class="d-flex gap-2">
                <div class="input-group" style="max-width: 250px;">
                    <span class="input-group-text bg-transparent border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="tableSearch" class="form-control form-control-sm border-0" placeholder="Cari pelanggan..." style="background: var(--gray-50);">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom" id="dataTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Pelanggan</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Tanggal Daftar</th>
                        <th style="width: 100px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pelanggan)): ?>
                        <?php $no = 1; ?>
                        <?php 
                        $colors = ['green', 'gold', 'blue', 'purple', 'orange', 'teal'];
                        $colorIndex = 0;
                        ?>
                        <?php foreach ($pelanggan as $p): ?>
                            <?php 
                            $initials = strtoupper(substr($p['nama'] ?? $p['username'] ?? 'U', 0, 1));
                            $colorClass = $colors[$colorIndex % count($colors)];
                            $colorIndex++;
                            ?>
                            <tr>
                                <td class="fw-bold text-muted"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="customer-avatar <?= $colorClass ?>">
                                            <?= $initials ?>
                                        </div>
                                        <div>
                                            <div class="customer-name">
                                                <?= esc($p['nama'] ?? $p['username'] ?? '-') ?>
                                            </div>
                                            <div class="customer-email">
                                                <i class="fas fa-envelope me-1"></i>
                                                <?= esc($p['email'] ?? '-') ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($p['telepon'])): ?>
                                        <a href="https://wa.me/<?= $p['telepon'] ?>" target="_blank" class="wa-link">
                                            <i class="fab fa-whatsapp"></i> <?= esc($p['telepon']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted small text-truncate-2" style="max-width: 180px; display: inline-block;">
                                        <i class="fas fa-map-pin me-1" style="color: var(--gold);"></i>
                                        <?= esc($p['alamat'] ?? '-') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?= !empty($p['created_at']) ? date('d M Y', strtotime($p['created_at'])) : '-' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status active">
                                        <i class="fas fa-circle" style="font-size: 6px;"></i> Terdaftar
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-users-slash"></i>
                                    </div>
                                    <h5>Belum Ada Pelanggan</h5>
                                    <p>Belum ada pelanggan yang terdaftar di sistem.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <?php if (!empty($pelanggan) && count($pelanggan) > 10): ?>
        <div class="card-toolbar border-top">
            <div class="info-text">
                Menampilkan <?= min(10, count($pelanggan)) ?> dari <?= count($pelanggan) ?> data
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <?php if (ceil(count($pelanggan) / 10) > 1): ?>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <?php endif; ?>
                    <?php if (ceil(count($pelanggan) / 10) > 2): ?>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>

</div>

<!-- ===== SCRIPTS ===== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ===== SEARCH FUNCTIONALITY =====
    const searchInput = document.getElementById('tableSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    }

    // ===== EXPORT TO EXCEL =====
    window.exportToExcel = function() {
        const table = document.getElementById('dataTable');
        const clone = table.cloneNode(true);
        // Remove thead from clone for cleaner export
        const rows = clone.querySelectorAll('tr');
        const data = [];
        
        // Get headers
        const headers = [];
        const headerCells = clone.querySelectorAll('thead th');
        headerCells.forEach(th => {
            headers.push(th.textContent.trim());
        });
        data.push(headers);
        
        // Get body data
        const bodyRows = clone.querySelectorAll('tbody tr');
        bodyRows.forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('td');
            cells.forEach(td => {
                // Clean up the text (remove icons, etc)
                let text = td.textContent.trim();
                // If it's the name column, try to get just the name
                if (td.querySelector('.customer-name')) {
                    text = td.querySelector('.customer-name').textContent.trim();
                }
                if (td.querySelector('.customer-email')) {
                    text += ' ' + td.querySelector('.customer-email').textContent.trim();
                }
                rowData.push(text);
            });
            if (rowData.length > 0) {
                data.push(rowData);
            }
        });

        // Create CSV
        let csv = '';
        data.forEach(row => {
            csv += row.join(',') + '\n';
        });

        // Download
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'data_pelanggan_ysp.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    };

    // ===== PRINT =====
    window.print = function() {
        window.print();
    };

});
</script>

<!-- ===== DATA TABLES CDN (Optional) ===== -->
<?php if (!empty($pelanggan) && count($pelanggan) > 20): ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Cari pelanggan...",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ pelanggan",
            infoEmpty: "Tidak ada data",
            paginate: {
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>'
            }
        },
        dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex gap-2"l><"d-flex"f>>rt<"d-flex justify-content-between align-items-center mt-3"<"d-flex"i><"d-flex"p>>',
        pageLength: 10,
        order: [[4, 'desc']]
    });
    
    // Custom styling for DataTables
    $('.dataTables_filter input').addClass('form-control form-control-sm rounded-pill px-4');
    $('.dataTables_filter input').attr('placeholder', 'Cari pelanggan...');
    $('.dataTables_length select').addClass('form-select form-select-sm rounded-pill');
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>