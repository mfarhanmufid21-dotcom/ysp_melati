<?= $this->extend('Admin/layout/admin') ?>
<?= $this->section('content') ?>

<style>
    /* ============================================================
       YSP JASMINE - TRANSACTION MANAGEMENT STYLES
       ============================================================ */
    
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
        --gray-300: #DEE2E6;
        --gray-400: #CED4DA;
        --gray-500: #ADB5BD;
        --gray-600: #6D6D6D;
        --gray-700: #495057;
        --gray-800: #343A40;
        --gray-900: #212529;
        --radius: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.06);
        --shadow-lg: 0 8px 32px rgba(0,0,0,0.08);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ============================================================
       PAGE HEADER
       ============================================================ */
    .page-header {
        background: linear-gradient(135deg, var(--green-deep) 0%, var(--green-mid) 100%);
        border-radius: var(--radius-xl);
        padding: 28px 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header::before {
        content: '📦';
        position: absolute;
        top: -40px;
        right: -20px;
        font-size: 150px;
        opacity: 0.05;
        pointer-events: none;
    }

    .page-header-left {
        position: relative;
        z-index: 1;
    }

    .page-header-left .badge-header {
        background: rgba(255,255,255,0.12);
        color: var(--gold-light);
        font-size: 11px;
        font-weight: 600;
        padding: 4px 14px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
        margin-bottom: 8px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
    }

    .page-title i {
        color: var(--gold);
        margin-right: 10px;
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
        position: relative;
        z-index: 1;
    }

    .btn-header {
        background: rgba(255,255,255,0.10);
        border: 1px solid rgba(255,255,255,0.15);
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
        backdrop-filter: blur(4px);
    }

    .btn-header:hover {
        background: rgba(255,255,255,0.20);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }

    .btn-header i {
        font-size: 16px;
    }

    /* ============================================================
       STATISTIC CARDS
       ============================================================ */
    .stats-grid {
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
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--gold);
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon-wrapper.green { background: var(--green-pale); color: var(--green-mid); }
    .stat-icon-wrapper.gold { background: var(--gold-pale); color: var(--gold); }
    .stat-icon-wrapper.blue { background: #E3F2FD; color: #1976D2; }
    .stat-icon-wrapper.orange { background: #FFF3E0; color: #E65100; }
    .stat-icon-wrapper.red { background: #FCE4EC; color: #C62828; }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--gray-900);
        line-height: 1.2;
        letter-spacing: -0.3px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--gray-600);
        font-weight: 500;
        margin-top: 2px;
    }

    /* ============================================================
       FILTER BAR
       ============================================================ */
    .filter-bar {
        background: white;
        border-radius: var(--radius-xl);
        padding: 16px 20px;
        margin-bottom: 24px;
        border: 1px solid var(--gray-200);
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
        box-shadow: var(--shadow-sm);
    }

    .filter-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group .form-control,
    .filter-group .form-select {
        border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        padding: 8px 14px;
        font-size: 14px;
        transition: var(--transition);
        background: white;
        min-height: 40px;
    }

    .filter-group .form-control:focus,
    .filter-group .form-select:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(184,150,62,0.12);
    }

    .filter-group .form-control::placeholder {
        color: var(--gray-400);
    }

    .filter-group .input-group-text {
        background: transparent;
        border: none;
        padding-right: 0;
        color: var(--gray-400);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    .btn-filter {
        padding: 8px 18px;
        border-radius: var(--radius);
        border: none;
        font-weight: 500;
        font-size: 13px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .btn-filter.primary {
        background: var(--green-deep);
        color: white;
    }

    .btn-filter.primary:hover {
        background: var(--green-mid);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22,69,52,0.2);
    }

    .btn-filter.outline {
        background: transparent;
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
    }

    .btn-filter.outline:hover {
        border-color: var(--gold);
        color: var(--gray-900);
    }

    /* ============================================================
       DATA TABLE
       ============================================================ */
    .table-container {
        background: white;
        border-radius: var(--radius-xl);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .table-toolbar {
        padding: 14px 20px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        background: var(--gray-50);
    }

    .table-toolbar .info-text {
        font-size: 14px;
        color: var(--gray-600);
    }

    .table-toolbar .info-text strong {
        color: var(--gray-900);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table-custom {
        margin-bottom: 0;
        width: 100%;
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

    .table-custom thead th:first-child {
        padding-left: 24px;
    }

    .table-custom thead th:last-child {
        padding-right: 24px;
    }

    .table-custom tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-100);
        font-size: 14px;
        color: var(--gray-800);
        background: white;
        transition: var(--transition);
    }

    .table-custom tbody td:first-child {
        padding-left: 24px;
    }

    .table-custom tbody td:last-child {
        padding-right: 24px;
    }

    .table-custom tbody tr {
        transition: var(--transition);
    }

    .table-custom tbody tr:hover {
        background: var(--cream);
    }

    .table-custom tbody tr:hover td {
        background: transparent;
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== INVOICE NUMBER ===== */
    .invoice-number {
        font-weight: 600;
        color: var(--green-deep);
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
    }

    .invoice-number:hover {
        color: var(--gold);
    }

    /* ===== CUSTOMER AVATAR ===== */
    .customer-avatar-sm {
        width: 34px;
        height: 34px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        color: white;
        flex-shrink: 0;
    }

    .customer-avatar-sm.green { background: linear-gradient(135deg, var(--green-deep), var(--green-mid)); }
    .customer-avatar-sm.gold { background: linear-gradient(135deg, var(--gold), var(--gold-light)); }
    .customer-avatar-sm.blue { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .customer-avatar-sm.purple { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .customer-avatar-sm.orange { background: linear-gradient(135deg, #E65100, #FF9800); }

    .customer-name-sm {
        font-weight: 500;
        font-size: 14px;
        color: var(--gray-900);
    }

    /* ===== STATUS BADGE ===== */
    .badge-status {
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        white-space: nowrap;
    }

    .badge-status.pending {
        background: #FFF3E0;
        color: #E65100;
    }

    .badge-status.diproses {
        background: #E3F2FD;
        color: #1565C0;
    }

    .badge-status.dikirim {
        background: #EAF3EE;
        color: #2E7D32;
    }

    .badge-status.selesai {
        background: var(--green-pale);
        color: var(--green-mid);
    }

    .badge-status.dibatalkan {
        background: #FCE4EC;
        color: #C62828;
    }

    .badge-status i {
        font-size: 6px;
    }

    /* ===== PAYMENT BADGE ===== */
    .badge-payment {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        transition: var(--transition);
    }

    .badge-payment:hover {
        transform: scale(1.04);
    }

    .badge-payment.pending {
        background: #FFF3E0;
        color: #E65100;
    }

    .badge-payment.menunggu_verifikasi {
        background: #E3F2FD;
        color: #1565C0;
    }

    .badge-payment.lunas {
        background: #EAF3EE;
        color: #2E7D32;
    }

    .badge-payment.gagal {
        background: #FCE4EC;
        color: #C62828;
    }

    /* ===== STATUS SELECT ===== */
    .status-select {
        border: 1px solid var(--gray-200);
        border-radius: 50px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 500;
        background: white;
        cursor: pointer;
        transition: var(--transition);
        min-width: 100px;
    }

    .status-select:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(184,150,62,0.12);
    }

    .status-select option.pending { color: #E65100; }
    .status-select option.diproses { color: #1565C0; }
    .status-select option.dikirim { color: #2E7D32; }
    .status-select option.selesai { color: var(--green-mid); }

    /* ===== ACTION BUTTON ===== */
    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: var(--radius);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        border: none;
        background: transparent;
        cursor: pointer;
    }

    .btn-action.view {
        background: rgba(31,92,70,0.08);
        color: var(--green-mid);
    }

    .btn-action.view:hover {
        background: var(--green-mid);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31,92,70,0.25);
    }

    /* ============================================================
       TABLE FOOTER / PAGINATION
       ============================================================ */
    .table-footer {
        padding: 14px 24px;
        border-top: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        background: var(--gray-50);
        border-radius: 0 0 var(--radius-xl) var(--radius-xl);
    }

    .table-footer .info-text {
        font-size: 13px;
        color: var(--gray-600);
    }

    .table-footer .info-text strong {
        color: var(--gray-900);
    }

    .pagination-custom {
        display: flex;
        gap: 4px;
        margin: 0;
        list-style: none;
        padding: 0;
    }

    .pagination-custom .page-item .page-link {
        border: none;
        padding: 6px 14px;
        border-radius: var(--radius-sm);
        color: var(--gray-600);
        font-weight: 500;
        font-size: 13px;
        transition: var(--transition);
        background: transparent;
        text-decoration: none;
        display: inline-block;
    }

    .pagination-custom .page-item .page-link:hover {
        background: var(--gray-100);
        color: var(--gray-900);
    }

    .pagination-custom .page-item.active .page-link {
        background: var(--green-deep);
        color: white;
        box-shadow: 0 2px 8px rgba(22,69,52,0.2);
    }

    .pagination-custom .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ============================================================
       EMPTY STATE
       ============================================================ */
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

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 992px) {
        .page-header {
            padding: 24px 28px;
        }
        .page-title {
            font-size: 22px;
        }
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 20px 24px;
            flex-direction: column;
            align-items: stretch;
        }
        .page-title {
            font-size: 20px;
        }
        .header-actions {
            width: 100%;
        }
        .btn-header {
            flex: 1;
            justify-content: center;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .stat-card {
            padding: 16px 20px;
        }
        .stat-value {
            font-size: 22px;
        }
        .filter-bar {
            padding: 14px 16px;
            flex-direction: column;
            align-items: stretch;
        }
        .filter-group {
            flex-direction: column;
            width: 100%;
        }
        .filter-group .form-control,
        .filter-group .form-select {
            width: 100% !important;
        }
        .filter-actions {
            width: 100%;
        }
        .filter-actions .btn-filter {
            flex: 1;
            justify-content: center;
        }
        .table-toolbar {
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
        .table-footer {
            padding: 12px 16px;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .page-header {
            padding: 16px 20px;
        }
        .page-title {
            font-size: 18px;
        }
        .table-custom thead {
            display: none;
        }
        .table-custom tbody tr {
            display: block;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            margin-bottom: 12px;
            padding: 12px;
        }
        .table-custom tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 4px;
            border-bottom: 1px solid var(--gray-100);
            font-size: 13px;
        }
        .table-custom tbody td:last-child {
            border-bottom: none;
        }
        .table-custom tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray-600);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            min-width: 80px;
        }
        .table-custom tbody tr:hover {
            background: transparent;
        }
    }

    /* ============================================================
       MODAL STYLES
       ============================================================ */
    .modal-content-custom {
        border-radius: var(--radius-xl);
        overflow: hidden;
        border: none;
        box-shadow: var(--shadow-lg);
    }

    .modal-header-custom {
        background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
        padding: 20px 28px;
        border: none;
    }

    .modal-header-custom .modal-title {
        color: white;
        font-weight: 600;
        font-size: 18px;
    }

    .modal-header-custom .modal-title i {
        color: var(--gold);
    }

    .modal-header-custom .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.7;
    }

    .modal-header-custom .btn-close:hover {
        opacity: 1;
    }

    .modal-body-custom {
        padding: 28px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-footer-custom {
        padding: 16px 28px;
        border-top: 1px solid var(--gray-100);
        gap: 10px;
    }

    /* ============================================================
       UTILITY
       ============================================================ */
    .text-gold { color: var(--gold); }
    .bg-gold-light { background: var(--gold-pale); }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }
    .fw-500 { font-weight: 500; }
    .fw-600 { font-weight: 600; }
    .fw-700 { font-weight: 700; }
    .fs-small { font-size: 13px; }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="transaction-management">

    <!-- ============================================================
    PAGE HEADER
    ============================================================ -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="badge-header">
                <i class="fas fa-credit-card me-1"></i> Management
            </div>
            <h1 class="page-title">
                <i class="fas fa-receipt"></i>
                Kelola Transaksi
            </h1>
            <p class="page-subtitle">
                Pantau dan kelola semua transaksi penjualan YSP Jasmine
            </p>
        </div>
        <div class="header-actions">
            <button class="btn-header" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
            <button class="btn-header" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <!-- ============================================================
    STATISTIC CARDS
    ============================================================ -->
    <div class="stats-grid" id="statsContainer">
        <div class="stat-card">
            <div class="stat-icon-wrapper green">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" id="totalTransaksi">0</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper gold">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" id="totalPendapatan">Rp 0</div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper blue">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" id="hariIni">0</div>
                <div class="stat-label">Pesanan Hari Ini</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" id="pesananPending">0</div>
                <div class="stat-label">Pending / Diproses</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" id="pesananSelesai">0</div>
                <div class="stat-label">Pesanan Selesai</div>
            </div>
        </div>
    </div>

    <!-- ============================================================
    FILTER BAR
    ============================================================ -->
    <div class="filter-bar">
        <div class="filter-group">
            <div class="input-group" style="width: 220px;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari pelanggan...">
            </div>
            <select id="statusFilter" class="form-select" style="width: 150px;">
                <option value="">Semua Status</option>
                <option value="Pending">🟡 Pending</option>
                <option value="Diproses">🔵 Diproses</option>
                <option value="Dikirim">🚚 Dikirim</option>
                <option value="Selesai">✅ Selesai</option>
            </select>
            <select id="paymentFilter" class="form-select" style="width: 160px;">
                <option value="">Semua Pembayaran</option>
                <option value="pending">Belum Bayar</option>
                <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                <option value="lunas">Lunas</option>
                <option value="gagal">Gagal</option>
            </select>
            <input type="date" id="dateFilter" class="form-control" style="width: 160px;">
        </div>
        <div class="filter-actions">
            <button class="btn-filter primary" onclick="applyFilters()">
                <i class="fas fa-filter"></i> Filter
            </button>
            <button class="btn-filter outline" onclick="resetFilters()">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
    </div>

    <!-- ============================================================
    DATA TABLE
    ============================================================ -->
    <div class="table-container">
        <div class="table-toolbar">
            <div class="info-text">
                <i class="fas fa-info-circle me-1" style="color: var(--gold);"></i>
                Menampilkan <strong id="totalDataDisplay">0</strong> data transaksi
            </div>
        </div>

        <div class="table-responsive">
            <table class="table-custom" id="transactionTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th style="width: 130px;">Tanggal</th>
                        <th style="width: 130px;">Total</th>
                        <th style="width: 140px;">Status</th>
                        <th style="width: 150px;">Pembayaran</th>
                        <th style="width: 60px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Data akan di-render oleh JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="table-footer" id="paginationContainer">
            <!-- Pagination akan di-render oleh JavaScript -->
        </div>
    </div>

</div>

<!-- ============================================================
MODAL DETAIL TRANSACTION
============================================================ -->
<div class="modal fade" id="detailModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-content-custom">
            <div class="modal-header-custom">
                <h5 class="modal-title">
                    <i class="fas fa-receipt me-2"></i>
                    Detail Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-custom" id="modalContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-gold" role="status"></div>
                    <p class="mt-2 text-muted">Memuat data transaksi...</p>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: var(--radius);">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
                <button type="button" class="btn btn-primary" id="printInvoiceBtn" style="border-radius: var(--radius); background: var(--green-deep); border: none;">
                    <i class="fas fa-print me-1"></i> Cetak Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
SCRIPTS
============================================================ -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ===== DATA =====
const initialData = <?= json_encode($transaksi ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

// ===== VARIABLES =====
let currentPage = 1;
let perPage = 10;
let searchQuery = '';
let statusFilter = '';
let paymentFilter = '';
let dateFilter = '';

// ===== FORMAT FUNCTIONS =====
function formatNumber(value) {
    return new Intl.NumberFormat('id-ID').format(value || 0);
}

function formatDate(date) {
    if (!date) return '-';
    const d = new Date(date);
    return d.toLocaleDateString('id-ID', { 
        day: 'numeric', 
        month: 'short', 
        year: 'numeric' 
    });
}

function formatCurrency(value) {
    return 'Rp ' + formatNumber(value);
}

function getStatusBadge(status) {
    const statusMap = {
        'Pending': 'pending',
        'Diproses': 'diproses',
        'Dikirim': 'dikirim',
        'Selesai': 'selesai',
        'Dibatalkan': 'dibatalkan'
    };
    const cls = statusMap[status] || 'pending';
    const labels = {
        'Pending': '🟡 Pending',
        'Diproses': '🔵 Diproses',
        'Dikirim': '🚚 Dikirim',
        'Selesai': '✅ Selesai',
        'Dibatalkan': '❌ Dibatalkan'
    };
    return `<span class="badge-status ${cls}"><i class="fas fa-circle"></i> ${labels[status] || status}</span>`;
}

function getPaymentBadge(status) {
    const statusMap = {
        'pending': 'pending',
        'menunggu_verifikasi': 'menunggu_verifikasi',
        'lunas': 'lunas',
        'gagal': 'gagal'
    };
    const cls = statusMap[status] || 'pending';
    const labels = {
        'pending': 'Belum Bayar',
        'menunggu_verifikasi': 'Menunggu Verifikasi',
        'lunas': 'Lunas',
        'gagal': 'Gagal'
    };
    return `<span class="badge-payment ${cls}">${labels[status] || status}</span>`;
}

function getAvatarColor(name) {
    const colors = ['green', 'gold', 'blue', 'purple', 'orange', 'teal'];
    const index = (name || '').length % colors.length;
    return colors[index];
}

function getInitial(name) {
    return (name || 'U').charAt(0).toUpperCase();
}

function escapeHtml(str) {
    if (!str) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;'
    };
    return str.replace(/[&<>]/g, m => map[m]);
}

// ===== RENDER FUNCTIONS =====
function renderStats(data) {
    const total = data.length;
    const totalPendapatan = data.reduce((sum, t) => sum + parseFloat(t.total_akhir || t.total || 0), 0);
    const today = new Date().toDateString();
    const hariIni = data.filter(t => {
        const tgl = new Date(t.tanggal || t.created_at);
        return tgl.toDateString() === today;
    }).length;
    const selesai = data.filter(t => t.status === 'Selesai').length;
    const pending = data.filter(t => t.status === 'Pending' || t.status === 'Diproses').length;

    document.getElementById('totalTransaksi').textContent = total;
    document.getElementById('totalPendapatan').textContent = formatCurrency(totalPendapatan);
    document.getElementById('hariIni').textContent = hariIni;
    document.getElementById('pesananPending').textContent = pending;
    document.getElementById('pesananSelesai').textContent = selesai;
    document.getElementById('totalDataDisplay').textContent = total;
}

function renderTable(data) {
    const tbody = document.getElementById('tableBody');
    const start = (currentPage - 1) * perPage;
    const end = Math.min(start + perPage, data.length);
    const paginatedData = data.slice(start, end);

    if (paginatedData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h5>Belum Ada Transaksi</h5>
                        <p>Belum ada transaksi yang tercatat di sistem.</p>
                    </div>
                </td>
            </tr>
        `;
        renderPagination(data.length);
        return;
    }

    tbody.innerHTML = paginatedData.map((item, index) => {
        const avatarColor = getAvatarColor(item.nama_pelanggan || item.nama);
        const initial = getInitial(item.nama_pelanggan || item.nama);
        
        return `
            <tr>
                <td data-label="No">${start + index + 1}</td>
                <td data-label="Invoice">
                    <span class="invoice-number" onclick="showDetail(${item.id})">
                        #INV-${item.id}
                    </span>
                </td>
                <td data-label="Pelanggan">
                    <div class="d-flex align-items-center gap-2">
                        <div class="customer-avatar-sm ${avatarColor}">
                            ${initial}
                        </div>
                        <div>
                            <div class="customer-name-sm">${escapeHtml(item.nama_pelanggan || item.nama || '-')}</div>
                        </div>
                    </div>
                </td>
                <td data-label="Tanggal">${formatDate(item.tanggal || item.created_at)}</td>
                <td data-label="Total" class="fw-700 text-success">
                    ${formatCurrency(item.total_akhir || item.total || 0)}
                </td>
                <td data-label="Status">
                    <select class="status-select" data-id="${item.id}" data-status="${item.status || 'Pending'}">
                        <option value="Pending" ${(item.status || 'Pending') === 'Pending' ? 'selected' : ''}>🟡 Pending</option>
                        <option value="Diproses" ${item.status === 'Diproses' ? 'selected' : ''}>🔵 Diproses</option>
                        <option value="Dikirim" ${item.status === 'Dikirim' ? 'selected' : ''}>🚚 Dikirim</option>
                        <option value="Selesai" ${item.status === 'Selesai' ? 'selected' : ''}>✅ Selesai</option>
                    </select>
                </td>
                <td data-label="Pembayaran" onclick="showPaymentVerification(${item.id})" style="cursor: pointer;">
                    ${getPaymentBadge(item.status_pembayaran || 'pending')}
                </td>
                <td data-label="Aksi">
                    <button class="btn-action view" onclick="showDetail(${item.id})" title="Detail Transaksi">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');

    renderPagination(data.length);
    attachStatusChangeListeners();
}

function renderPagination(total) {
    const totalPages = Math.ceil(total / perPage);
    const container = document.getElementById('paginationContainer');

    if (totalPages <= 1) {
        container.innerHTML = `
            <div class="info-text">
                Menampilkan <strong>${total}</strong> data
            </div>
            <div></div>
        `;
        return;
    }

    let paginationHtml = `
        <div class="info-text">
            Menampilkan <strong>${total}</strong> data
        </div>
        <ul class="pagination-custom">
    `;

    // Previous
    paginationHtml += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1}); return false;">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
    `;

    // Page numbers
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {
        paginationHtml += `
            <li class="page-item"><a class="page-link" href="#" onclick="changePage(1); return false;">1</a></li>
            ${startPage > 2 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
        `;
    }

    for (let i = startPage; i <= endPage; i++) {
        paginationHtml += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i}); return false;">${i}</a>
            </li>
        `;
    }

    if (endPage < totalPages) {
        paginationHtml += `
            ${endPage < totalPages - 1 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
            <li class="page-item"><a class="page-link" href="#" onclick="changePage(${totalPages}); return false;">${totalPages}</a></li>
        `;
    }

    // Next
    paginationHtml += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1}); return false;">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    `;

    paginationHtml += `</ul>`;
    container.innerHTML = paginationHtml;
}

// ===== FILTER FUNCTIONS =====
function applyFilters() {
    let filtered = [...initialData];

    if (searchQuery) {
        const query = searchQuery.toLowerCase();
        filtered = filtered.filter(item => 
            (item.nama_pelanggan || item.nama || '').toLowerCase().includes(query)
        );
    }

    if (statusFilter) {
        filtered = filtered.filter(item => (item.status || 'Pending') === statusFilter);
    }

    if (paymentFilter) {
        filtered = filtered.filter(item => (item.status_pembayaran || 'pending') === paymentFilter);
    }

    if (dateFilter) {
        filtered = filtered.filter(item => {
            const itemDate = (item.tanggal || item.created_at || '').split(' ')[0];
            return itemDate === dateFilter;
        });
    }

    currentPage = 1;
    renderStats(filtered);
    renderTable(filtered);
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('paymentFilter').value = '';
    document.getElementById('dateFilter').value = '';
    searchQuery = '';
    statusFilter = '';
    paymentFilter = '';
    dateFilter = '';
    currentPage = 1;
    applyFilters();
}

function changePage(page) {
    if (page < 1) return;
    const totalData = getFilteredData().length;
    const totalPages = Math.ceil(totalData / perPage);
    if (page > totalPages) return;
    currentPage = page;
    const filtered = getFilteredData();
    renderTable(filtered);
}

function getFilteredData() {
    let filtered = [...initialData];
    if (searchQuery) {
        const query = searchQuery.toLowerCase();
        filtered = filtered.filter(item => 
            (item.nama_pelanggan || item.nama || '').toLowerCase().includes(query)
        );
    }
    if (statusFilter) {
        filtered = filtered.filter(item => (item.status || 'Pending') === statusFilter);
    }
    if (paymentFilter) {
        filtered = filtered.filter(item => (item.status_pembayaran || 'pending') === paymentFilter);
    }
    if (dateFilter) {
        filtered = filtered.filter(item => {
            const itemDate = (item.tanggal || item.created_at || '').split(' ')[0];
            return itemDate === dateFilter;
        });
    }
    return filtered;
}

// ===== STATUS CHANGE =====
function attachStatusChangeListeners() {
    document.querySelectorAll('.status-select').forEach(select => {
        select.removeEventListener('change', handleStatusChange);
        select.addEventListener('change', handleStatusChange);
    });
}

async function handleStatusChange(e) {
    e.stopPropagation();
    const select = e.target;
    const newStatus = select.value;
    const transactionId = select.dataset.id;
    const oldStatus = select.dataset.status;

    if (newStatus === oldStatus) return;

    const result = await Swal.fire({
        title: 'Ubah Status Pesanan?',
        html: `Apakah Anda yakin mengubah status menjadi <strong>${newStatus}</strong>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#164534',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    });

    if (!result.isConfirmed) {
        select.value = oldStatus;
        return;
    }

    select.disabled = true;

    try {
        const response = await fetch(
            `<?= base_url('admin/transaksi/updateStatus') ?>/${transactionId}/${newStatus}`,
            { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest' } }
        );
        const data = await response.json();

        if (data.success) {
            await Swal.fire('Berhasil!', data.message, 'success');
            select.dataset.status = newStatus;
            const item = initialData.find(t => t.id == transactionId);
            if (item) item.status = newStatus;
            applyFilters();
        } else {
            await Swal.fire('Gagal!', data.message || 'Terjadi kesalahan', 'error');
            select.value = oldStatus;
        }
    } catch (error) {
        await Swal.fire('Error!', 'Gagal menghubungi server', 'error');
        select.value = oldStatus;
    } finally {
        select.disabled = false;
    }
}

// ===== DETAIL MODAL =====
async function showDetail(id) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    const modalContent = document.getElementById('modalContent');

    modalContent.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-gold" role="status"></div>
            <p class="mt-2 text-muted">Memuat data transaksi...</p>
        </div>
    `;

    modal.show();

    try {
        const response = await fetch(`<?= base_url('admin/transaksi/getDetail/') ?>${id}`);
        const data = await response.json();

        if (data.success) {
            modalContent.innerHTML = renderDetailContent(data.transaksi, data.detail);
            document.getElementById('printInvoiceBtn').onclick = () => printInvoice(data.transaksi, data.detail);
        } else {
            modalContent.innerHTML = `
                <div class="text-center py-5 text-danger">
                    <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                    <p>Gagal memuat data: ${data.message || 'Terjadi kesalahan'}</p>
                </div>
            `;
        }
    } catch (error) {
        modalContent.innerHTML = `
            <div class="text-center py-5 text-danger">
                <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                <p>Terjadi kesalahan saat memuat data</p>
            </div>
        `;
    }
}

function renderDetailContent(transaksi, detail) {
    const statusTimeline = renderTimeline(transaksi.status);
    const isCOD = transaksi.metode_pembayaran === 'cod' || transaksi.metode_pembayaran === 'COD';

    let paymentSection = '';
    if (isCOD) {
        paymentSection = renderCODSection(transaksi);
    } else {
        paymentSection = renderPaymentSection(transaksi);
    }

    return `
        <div class="row g-4">
            <!-- Customer Info -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3" style="border-radius: var(--radius);">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-user me-2" style="color: var(--gold);"></i>
                        Data Pelanggan
                    </h6>
                    <p class="mb-1 fw-600">${escapeHtml(transaksi.nama_pelanggan || transaksi.nama || '-')}</p>
                    <p class="mb-1 text-muted small">
                        <i class="fas fa-phone me-2"></i>${transaksi.telepon || '-'}
                    </p>
                    <p class="mb-0 text-muted small">
                        <i class="fas fa-map-marker-alt me-2"></i>${escapeHtml(transaksi.alamat_tujuan || transaksi.alamat || '-')}
                    </p>
                </div>
            </div>

            <!-- Transaction Info -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3" style="border-radius: var(--radius);">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2" style="color: var(--gold);"></i>
                        Informasi Transaksi
                    </h6>
                    <p class="mb-1"><strong>Invoice:</strong> #INV-${transaksi.id}</p>
                    <p class="mb-1"><strong>Tanggal:</strong> ${formatDate(transaksi.tanggal || transaksi.created_at)}</p>
                    <p class="mb-1"><strong>Pengiriman:</strong> ${transaksi.metode_pengiriman === 'delivery' ? '🚚 Delivery' : '🏪 Ambil di Toko'}</p>
                    <p class="mb-0"><strong>Pembayaran:</strong> ${(transaksi.metode_pembayaran || '-').toUpperCase()}</p>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="col-12">
                <div class="card border-0 shadow-sm p-3" style="border-radius: var(--radius);">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-clock me-2" style="color: var(--gold);"></i>
                        Status Pesanan
                    </h6>
                    ${statusTimeline}
                </div>
            </div>

            <!-- Payment Section -->
            <div class="col-12">
                ${paymentSection}
            </div>

            <!-- Products -->
            <div class="col-12">
                <div class="card border-0 shadow-sm p-3" style="border-radius: var(--radius);">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-box me-2" style="color: var(--gold);"></i>
                        Detail Produk
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${detail.map(d => `
                                    <tr>
                                        <td>${escapeHtml(d.nama_barang)}</td>
                                        <td class="text-end">${formatCurrency(d.harga)}</td>
                                        <td class="text-center">${d.jumlah}</td>
                                        <td class="text-end">${formatCurrency(d.subtotal)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-600">Subtotal</td>
                                    <td class="text-end">${formatCurrency(transaksi.total || 0)}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-600">Ongkir</td>
                                    <td class="text-end">${formatCurrency(transaksi.ongkir || 0)}</td>
                                </tr>
                                ${transaksi.biaya_proteksi ? `
                                <tr>
                                    <td colspan="3" class="text-end fw-600">Proteksi</td>
                                    <td class="text-end">${formatCurrency(transaksi.biaya_proteksi || 0)}</td>
                                </tr>
                                ` : ''}
                                <tr class="table-active">
                                    <td colspan="3" class="text-end fw-700">Total</td>
                                    <td class="text-end fw-700 text-success" style="font-size: 18px;">
                                        ${formatCurrency(transaksi.total_akhir || transaksi.total || 0)}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Button -->
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <a href="https://wa.me/${transaksi.telepon || ''}?text=Halo%20${encodeURIComponent(transaksi.nama_pelanggan || '')}%2C%20pesanan%20Anda%20sedang%20${transaksi.status || 'diproses'}" 
                       target="_blank" 
                       class="btn btn-success" 
                       style="border-radius: var(--radius);">
                        <i class="fab fa-whatsapp me-2"></i> Hubungi Pelanggan
                    </a>
                </div>
            </div>
        </div>
    `;
}

function renderTimeline(status) {
    const steps = [
        { key: 'Pending', label: 'Pending', icon: 'fa-clock' },
        { key: 'Diproses', label: 'Diproses', icon: 'fa-spinner' },
        { key: 'Dikirim', label: 'Dikirim', icon: 'fa-truck' },
        { key: 'Selesai', label: 'Selesai', icon: 'fa-check-circle' }
    ];

    let currentIndex = steps.findIndex(s => s.key === status);
    if (currentIndex === -1) currentIndex = 0;

    return `
        <div class="d-flex justify-content-between align-items-center">
            ${steps.map((step, idx) => `
                <div class="text-center ${idx <= currentIndex ? 'text-success' : 'text-muted'}" style="flex: 1;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                         style="width: 40px; height: 40px; background: ${idx <= currentIndex ? 'var(--gold)' : 'var(--gray-200)'};">
                        <i class="fas ${step.icon} ${idx <= currentIndex ? 'text-white' : ''}"></i>
                    </div>
                    <small class="d-block fw-500">${step.label}</small>
                    ${idx < steps.length - 1 ? `
                        <div style="position: relative; top: -30px; left: 50%; width: 100%; height: 2px; background: ${idx < currentIndex ? 'var(--gold)' : 'var(--gray-200)'};">
                        </div>
                    ` : ''}
                </div>
            `).join('')}
        </div>
    `;
}

function renderPaymentSection(transaksi) {
    const isWaiting = transaksi.status_pembayaran === 'menunggu_verifikasi';

    return `
        <div class="card border-0 shadow-sm p-3" style="border-radius: var(--radius);">
            <h6 class="fw-bold mb-3">
                <i class="fas fa-money-bill-wave me-2" style="color: var(--gold);"></i>
                Informasi Pembayaran
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Status Pembayaran:</strong></p>
                    ${getPaymentBadge(transaksi.status_pembayaran || 'pending')}
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1"><strong>Total:</strong></p>
                    <span class="fw-700 text-success" style="font-size: 18px;">
                        ${formatCurrency(transaksi.total_akhir || transaksi.total || 0)}
                    </span>
                </div>
            </div>

            ${transaksi.bukti_pembayaran ? `
                <div class="mt-3">
                    <p class="mb-2"><strong>Bukti Pembayaran:</strong></p>
                    <a href="<?= base_url('uploads/bukti_pembayaran/') ?>${transaksi.bukti_pembayaran}" target="_blank">
                        <img src="<?= base_url('uploads/bukti_pembayaran/') ?>${transaksi.bukti_pembayaran}" 
                             alt="Bukti Pembayaran" 
                             style="max-width: 200px; border-radius: var(--radius); cursor: pointer; border: 1px solid var(--gray-200);">
                    </a>
                </div>
            ` : ''}

            ${isWaiting ? `
                <div class="mt-3 p-3" style="background: #FFF8E7; border-radius: var(--radius);">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-check-double me-2" style="color: var(--gold);"></i>
                        Verifikasi Pembayaran
                    </h6>
                    <div class="d-flex gap-3">
                        <button class="btn btn-success" onclick="verifikasiPembayaran(${transaksi.id}, 'lunas')" 
                                style="border-radius: var(--radius);">
                            <i class="fas fa-check-circle me-2"></i> Konfirmasi Pembayaran
                        </button>
                        <button class="btn btn-danger" onclick="verifikasiPembayaran(${transaksi.id}, 'gagal')" 
                                style="border-radius: var(--radius);">
                            <i class="fas fa-times-circle me-2"></i> Tolak Pembayaran
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        ⚠️ Pastikan bukti pembayaran sudah sesuai sebelum mengkonfirmasi.
                    </small>
                </div>
            ` : ''}
        </div>
    `;
}

function renderCODSection(transaksi) {
    const isLunas = transaksi.status_pembayaran === 'lunas';

    return `
        <div class="card border-0 shadow-sm p-3" style="border-radius: var(--radius);">
            <h6 class="fw-bold mb-3">
                <i class="fas fa-hand-holding-usd me-2" style="color: var(--gold);"></i>
                Pembayaran COD (Cash On Delivery)
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Status Pembayaran:</strong></p>
                    ${getPaymentBadge(transaksi.status_pembayaran || 'pending')}
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1"><strong>Total yang harus dibayar:</strong></p>
                    <span class="fw-700 text-success" style="font-size: 18px;">
                        ${formatCurrency(transaksi.total_akhir || transaksi.total || 0)}
                    </span>
                </div>
            </div>

            ${!isLunas ? `
                <div class="mt-3 p-3" style="background: #FFF8E7; border-radius: var(--radius);">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-check-double me-2" style="color: var(--gold);"></i>
                        Konfirmasi Pembayaran COD
                    </h6>
                    <p class="text-muted mb-3">Konfirmasi bahwa pelanggan sudah membayar saat barang diterima.</p>
                    <button class="btn btn-success" onclick="verifikasiPembayaranCOD(${transaksi.id})" 
                            style="border-radius: var(--radius);">
                        <i class="fas fa-check-circle me-2"></i> Konfirmasi Sudah Bayar
                    </button>
                    <small class="text-muted mt-2 d-block">
                        ⚠️ Hanya konfirmasi jika uang sudah diterima dari pelanggan.
                    </small>
                </div>
            ` : `
                <div class="mt-3 alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> Pembayaran sudah dikonfirmasi lunas
                </div>
            `}
        </div>
    `;
}

// ===== PAYMENT VERIFICATION =====
async function verifikasiPembayaran(id, status) {
    const result = await Swal.fire({
        title: status === 'lunas' ? 'Konfirmasi Pembayaran?' : 'Tolak Pembayaran?',
        html: `Apakah Anda yakin ${status === 'lunas' ? 'mengkonfirmasi' : 'menolak'} pembayaran ini?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: status === 'lunas' ? '#06C270' : '#FF4757',
        confirmButtonText: status === 'lunas' ? 'Ya, Konfirmasi' : 'Ya, Tolak',
        cancelButtonText: 'Batal'
    });

    if (!result.isConfirmed) return;

    Swal.fire({
        title: 'Memproses...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        const response = await fetch('<?= base_url("admin/transaksi/verifikasiPembayaran") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ id: id, status_pembayaran: status })
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire('Berhasil!', data.message, 'success');
            showDetail(id);
            applyFilters();
        } else {
            await Swal.fire('Gagal!', data.message || 'Terjadi kesalahan', 'error');
        }
    } catch (error) {
        await Swal.fire('Error!', 'Gagal menghubungi server', 'error');
    }
}

async function verifikasiPembayaranCOD(id) {
    const { value: metodeBayar } = await Swal.fire({
        title: 'Konfirmasi Pembayaran COD',
        html: 'Apakah pelanggan sudah membayar secara tunai?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#06C270',
        confirmButtonText: 'Ya, Sudah Dibayar',
        cancelButtonText: 'Belum',
        input: 'select',
        inputOptions: {
            'tunai': 'Tunai',
            'qris': 'QRIS',
            'transfer': 'Transfer'
        },
        inputPlaceholder: 'Pilih metode pembayaran yang digunakan',
        inputValidator: (value) => {
            if (!value) return 'Pilih metode pembayaran!';
        }
    });

    if (!metodeBayar) return;

    Swal.fire({
        title: 'Memproses...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        const response = await fetch('<?= base_url("admin/transaksi/verifikasiPembayaranCOD") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ id: id, metode_bayar: metodeBayar })
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire('Berhasil!', 'Pembayaran COD telah dikonfirmasi', 'success');
            showDetail(id);
            applyFilters();
        } else {
            await Swal.fire('Gagal!', data.message || 'Terjadi kesalahan', 'error');
        }
    } catch (error) {
        await Swal.fire('Error!', 'Gagal menghubungi server', 'error');
    }
}

