<?php
/**
 * Partial <head> + gaya bersama untuk halaman akun pelanggan
 * (Dashboard, Riwayat Pesanan, Edit Profil).
 * Pakai: <?= view('User/layout/account_head', ['title' => 'Dashboard']) ?>
 */

if (!function_exists('acc_status')) {
    /** Peta status pesanan -> label, kelas, ikon */
    function acc_status(string $status): array
    {
        $map = [
            'Pending'  => ['Menunggu Konfirmasi', 'st-pending', 'fa-clock'],
            'Diproses' => ['Sedang Diproses',     'st-proses',  'fa-box-open'],
            'Dikirim'  => ['Sedang Dikirim',      'st-kirim',   'fa-truck-fast'],
            'Selesai'  => ['Selesai',             'st-selesai', 'fa-circle-check'],
            'Batal'    => ['Dibatalkan',          'st-batal',   'fa-circle-xmark'],
        ];
        return $map[$status] ?? [$status ?: 'Pending', 'st-pending', 'fa-clock'];
    }
}

if (!function_exists('acc_payment')) {
    /** Peta status pembayaran -> label, kelas, ikon */
    function acc_payment(?string $status): array
    {
        $map = [
            'lunas'               => ['Lunas',               'st-selesai', 'fa-circle-check'],
            'menunggu_verifikasi' => ['Menunggu Verifikasi', 'st-proses',  'fa-hourglass-half'],
            'gagal'               => ['Pembayaran Gagal',    'st-batal',   'fa-triangle-exclamation'],
            'cod'                 => ['Bayar di Tempat',     'st-kirim',   'fa-money-bill-wave'],
            'pending'             => ['Belum Dibayar',       'st-pending', 'fa-wallet'],
        ];
        return $map[$status ?? 'pending'] ?? $map['pending'];
    }
}