// ===== SHOW PAYMENT VERIFICATION =====
async function showPaymentVerification(id) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    const modalContent = document.getElementById('modalContent');

    modalContent.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-gold" role="status"></div>
            <p class="mt-2 text-muted">Memuat data pembayaran...</p>
        </div>
    `;

    modal.show();

    try {
        const response = await fetch(`<?= base_url('admin/transaksi/getDetail/') ?>${id}`);
        const data = await response.json();

        if (data.success) {
            const transaksi = data.transaksi;
            const isCOD = transaksi.metode_pembayaran === 'cod' || transaksi.metode_pembayaran === 'COD';
            
            if (isCOD) {
                modalContent.innerHTML = renderCODSection(transaksi);
            } else {
                modalContent.innerHTML = renderPaymentSection(transaksi);
            }
            
            document.getElementById('printInvoiceBtn').onclick = () => printInvoice(transaksi, data.detail);
        } else {
            modalContent.innerHTML = `
                <div class="text-center py-5 text-danger">
                    <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                    <p>Gagal memuat data</p>
                </div>
            `;
        }
    } catch (error) {
        modalContent.innerHTML = `
            <div class="text-center py-5 text-danger">
                <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                <p>Terjadi kesalahan saat memuat data</p>
            </div>
        `;
    }
}

// ===== EXPORT TO EXCEL =====
function exportToExcel() {
    const table = document.getElementById('transactionTable');
    const clone = table.cloneNode(true);
    
    // Remove status select and action buttons
    clone.querySelectorAll('.status-select').forEach(el => el.remove());
    clone.querySelectorAll('.btn-action').forEach(el => el.remove());
    
    const blob = new Blob([clone.outerHTML], { type: 'application/vnd.ms-excel' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `transaksi_${new Date().toISOString().split('T')[0]}.xls`;
    link.click();
    URL.revokeObjectURL(link.href);
}

// ===== PRINT INVOICE =====
function printInvoice(transaksi, detail) {
    const printWindow = window.open('', '_blank');
    
    printWindow.document.write(`
        <html>
            <head>
                <title>Invoice #INV-${transaksi.id}</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { padding: 40px; font-family: 'Segoe UI', sans-serif; }
                    .invoice-header { 
                        text-align: center; 
                        border-bottom: 3px solid #B8963E; 
                        padding-bottom: 20px; 
                        margin-bottom: 30px; 
                    }
                    .invoice-title { color: #164534; font-weight: 700; }
                    .invoice-subtitle { color: #6D6D6D; }
                    @media print { .no-print { display: none; } }
                </style>
            </head>
            <body>
                <div class="invoice-header">
                    <h1 class="invoice-title">YSP Jasmine</h1>
                    <p class="invoice-subtitle">Jl. Desa Kertosari, Pemalang<br>Telp: 0856 4769 5804</p>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <h5>INVOICE #INV-${transaksi.id}</h5>
                        <p class="text-muted">Tanggal: ${formatDate(transaksi.tanggal || transaksi.created_at)}</p>
                    </div>
                    <div class="col-6 text-end">
                        <h5>Data Pelanggan</h5>
                        <p class="mb-0"><strong>${escapeHtml(transaksi.nama_pelanggan || '-')}</strong></p>
                        <p class="text-muted">${transaksi.alamat_tujuan || '-'}</p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${detail.map(d => `
                            <tr>
                                <td>${escapeHtml(d.nama_barang)}</td>
                                <td class="text-end">${formatCurrency(d.harga)}</td>
                                <td class="text-center">${d.jumlah}</td>
                                <td class="text-end">${formatCurrency(d.subtotal)}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="text-end fw-bold" style="font-size: 18px;">
                                ${formatCurrency(transaksi.total_akhir || transaksi.total || 0)}
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-center mt-5">
                    <p>Terima kasih telah berbelanja di YSP Jasmine</p>
                    <p class="text-muted">* Barang yang sudah dibeli tidak dapat dikembalikan</p>
                </div>
            </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.print();
}

// ===== INIT =====
document.addEventListener('DOMContentLoaded', function() {
    // Attach filter listeners
    document.getElementById('searchInput').addEventListener('input', debounce(function(e) {
        searchQuery = e.target.value;
        currentPage = 1;
        applyFilters();
    }, 300));

    document.getElementById('statusFilter').addEventListener('change', function(e) {
        statusFilter = e.target.value;
        currentPage = 1;
        applyFilters();
    });

    document.getElementById('paymentFilter').addEventListener('change', function(e) {
        paymentFilter = e.target.value;
        currentPage = 1;
        applyFilters();
    });

    document.getElementById('dateFilter').addEventListener('change', function(e) {
        dateFilter = e.target.value;
        currentPage = 1;
        applyFilters();
    });

    // Initial render
    applyFilters();
});

// ===== DEBOUNCE =====
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// ===== OVERRIDE PRINT =====
window.print = function() {
    window.print();
};
</script>

<?= $this->endSection() ?>