if (!function_exists('acc_group')) {
    /** Kelompok filter: berjalan / selesai / batal */
    function acc_group(string $status): string
    {
        if ($status === 'Selesai') return 'selesai';
        if ($status === 'Batal')   return 'batal';
        return 'berjalan';
    }
}
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Akun Saya') ?> | YSP Jasmine</title>
<link rel="icon" href="<?= base_url('favicon.ico') ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --gold: #C9A84C;
        --gold-dark: #9A7B2B;
        --gold-light: #E8C97A;
        --gold-pale: #F5EDD3;
        --green-deep: #2D5016;
        --green-dark: #1E3A0E;
        --green-mid: #4A7C2F;
        --green-fresh: #6BA847;
        --green-pale: #EBF4E3;
        --cream: #FDFAF4;
        --white: #FFFFFF;
        --text-dark: #1A2A0E;
        --text-mid: #4A5E37;
        --text-muted: #6B7C5A;
        --line: rgba(74, 124, 47, .14);
        --radius-card: 20px;
        --radius-md: 14px;
        --radius-pill: 50px;
        --shadow-soft: 0 4px 20px rgba(45, 80, 22, .07);
        --shadow-hover: 0 12px 30px rgba(45, 80, 22, .13);
    }

    html { scroll-behavior: smooth; }
    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--cream);
        color: var(--text-dark);
        -webkit-font-smoothing: antialiased;
    }
    h1, h2, h3, h4, h5, .display-font { font-family: 'Cormorant Garamond', serif; color: var(--green-deep); }
    a { color: var(--green-mid); }
    :focus-visible { outline: 3px solid rgba(201, 168, 76, .55); outline-offset: 2px; border-radius: 6px; }

    /* ============ BAR PENGUMUMAN + HEADER ============ */
    .acc-announce {
        background: var(--green-deep);
        color: #fff;
        font-size: .82rem;
        text-align: center;
        padding: 9px 16px;
        letter-spacing: .3px;
    }
    .acc-announce a { color: var(--gold-light); text-decoration: underline; text-underline-offset: 3px; font-weight: 600; }

    .acc-header {
        position: sticky; top: 0; z-index: 1030;
        background: rgba(255, 255, 255, .96);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid var(--line);
    }
    .acc-header .bar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; padding: 12px 0;
    }
    .acc-brand { text-decoration: none; text-align: center; line-height: 1; }
    .acc-brand .name {
        font-family: 'Cormorant Garamond', serif; font-weight: 600;
        font-size: 1.9rem; letter-spacing: 5px; color: var(--green-deep); display: block;
    }
    .acc-brand .tag { font-size: .58rem; letter-spacing: 4px; color: var(--gold-dark); display: block; margin-top: 4px; }

    .acc-nav { display: flex; justify-content: center; gap: 4px; flex-wrap: wrap; padding: 0 0 10px; }
    .acc-nav a {
        text-decoration: none; color: var(--text-dark); font-size: .82rem; font-weight: 500;
        letter-spacing: 1.4px; text-transform: uppercase; padding: 8px 16px; border-radius: var(--radius-pill);
        transition: background .2s, color .2s;
    }
    .acc-nav a:hover { background: var(--green-pale); color: var(--green-deep); }

    .acc-icon-btn {
        position: relative; width: 44px; height: 44px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        background: transparent; border: 1.5px solid transparent; color: var(--green-deep);
        font-size: 1.1rem; text-decoration: none; transition: all .2s; cursor: pointer;
    }
    .acc-icon-btn:hover { background: var(--green-pale); }
    .acc-cart-count {
        position: absolute; top: 2px; right: 0; min-width: 20px; height: 20px; padding: 0 5px;
        background: var(--gold); color: var(--green-dark); border-radius: 10px;
        font-size: .68rem; font-weight: 700; display: flex; align-items: center; justify-content: center;
        border: 2px solid #fff;
    }
    .acc-user-btn {
        display: inline-flex; align-items: center; gap: 10px; padding: 5px 14px 5px 5px;
        border: 1.5px solid var(--line); border-radius: var(--radius-pill); background: #fff;
        color: var(--green-deep); font-weight: 600; font-size: .88rem; cursor: pointer; transition: all .2s;
    }
    .acc-user-btn:hover, .acc-user-btn[aria-expanded="true"] { border-color: var(--gold); background: var(--gold-pale); }
    .avatar {
        width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, var(--green-mid), var(--green-deep)); color: #fff;
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .95rem; text-transform: uppercase;
    }
    .avatar.lg { width: 64px; height: 64px; font-size: 1.6rem; border: 3px solid rgba(255, 255, 255, .35); }

    .acc-menu {
        min-width: 270px; padding: 0; border: 1px solid var(--line); border-radius: 18px;
        box-shadow: 0 18px 40px rgba(26, 42, 14, .16); overflow: hidden; margin-top: 10px !important;
    }
    .acc-menu .menu-head { display: flex; gap: 12px; align-items: center; padding: 16px 18px; background: var(--green-pale); }
    .acc-menu .menu-head small { display: block; color: var(--text-muted); font-size: .75rem; }
    .acc-menu .menu-head strong { color: var(--green-deep); font-size: .98rem; }
    .acc-menu .dropdown-item {
        display: flex; align-items: center; gap: 12px; padding: 12px 18px; font-size: .92rem; font-weight: 500; color: var(--text-dark);
    }
    .acc-menu .dropdown-item i { width: 20px; text-align: center; color: var(--green-mid); }
    .acc-menu .dropdown-item:hover { background: var(--green-pale); }
    .acc-menu .dropdown-item.active { background: var(--green-deep); color: #fff; }
    .acc-menu .dropdown-item.active i { color: var(--gold-light); }
    .acc-menu .dropdown-item.logout, .acc-menu .dropdown-item.logout i { color: #C0392B; }
    .acc-menu .dropdown-item.logout:hover { background: #FDECEA; }

    /* ============ KERANGKA HALAMAN ============ */
    .acc-main { padding: 32px 0 20px; min-height: 60vh; }
    .page-title { font-size: 2.1rem; font-weight: 600; margin-bottom: 4px; }
    .page-sub { color: var(--text-muted); margin-bottom: 0; }
    .crumbs { font-size: .82rem; color: var(--text-muted); margin-bottom: 10px; }
    .crumbs a { color: var(--text-muted); text-decoration: none; }
    .crumbs a:hover { color: var(--green-deep); text-decoration: underline; }

    /* ============ HERO SELAMAT DATANG ============ */
    .acc-hero {
        position: relative; overflow: hidden; border-radius: 24px; padding: 30px 32px; color: #fff;
        background: linear-gradient(135deg, var(--green-deep) 0%, var(--green-mid) 100%);
        box-shadow: 0 14px 34px rgba(45, 80, 22, .22);
    }
    .acc-hero::before { content: '✿'; position: absolute; right: 28px; bottom: -24px; font-size: 9rem; opacity: .09; line-height: 1; }
    .acc-hero h1 { color: #fff; font-size: 2rem; font-weight: 500; margin: 0 0 4px; }
    .acc-hero p { margin: 0; color: rgba(255, 255, 255, .82); }

    /* ============ TOMBOL ============ */
    .btn-ysp, .btn-ysp-outline, .btn-ysp-gold, .btn-ysp-light {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 11px 22px; border-radius: var(--radius-pill); font-weight: 600; font-size: .9rem;
        text-decoration: none; border: 1.5px solid transparent; transition: all .25s; cursor: pointer; line-height: 1.2;
    }
    .btn-ysp { background: linear-gradient(135deg, var(--green-mid), var(--green-deep)); color: #fff; }
    .btn-ysp:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(45, 80, 22, .25); }
    .btn-ysp-outline { background: #fff; color: var(--green-deep); border-color: var(--green-mid); }
    .btn-ysp-outline:hover { background: var(--green-mid); color: #fff; }
    .btn-ysp-gold { background: var(--gold); color: var(--green-dark); }
    .btn-ysp-gold:hover { background: var(--gold-light); color: var(--green-dark); transform: translateY(-2px); }
    .btn-ysp-light { background: rgba(255, 255, 255, .14); color: #fff; border-color: rgba(255, 255, 255, .5); }
    .btn-ysp-light:hover { background: #fff; color: var(--green-deep); }
    .btn-sm-ysp { padding: 8px 16px; font-size: .82rem; }

    /* ============ KARTU ============ */
    .card-ysp { background: #fff; border: 1px solid rgba(201, 168, 76, .16); border-radius: var(--radius-card); box-shadow: var(--shadow-soft); }

    .stat-card {
        display: flex; align-items: center; gap: 16px; padding: 22px; text-decoration: none; color: inherit;
        background: #fff; border: 1px solid rgba(201, 168, 76, .16); border-radius: var(--radius-card);
        box-shadow: var(--shadow-soft); transition: transform .25s, box-shadow .25s, border-color .25s; height: 100%;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); border-color: var(--gold); color: inherit; }
    .stat-icon {
        width: 56px; height: 56px; border-radius: 16px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; background: var(--green-pale); color: var(--green-mid);
    }
    .stat-card.is-proses .stat-icon { background: #E3F2FD; color: #1976D2; }
    .stat-card.is-selesai .stat-icon { background: #E8F5E9; color: #2E7D32; }
    .stat-label { font-size: .78rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); font-weight: 600; margin: 0; }
    .stat-number { font-family: 'Cormorant Garamond', serif; font-size: 2.4rem; font-weight: 700; color: var(--green-deep); line-height: 1.05; }
    .stat-hint { font-size: .78rem; color: var(--text-muted); }
    .stat-arrow { margin-left: auto; color: var(--gold-dark); opacity: .6; }

    .quick-link {
        display: flex; align-items: center; gap: 12px; padding: 16px; background: #fff; border-radius: var(--radius-md);
        border: 1px solid var(--line); text-decoration: none; color: var(--text-dark); font-weight: 600; font-size: .9rem;
        transition: all .2s; height: 100%;
    }
    .quick-link i { width: 40px; height: 40px; border-radius: 12px; background: var(--gold-pale); color: var(--gold-dark); display: flex; align-items: center; justify-content: center; }
    .quick-link small { display: block; font-weight: 400; color: var(--text-muted); font-size: .76rem; }
    .quick-link:hover { border-color: var(--gold); box-shadow: var(--shadow-soft); transform: translateY(-2px); color: var(--green-deep); }

    /* ============ BADGE STATUS ============ */
    .st {
        display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: var(--radius-pill);
        font-size: .76rem; font-weight: 600; white-space: nowrap;
    }
    .st-pending { background: #FFF3E0; color: #A85A00; }
    .st-proses  { background: #E3F2FD; color: #0D5FA8; }
    .st-kirim   { background: #EDE7F6; color: #5B3AA0; }
    .st-selesai { background: #E8F5E9; color: #1E6B22; }
    .st-batal   { background: #FDECEA; color: #B3261E; }

    /* ============ DAFTAR PESANAN ============ */
    .order-row {
        display: grid; grid-template-columns: 1.3fr 1fr 1.4fr auto; gap: 16px; align-items: center;
        padding: 16px 20px; border-bottom: 1px solid var(--line);
    }
    .order-row:last-child { border-bottom: 0; }
    .order-row:hover { background: #FBFDF8; }
    .order-id { font-weight: 700; color: var(--green-deep); }
    .order-date { font-size: .8rem; color: var(--text-muted); }
    .order-total { font-weight: 700; color: var(--green-deep); }
    .order-badges { display: flex; flex-wrap: wrap; gap: 6px; }

    .empty-box { text-align: center; padding: 48px 20px; }
    .empty-box .ico {
        width: 84px; height: 84px; border-radius: 50%; margin: 0 auto 16px; background: var(--green-pale);
        color: var(--green-mid); display: flex; align-items: center; justify-content: center; font-size: 2rem;
    }

    /* ============ RIWAYAT ============ */
    .toolbar { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .search-box { position: relative; flex: 1 1 260px; max-width: 360px; }
    .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
    .search-box input {
        width: 100%; padding: 11px 16px 11px 42px; border: 1.5px solid var(--line); border-radius: var(--radius-pill);
        background: #fff; font-size: .9rem;
    }
    .search-box input:focus { border-color: var(--gold); outline: 0; box-shadow: 0 0 0 4px rgba(201, 168, 76, .18); }

    .tabs-ysp { display: flex; gap: 8px; flex-wrap: wrap; }
    .tab-ysp {
        display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: var(--radius-pill);
        background: #fff; border: 1.5px solid var(--line); color: var(--text-mid); font-weight: 600; font-size: .86rem; cursor: pointer; transition: all .2s;
    }
    .tab-ysp .count { background: var(--green-pale); color: var(--green-deep); border-radius: 10px; padding: 1px 8px; font-size: .75rem; }
    .tab-ysp:hover { border-color: var(--green-mid); }
    .tab-ysp.active { background: var(--green-deep); border-color: var(--green-deep); color: #fff; }
    .tab-ysp.active .count { background: var(--gold); color: var(--green-dark); }

    .order-card { background: #fff; border: 1px solid rgba(201, 168, 76, .16); border-radius: var(--radius-card); box-shadow: var(--shadow-soft); margin-bottom: 20px; overflow: hidden; transition: box-shadow .25s; }
    .order-card:hover { box-shadow: var(--shadow-hover); }
    .order-card .oc-head { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; padding: 16px 22px; background: var(--green-pale); }
    .order-card .oc-body { padding: 6px 22px; }
    .order-card .oc-foot { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; padding: 16px 22px; background: var(--cream); border-top: 1px solid var(--line); }

    .oc-item { display: flex; align-items: center; gap: 14px; padding: 14px 0; border-bottom: 1px dashed var(--line); }
    .oc-item:last-child { border-bottom: 0; }
    .oc-img { width: 62px; height: 62px; border-radius: 12px; object-fit: cover; background: var(--green-pale); flex-shrink: 0; }
    .oc-name { font-weight: 600; color: var(--green-deep); line-height: 1.3; }
    .oc-qty { font-size: .8rem; color: var(--text-muted); }
    .oc-price { margin-left: auto; font-weight: 600; color: var(--text-dark); white-space: nowrap; }

    .meta-chip { display: inline-flex; align-items: center; gap: 6px; font-size: .82rem; color: var(--text-mid); background: #fff; border: 1px solid var(--line); border-radius: var(--radius-pill); padding: 5px 12px; }
    .total-label { font-size: .75rem; color: var(--text-muted); display: block; text-align: right; }
    .total-amount { font-size: 1.25rem; font-weight: 700; color: var(--green-deep); }

    /* Pelacak progres */
    .tracker { display: flex; padding: 18px 22px 8px; gap: 0; }
    .tracker .step { flex: 1; text-align: center; position: relative; font-size: .72rem; color: var(--text-muted); font-weight: 500; }
    .tracker .step .dot {
        width: 28px; height: 28px; border-radius: 50%; margin: 0 auto 6px; display: flex; align-items: center; justify-content: center;
        background: #fff; border: 2px solid #D6DDCD; color: #B5C0A6; font-size: .72rem; position: relative; z-index: 1;
    }
    .tracker .step::before { content: ''; position: absolute; top: 13px; left: -50%; width: 100%; height: 2px; background: #D6DDCD; }
    .tracker .step:first-child::before { display: none; }
    .tracker .step.done .dot { background: var(--green-mid); border-color: var(--green-mid); color: #fff; }
    .tracker .step.done::before { background: var(--green-mid); }
    .tracker .step.now .dot { background: var(--gold); border-color: var(--gold); color: var(--green-dark); box-shadow: 0 0 0 5px rgba(201, 168, 76, .22); }
    .tracker .step.done, .tracker .step.now { color: var(--green-deep); font-weight: 600; }
    .cancel-note { margin: 16px 22px 0; padding: 10px 14px; background: #FDECEA; color: #B3261E; border-radius: 12px; font-size: .85rem; }

    /* ============ MODAL & FORM ============ */
    .modal-ysp .modal-content { border: 0; border-radius: 24px; overflow: hidden; box-shadow: 0 24px 60px rgba(26, 42, 14, .3); }
    .modal-ysp .modal-head {
        display: flex; align-items: center; gap: 16px; padding: 22px 26px; color: #fff; position: relative;
        background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
    }
    .modal-ysp .modal-head h5 { color: #fff; margin: 0; font-size: 1.45rem; }
    .modal-ysp .modal-head p { margin: 0; font-size: .84rem; color: rgba(255, 255, 255, .8); }
    .modal-ysp .btn-close { position: absolute; top: 16px; right: 16px; filter: invert(1) grayscale(1) brightness(2); opacity: .85; }
    .modal-ysp .modal-body { padding: 24px 26px 8px; max-height: 65vh; overflow-y: auto; }
    .modal-ysp .modal-foot { display: flex; justify-content: flex-end; gap: 10px; padding: 16px 26px 22px; }

    .form-section { font-size: .78rem; text-transform: uppercase; letter-spacing: 1.4px; font-weight: 700; color: var(--gold-dark); margin: 4px 0 14px; display: flex; align-items: center; gap: 10px; }
    .form-section::after { content: ''; flex: 1; height: 1px; background: var(--line); }
    .field { margin-bottom: 16px; }
    .field label { font-weight: 600; font-size: .86rem; color: var(--text-dark); margin-bottom: 6px; display: block; }
    .field .input-group-text { background: var(--green-pale); border: 1.5px solid var(--line); border-right: 0; color: var(--green-mid); border-radius: 12px 0 0 12px; width: 44px; justify-content: center; }
    .field .form-control { border: 1.5px solid var(--line); border-radius: 0 12px 12px 0; padding: 11px 14px; font-size: .94rem; }
    .field textarea.form-control { border-radius: 0 12px 12px 0; }
    .field .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 4px rgba(201, 168, 76, .18); }
    .field .toggle-pass { border: 1.5px solid var(--line); border-left: 0; background: #fff; border-radius: 0 12px 12px 0; color: var(--text-muted); }
    .field .input-group .form-control:has(+ .toggle-pass) { border-radius: 0; }
    .field .hint { font-size: .78rem; color: var(--text-muted); margin-top: 5px; }
    .field .invalid-feedback { font-size: .8rem; }
    .btn-cancel { background: #fff; border: 1.5px solid var(--line); color: var(--text-mid); }
    .btn-cancel:hover { background: var(--green-pale); }

    .rating-input { display: flex; gap: 6px; }
    .rating-input i { font-size: 2rem; cursor: pointer; color: #D5D5D5; transition: transform .15s, color .15s; }
    .rating-input i.active, .rating-input i.hover { color: var(--gold); }
    .rating-input i:hover { transform: scale(1.12); }

    /* ============ FOOTER & WA ============ */
    .acc-footer { background: var(--green-deep); color: rgba(255, 255, 255, .7); padding: 36px 0 22px; margin-top: 56px; font-size: .88rem; }
    .acc-footer .brand { font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; color: var(--gold-light); letter-spacing: 3px; }
    .acc-footer a { color: rgba(255, 255, 255, .75); text-decoration: none; }
    .acc-footer a:hover { color: var(--gold-light); }
    .wa-float {
        position: fixed; right: 22px; bottom: 22px; z-index: 1040; width: 58px; height: 58px; border-radius: 50%;
        background: #25D366; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;
        box-shadow: 0 8px 24px rgba(37, 211, 102, .45); text-decoration: none; transition: transform .2s;
    }
    .wa-float:hover { transform: scale(1.08); color: #fff; }

    /* ============ RESPONSIF ============ */
    @media (max-width: 991.98px) {
        .acc-header .bar { padding: 10px 0; }
        .acc-brand .name { font-size: 1.5rem; letter-spacing: 3px; }
        .acc-nav-wrap { display: none; padding: 6px 0 12px; }
        .acc-nav-wrap.open { display: block; }
        .acc-nav { flex-direction: column; align-items: stretch; gap: 2px; }
        .acc-nav a { border-radius: 12px; padding: 12px 14px; }
    }
    @media (min-width: 992px) { .menu-toggle { display: none !important; } }
    @media (max-width: 767.98px) {
        .acc-main { padding-top: 22px; }
        .acc-hero { padding: 24px 22px; }
        .acc-hero h1 { font-size: 1.55rem; }
        .page-title { font-size: 1.7rem; }
        .order-row { grid-template-columns: 1fr auto; gap: 8px 12px; padding: 16px; }
        .order-row .c-badges { grid-column: 1 / -1; order: 3; }
        .order-row .c-action { grid-column: 1 / -1; order: 4; }
        .order-row .c-action .btn-ysp-outline { width: 100%; }
        .order-row .c-total { text-align: right; }
        .acc-user-btn .uname { display: none; }
        .acc-user-btn { padding: 4px; }
        .order-card .oc-head, .order-card .oc-body, .order-card .oc-foot { padding-left: 16px; padding-right: 16px; }
        .oc-foot .total-wrap { width: 100%; display: flex; justify-content: space-between; align-items: center; }
        .oc-foot .actions { width: 100%; display: flex; gap: 8px; }
        .oc-foot .actions > * { flex: 1; }
        .tracker { padding-left: 8px; padding-right: 8px; }
        .tracker .step { font-size: .66rem; }
        .modal-ysp .modal-body { padding: 20px 18px 4px; }
        .modal-ysp .modal-head, .modal-ysp .modal-foot { padding-left: 18px; padding-right: 18px; }
    }
    @media (prefers-reduced-motion: reduce) { * { transition: none !important; scroll-behavior: auto !important; } }
</style>
