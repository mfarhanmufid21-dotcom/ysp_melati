<?php
if (!function_exists('format_deskripsi')) {
    /**
     * Ubah teks deskripsi mentah (baris baru, "- poin", "Judul:") menjadi HTML rapi:
     * paragraf, sub-judul, dan daftar poin dengan label tebal. Semua teks di-escape.
     */
    function format_deskripsi(string $teks): string
    {
        $lines = preg_split('/\R/u', trim($teks));
        $html = '';
        $para = [];
        $list = [];
        $first = true;

        $flushPara = function () use (&$html, &$para, &$first) {
            if (!$para) return;
            $text = implode(' ', $para);
            $isLead = $first && mb_strlen($text) <= 90 && !preg_match('/[.!?:]$/u', $text);
            $html .= '<p class="' . ($isLead ? 'desc-lead' : 'desc-p') . '">' . esc($text) . '</p>';
            $first = false;
            $para = [];
        };
        $flushList = function () use (&$html, &$list) {
            if (!$list) return;
            $html .= '<ul class="desc-list">';
            foreach ($list as $item) {
                if (preg_match('/^([^:]{2,45}):\s+(.+)$/u', $item, $m)) {
                    $html .= '<li><strong>' . esc($m[1]) . '</strong> ' . esc($m[2]) . '</li>';
                } else {
                    $html .= '<li>' . esc($item) . '</li>';
                }
            }
            $html .= '</ul>';
            $list = [];
        };

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') { $flushPara(); $flushList(); continue; }

            if (preg_match('/^(?:[-–•*]|\d+[.)])\s+(.+)$/u', $line, $m)) {   // poin
                $flushPara();
                $list[] = $m[1];
            } elseif (preg_match('/^[^.!?]{2,60}:$/u', $line)) {              // sub-judul "Karakteristik Produk:"
                $flushPara(); $flushList();
                $html .= '<h4 class="desc-sub">' . esc(rtrim($line, ':')) . '</h4>';
                $first = false;
            } else {
                $flushList();
                $para[] = $line;
            }
        }
        $flushPara(); $flushList();
        return $html;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($produk['nama_barang'] ?? 'Detail Produk') ?> | YSP Jasmine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
    
    <style>
     /* ============================================================
   ROOT VARIABLES
   ============================================================ */
:root {
    --gold: #C9A84C;
    --gold-light: #DEC97A;
    --gold-pale: #F5EDD3;
    --green-deep: #1A3C2A;
    --green-mid: #2D5A3E;
    --green-light: #4A7C3A;
    --green-pale: #EBF4E3;
    --cream: #FDFBF7;
    --white: #FFFFFF;
    --gray-50: #F8F9FA;
    --gray-100: #F0F1F3;
    --gray-200: #E2E4E8;
    --gray-300: #CDD0D7;
    --gray-400: #A8ADB7;
    --gray-500: #8A8F9A;
    --gray-600: #6B707B;
    --gray-700: #4A4F5A;
    --gray-800: #2D323D;
    --gray-900: #1A1D26;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.06);
    --shadow-lg: 0 8px 32px rgba(0,0,0,0.08);
    --shadow-xl: 0 16px 48px rgba(0,0,0,0.12);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 20px;
    --radius-xl: 28px;
    --radius-pill: 50px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--gray-50);
    color: var(--gray-800);
    padding-top: 72px;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
}

a { text-decoration: none; }

/* ============================================================
   NAVBAR
   ============================================================ */
.navbar-ysp {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
    padding: 14px 0;
    transition: var(--transition);
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid transparent;
}

.navbar-ysp.scrolled {
    border-bottom: 1px solid rgba(0,0,0,0.06);
    box-shadow: var(--shadow-sm);
}

.navbar-brand-ysp {
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--green-deep) !important;
    letter-spacing: -0.5px;
}

.navbar-brand-ysp .accent { color: var(--gold); }

.nav-link-ysp {
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--gray-600) !important;
    padding: 6px 16px !important;
    transition: var(--transition);
    border-radius: var(--radius-sm);
    position: relative;
}

.nav-link-ysp:hover,
.nav-link-ysp.active {
    color: var(--green-deep) !important;
    background: rgba(26,60,42,0.06);
}

.nav-link-ysp::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 20px;
    height: 2px;
    background: var(--gold);
    border-radius: 2px;
    transition: var(--transition);
}

.nav-link-ysp:hover::after,
.nav-link-ysp.active::after {
    transform: translateX(-50%) scaleX(1);
}

.navbar-toggler {
    border: none !important;
    box-shadow: none !important;
}

.btn-nav-login {
    font-size: 0.8rem;
    font-weight: 500;
    padding: 6px 18px;
    border-radius: var(--radius-pill);
    border: 1.5px solid var(--gray-200);
    color: var(--gray-700) !important;
    transition: var(--transition);
    background: transparent;
}

.btn-nav-login:hover {
    border-color: var(--green-deep);
    color: var(--green-deep) !important;
    background: rgba(26,60,42,0.04);
}

.btn-nav-register {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 6px 18px;
    border-radius: var(--radius-pill);
    background: var(--gold);
    border: 1.5px solid var(--gold);
    color: white !important;
    transition: var(--transition);
}

.btn-nav-register:hover {
    background: var(--gold-light);
    border-color: var(--gold-light);
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(201,168,76,0.35);
}

.cart-icon {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: var(--gray-600);
    transition: var(--transition);
    border: none;
    background: transparent;
}

.cart-icon:hover {
    background: rgba(26,60,42,0.06);
    color: var(--green-deep);
}

.cart-count {
    position: absolute;
    top: -2px;
    right: -2px;
    background: var(--gold);
    color: white;
    font-size: 0.6rem;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 50%;
    min-width: 20px;
    text-align: center;
    box-shadow: var(--shadow-sm);
    line-height: 1.6;
}

.btn-user-dropdown {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px 6px 10px;
    border-radius: var(--radius-pill);
    border: 1px solid var(--gray-200);
    background: transparent;
    color: var(--gray-700);
    font-size: 0.85rem;
    font-weight: 500;
    transition: var(--transition);
    cursor: pointer;
}

.btn-user-dropdown:hover {
    border-color: var(--green-deep);
    color: var(--green-deep);
    background: rgba(26,60,42,0.04);
}

.btn-user-dropdown .avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--gold-pale);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--gold);
    flex-shrink: 0;
}

.dropdown-menu-custom {
    border: none;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    padding: 8px;
    margin-top: 8px;
    min-width: 220px;
}

.dropdown-menu-custom .dropdown-item {
    border-radius: var(--radius-sm);
    padding: 10px 16px;
    font-size: 0.85rem;
    color: var(--gray-700);
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 10px;
}

.dropdown-menu-custom .dropdown-item:hover {
    background: var(--gray-50);
    color: var(--green-deep);
}

.dropdown-menu-custom .dropdown-item i {
    width: 18px;
    color: var(--gray-400);
}

.dropdown-menu-custom .dropdown-item:hover i {
    color: var(--gold);
}

.dropdown-header-custom {
    padding: 8px 16px 4px;
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

/* ============================================================
   BREADCRUMB
   ============================================================ */
.breadcrumb-custom {
    padding: 16px 0 8px;
    font-size: 0.8rem;
    color: var(--gray-500);
}

.breadcrumb-custom a {
    color: var(--gray-500);
    transition: var(--transition);
}

.breadcrumb-custom a:hover {
    color: var(--gold);
}

.breadcrumb-custom .separator {
    margin: 0 8px;
    color: var(--gray-300);
}

.breadcrumb-custom .current {
    color: var(--gray-700);
    font-weight: 500;
}

/* ============================================================
   PRODUCT DETAIL - GAMBAR PRODUK LEBIH KECIL
   ============================================================ */
.product-detail-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 24px;
}

.product-detail-card .product-body {
    padding: 32px 36px 36px;
}

.product-gallery {
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--gray-50);
    position: relative;
    height: 100%;
    max-height: 420px;
    min-height: 300px;
}

.product-gallery .main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    max-height: 420px;
    min-height: 300px;
}

.product-gallery .placeholder-image {
    width: 100%;
    height: 100%;
    max-height: 420px;
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--green-pale);
    font-size: 4rem;
    color: var(--gold);
    opacity: 0.3;
}

.product-gallery .badge-stock {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 6px 16px;
    border-radius: var(--radius-pill);
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.3px;
    background: white;
    box-shadow: var(--shadow-sm);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    z-index: 2;
}

.badge-stock.ready { background: #E8F5E9; color: #2E7D32; }
.badge-stock.limited { background: #FFF3E0; color: #E65100; }
.badge-stock.soldout { background: #FCE4EC; color: #C62828; }

/* ============================================================
   PRODUCT INFO
   ============================================================ */
.product-info {
    padding-left: 8px;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-info .product-name {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 4px;
    line-height: 1.2;
}

.product-info .product-category {
    font-size: 0.8rem;
    color: var(--gray-500);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.product-info .product-category i {
    color: var(--gold);
}

.rating-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
    flex-wrap: wrap;
}

.rating-row .stars {
    display: flex;
    gap: 2px;
    color: #F1C40F;
    font-size: 0.9rem;
}

.rating-row .rating-text {
    font-size: 0.8rem;
    color: var(--gray-500);
}

.rating-row .rating-text strong {
    color: var(--gray-700);
    font-weight: 600;
}

.price-section {
    padding: 16px 0;
    border-top: 1px solid var(--gray-100);
    border-bottom: 1px solid var(--gray-100);
    margin-bottom: 16px;
}

.price-section .price-current {
    font-size: 30px;
    font-weight: 800;
    color: var(--green-deep);
    letter-spacing: -0.5px;
}

.price-section .price-original {
    font-size: 16px;
    color: var(--gray-400);
    text-decoration: line-through;
    margin-left: 12px;
    font-weight: 400;
}

.price-section .discount-badge {
    display: inline-block;
    background: #FCE4EC;
    color: #C62828;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 2px 12px;
    border-radius: var(--radius-pill);
    margin-left: 10px;
}

.stock-row {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 18px;
}

.stock-row .stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    font-weight: 500;
}

.stock-badge.available { color: #2E7D32; }
.stock-badge.limited { color: #E65100; }
.stock-badge.soldout { color: #C62828; }
.stock-badge i { font-size: 0.75rem; }

.stock-row .stock-text {
    font-size: 0.85rem;
    color: var(--gray-500);
}

.qty-section {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.qty-section .qty-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--gray-600);
}

.qty-section .qty-selector {
    display: inline-flex;
    align-items: center;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius-sm);
    background: white;
    overflow: hidden;
    transition: var(--transition);
}

.qty-section .qty-selector:hover {
    border-color: var(--gold);
}

.qty-section .qty-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: transparent;
    color: var(--gray-600);
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
}

.qty-section .qty-btn:hover {
    background: var(--gray-50);
    color: var(--green-deep);
}

.qty-section .qty-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.qty-section .qty-input {
    width: 48px;
    height: 40px;
    border: none;
    text-align: center;
    font-size: 0.95rem;
    font-weight: 600;
    background: transparent;
    padding: 0;
    -moz-appearance: textfield;
}

.qty-section .qty-input::-webkit-outer-spin-button,
.qty-section .qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.qty-section .qty-input:focus { outline: none; }

.action-row {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.btn-cart {
    flex: 1;
    background: transparent;
    border: 2px solid var(--green-deep);
    color: var(--green-deep);
    padding: 14px 24px;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-width: 140px;
    cursor: pointer;
}

.btn-cart:hover {
    background: var(--green-deep);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(26,60,42,0.20);
}

.btn-buy {
    flex: 1;
    background: var(--green-deep);
    border: 2px solid var(--green-deep);
    color: white;
    padding: 14px 24px;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-width: 140px;
    cursor: pointer;
}

.btn-buy:hover {
    background: var(--gold);
    border-color: var(--gold);
    color: var(--green-deep);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(201,168,76,0.30);
}

.btn-cart:disabled,
.btn-buy:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
}

.desc-section {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--gray-100);
    flex: 1;
}

.desc-section .desc-title {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--gray-400);
    margin-bottom: 6px;
}

.desc-section .desc-text {
    font-size: 0.92rem;
    line-height: 1.75;
    color: var(--gray-600);
}

.desc-full {
    padding: 28px 36px 34px;
    border-top: 1px solid var(--gray-100);
    background: linear-gradient(180deg, var(--cream, #FDFBF7) 0%, #fff 100%);
}

.desc-full .desc-section {
    margin: 0;
    padding: 0;
    border-top: 0;
}

.desc-full .desc-section .desc-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem;
    font-weight: 700;
    text-transform: none;
    letter-spacing: 0;
    color: var(--green-deep);
    margin-bottom: 16px;
}

.desc-full .desc-section .desc-title i {
    font-size: 1rem;
    color: var(--gold);
}

.desc-full .desc-text .desc-p { max-width: 75ch; }

@media (min-width: 768px) {
    .desc-full .desc-text .desc-list { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 767.98px) {
    .desc-full { padding: 22px 18px 26px; }
}

.desc-text .desc-lead {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    font-weight: 600;
    line-height: 1.35;
    color: var(--green-deep);
    margin: 0 0 10px;
}

.desc-text .desc-p {
    margin: 0 0 12px;
    max-width: 62ch;
}

.desc-text .desc-sub {
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--gold-dark, #9A7B2B);
    margin: 18px 0 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.desc-text .desc-sub::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--gray-100);
}

.desc-text .desc-list {
    list-style: none;
    padding: 0;
    margin: 0 0 12px;
    display: grid;
    gap: 8px;
}

.desc-text .desc-list li {
    position: relative;
    padding: 10px 14px 10px 38px;
    background: var(--cream, #FDFAF4);
    border: 1px solid rgba(74, 124, 47, .12);
    border-radius: 12px;
    line-height: 1.6;
}

.desc-text .desc-list li::before {
    content: '\f00c';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    left: 13px;
    top: 11px;
    font-size: 0.75rem;
    color: var(--green-mid, #4A7C2F);
}

.desc-text .desc-list li strong {
    color: var(--green-deep);
    font-weight: 700;
}

.meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px 16px;
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1px solid var(--gray-100);
}

.meta-grid .meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.8rem;
    color: var(--gray-500);
}

.meta-grid .meta-item i {
    color: var(--gold);
    width: 18px;
    font-size: 0.8rem;
}

/* ============================================================
   ULASAN - GAMBAR ULASAN LEBIH BESAR
   ============================================================ */
.review-section {
    background: white;
    border-radius: var(--radius-lg);
    padding: 28px 32px;
    box-shadow: var(--shadow-sm);
    margin-bottom: 24px;
}

.review-section .review-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--gray-100);
}

.review-section .review-header h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.review-section .review-header h4 i {
    color: var(--gold);
}

.review-section .review-header .summary {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: var(--gray-500);
}

.review-section .review-header .summary .avg {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--gray-900);
}

.review-section .review-header .summary .stars {
    color: #F1C40F;
    font-size: 0.85rem;
}

.review-card {
    padding: 16px 0;
    border-bottom: 1px solid var(--gray-100);
}

.review-card:last-child {
    border-bottom: none;
}

.review-card .review-avatar {
    width: 44px;
    height: 44px;
    background: var(--gold-pale);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--gold);
    flex-shrink: 0;
}

.review-card .review-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--gray-800);
}

.review-card .review-stars {
    color: #F1C40F;
    font-size: 0.75rem;
    letter-spacing: 1px;
}

.review-card .review-date {
    font-size: 0.75rem;
    color: var(--gray-400);
}

.review-card .review-comment {
    font-size: 0.9rem;
    line-height: 1.6;
    color: var(--gray-600);
    margin-top: 6px;
}

.review-card .review-reply {
    background: var(--gray-50);
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    margin-top: 10px;
    border-left: 3px solid var(--gold);
}

.review-card .review-reply .label {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--green-deep);
    display: flex;
    align-items: center;
    gap: 6px;
}

.review-card .review-reply .text {
    font-size: 0.85rem;
    color: var(--gray-600);
}

.review-card .review-photo img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: var(--radius-sm);
    cursor: pointer;
    border: 2px solid var(--gray-200);
    transition: var(--transition);
    margin-top: 8px;
}

.review-card .review-photo img:hover {
    border-color: var(--gold);
    transform: scale(1.05);
    box-shadow: var(--shadow-md);
}

.review-empty {
    text-align: center;
    padding: 40px 20px;
}

.review-empty i {
    font-size: 3rem;
    color: var(--gray-300);
    margin-bottom: 12px;
}

.review-empty h6 {
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: 4px;
}

.review-empty p {
    font-size: 0.9rem;
    color: var(--gray-400);
}

/* ============================================================
   REKOMENDASI - GAMBAR REKOMENDASI DIPERBESAR
   ============================================================ */
.recommended-section {
    margin-bottom: 32px;
}

.recommended-section .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.recommended-section .section-header h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
}

.recommended-section .section-header a {
    font-size: 0.8rem;
    color: var(--gold);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.recommended-section .section-header a:hover {
    color: var(--green-deep);
}

.rec-card {
    background: white;
    border-radius: var(--radius-md);
    overflow: hidden;
    text-decoration: none;
    transition: var(--transition);
    border: 1px solid var(--gray-100);
    height: 100%;
    display: block;
}

.rec-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--gold-pale);
}

.rec-card .rec-img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    background: var(--gray-50);
    min-height: 180px;
    max-height: 220px;
}

.rec-card .rec-img-placeholder {
    width: 100%;
    aspect-ratio: 1 / 1;
    min-height: 180px;
    max-height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--green-pale);
    font-size: 2.5rem;
    color: var(--gold);
    opacity: 0.3;
}

.rec-card .rec-body {
    padding: 14px 16px 18px;
}

.rec-card .rec-body .rec-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--gray-800);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 4px;
}

.rec-card .rec-body .rec-price {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--gold);
}

.rec-card .rec-body .rec-price .original {
    font-weight: 400;
    font-size: 0.75rem;
    color: var(--gray-400);
    text-decoration: line-through;
    margin-left: 6px;
}

/* ============================================================
   STICKY BOTTOM
   ============================================================ */
.sticky-bottom {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    padding: 12px 20px;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
    transform: translateY(100%);
    transition: transform 0.3s ease;
    z-index: 1000;
    border-top: 1px solid var(--gray-200);
    display: none;
}

.sticky-bottom.show {
    transform: translateY(0);
}

.sticky-bottom .sticky-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    max-width: 1200px;
    margin: 0 auto;
}

.sticky-bottom .sticky-price {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--green-deep);
}

.sticky-bottom .sticky-buttons {
    display: flex;
    gap: 10px;
}

.sticky-bottom .sticky-buttons .btn-cart,
.sticky-bottom .sticky-buttons .btn-buy {
    padding: 10px 20px;
    font-size: 0.85rem;
    min-width: unset;
    border-radius: var(--radius-sm);
    flex: 1;
}

/* ============================================================
   TOAST
   ============================================================ */
.toast-notif {
    position: fixed;
    bottom: 100px;
    right: 24px;
    z-index: 1100;
    background: var(--gray-900);
    color: white;
    padding: 14px 24px;
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    font-weight: 500;
    box-shadow: var(--shadow-xl);
    transform: translateX(400px);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 12px;
    max-width: 360px;
}

.toast-notif.show {
    transform: translateX(0);
}

.toast-notif i {
    color: var(--gold-light);
    font-size: 1.1rem;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 992px) {
    .product-info {
        padding-left: 0;
        margin-top: 20px;
    }

    .product-detail-card .product-body {
        padding: 20px 24px 24px;
    }

    .product-gallery {
        max-height: 350px;
        min-height: 250px;
    }

    .product-gallery .main-image {
        max-height: 350px;
        min-height: 250px;
    }

    .product-gallery .placeholder-image {
        max-height: 350px;
        min-height: 250px;
    }

    .review-card .review-photo img {
        width: 100px;
        height: 100px;
    }

    .rec-card .rec-img {
        min-height: 150px;
        max-height: 180px;
    }

    .rec-card .rec-img-placeholder {
        min-height: 150px;
        max-height: 180px;
    }
}

@media (max-width: 768px) {
    body {
        padding-top: 64px;
        padding-bottom: 80px;
    }

    .navbar-ysp {
        padding: 10px 0;
        background: rgba(255,255,255,0.98);
    }

    .navbar-brand-ysp {
        font-size: 1.2rem;
    }

    .product-detail-card .product-body {
        padding: 16px;
    }

    .product-info .product-name {
        font-size: 22px;
    }

    .price-section .price-current {
        font-size: 24px;
    }

    .action-row {
        display: none;
    }

    .sticky-bottom {
        display: block;
    }

    .meta-grid {
        grid-template-columns: 1fr;
    }

    .review-section {
        padding: 16px 18px;
    }

    .review-section .review-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .product-gallery {
        max-height: 300px;
        min-height: 200px;
    }

    .product-gallery .main-image {
        max-height: 300px;
        min-height: 200px;
    }

    .product-gallery .placeholder-image {
        max-height: 300px;
        min-height: 200px;
    }

    .review-card .review-photo img {
        width: 80px;
        height: 80px;
    }

    .rec-card .rec-img {
        min-height: 120px;
        max-height: 150px;
    }

    .rec-card .rec-img-placeholder {
        min-height: 120px;
        max-height: 150px;
    }

    .rec-card .rec-body .rec-name {
        font-size: 0.8rem;
    }

    .rec-card .rec-body .rec-price {
        font-size: 0.85rem;
    }
}

@media (min-width: 769px) {
    .sticky-bottom {
        display: none !important;
    }
}

@media (max-width: 480px) {
    .product-info .product-name {
        font-size: 18px;
    }

    .price-section .price-current {
        font-size: 20px;
    }

    .sticky-bottom .sticky-price {
        font-size: 1rem;
    }

    .sticky-bottom .sticky-buttons .btn-cart,
    .sticky-bottom .sticky-buttons .btn-buy {
        padding: 8px 14px;
        font-size: 0.75rem;
    }

    .review-card .review-reply {
        margin-left: 0;
    }

    .review-card .review-photo img {
        width: 70px;
        height: 70px;
    }

    .breadcrumb-custom {
        font-size: 0.7rem;
    }

    .product-gallery {
        max-height: 250px;
        min-height: 180px;
    }

    .product-gallery .main-image {
        max-height: 250px;
        min-height: 180px;
    }

    .product-gallery .placeholder-image {
        max-height: 250px;
        min-height: 180px;
    }

    .rec-card .rec-img {
        min-height: 100px;
        max-height: 130px;
    }

    .rec-card .rec-img-placeholder {
        min-height: 100px;
        max-height: 130px;
    }
}

/* ============================================================
   UTILITY
   ============================================================ */
.text-gold { color: var(--gold); }
.bg-gold-light { background: var(--gold-pale); }
.gap-2 { gap: 0.5rem; }
.gap-3 { gap: 1rem; }
.fw-600 { font-weight: 600; }
.fw-700 { font-weight: 700; }
.fw-800 { font-weight: 800; }
.fs-small { font-size: 0.8rem; }

/* ============================================================
   SCROLLBAR
   ============================================================ */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: var(--gray-100); }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: var(--gold-light); }

/* ============================================================
   SELECTION
   ============================================================ */
::selection {
    background: var(--gold);
    color: white;
}

/* ============================================================
   PRINT STYLES - OPTIMAL UNTUK CETAK
   ============================================================ */
@media print {
    /* Reset dasar */
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }

    body {
        padding: 0 !important;
        margin: 0 !important;
        background: white !important;
        font-size: 10px !important;
        line-height: 1.4 !important;
        min-height: auto !important;
    }

    /* Sembunyikan elemen yang tidak perlu */
    .navbar-ysp,
    .cart-icon,
    .btn-user-dropdown,
    .btn-nav-login,
    .btn-nav-register,
    .navbar-toggler,
    .action-row .btn-cart,
    .action-row .btn-buy,
    .qty-section,
    .sticky-bottom,
    .toast-notif,
    .recommended-section,
    .no-print {
        display: none !important;
    }

    /* Header produk */
    .product-detail-card {
        border-radius: 0 !important;
        box-shadow: none !important;
        border: none !important;
        margin: 0 !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .product-detail-card .product-body {
        padding: 12px 16px !important;
    }

    .product-gallery {
        max-height: 200px !important;
        min-height: 150px !important;
        border-radius: 4px !important;
    }

    .product-gallery .main-image {
        max-height: 200px !important;
        min-height: 150px !important;
    }

    .product-gallery .placeholder-image {
        max-height: 200px !important;
        min-height: 150px !important;
        font-size: 2rem !important;
    }

    .product-gallery .badge-stock {
        font-size: 6px !important;
        padding: 3px 10px !important;
        top: 8px !important;
        left: 8px !important;
    }

    .product-info {
        padding-left: 0 !important;
        margin-top: 8px !important;
    }

    .product-info .product-name {
        font-size: 16px !important;
        margin-bottom: 2px !important;
    }

    .product-info .product-category {
        font-size: 8px !important;
        margin-bottom: 6px !important;
    }

    .rating-row {
        margin-bottom: 6px !important;
        gap: 6px !important;
    }

    .rating-row .stars {
        font-size: 8px !important;
    }

    .rating-row .rating-text {
        font-size: 7px !important;
    }

    .price-section {
        padding: 8px 0 !important;
        margin-bottom: 8px !important;
    }

    .price-section .price-current {
        font-size: 18px !important;
    }

    .price-section .price-original {
        font-size: 10px !important;
        margin-left: 6px !important;
    }

    .price-section .discount-badge {
        font-size: 6px !important;
        padding: 1px 8px !important;
        margin-left: 6px !important;
    }

    .stock-row {
        margin-bottom: 8px !important;
        gap: 8px !important;
    }

    .stock-row .stock-badge {
        font-size: 8px !important;
    }

    .stock-row .stock-text {
        font-size: 8px !important;
    }

    .desc-section {
        margin-top: 8px !important;
        padding-top: 8px !important;
    }

    .desc-section .desc-title {
        font-size: 7px !important;
        margin-bottom: 4px !important;
    }

    .desc-section .desc-text {
        font-size: 8px !important;
        line-height: 1.5 !important;
    }

    .meta-grid {
        grid-template-columns: 1fr 1fr !important;
        gap: 3px 12px !important;
        margin-top: 8px !important;
        padding-top: 8px !important;
    }

    .meta-grid .meta-item {
        font-size: 7px !important;
        gap: 4px !important;
    }

    .meta-grid .meta-item i {
        font-size: 7px !important;
        width: 14px !important;
    }

    /* Ulasan */
    .review-section {
        border-radius: 0 !important;
        padding: 12px 16px !important;
        box-shadow: none !important;
        margin-bottom: 0 !important;
        border-top: 1px solid var(--gray-200) !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .review-section .review-header {
        margin-bottom: 10px !important;
        padding-bottom: 8px !important;
    }

    .review-section .review-header h4 {
        font-size: 10px !important;
    }

    .review-section .review-header .summary {
        font-size: 8px !important;
    }

    .review-section .review-header .summary .avg {
        font-size: 9px !important;
    }

    .review-section .review-header .summary .stars {
        font-size: 7px !important;
    }

    .review-card {
        padding: 8px 0 !important;
    }

    .review-card .review-avatar {
        width: 28px !important;
        height: 28px !important;
        font-size: 7px !important;
    }

    .review-card .review-name {
        font-size: 8px !important;
    }

    .review-card .review-stars {
        font-size: 6px !important;
        letter-spacing: 0.5px !important;
    }

    .review-card .review-date {
        font-size: 6px !important;
    }

    .review-card .review-comment {
        font-size: 8px !important;
        line-height: 1.4 !important;
        margin-top: 4px !important;
    }

    .review-card .review-reply {
        padding: 6px 10px !important;
        margin-top: 6px !important;
        border-left-width: 2px !important;
    }

    .review-card .review-reply .label {
        font-size: 6px !important;
    }

    .review-card .review-reply .text {
        font-size: 7px !important;
    }

    .review-card .review-photo img {
        width: 60px !important;
        height: 60px !important;
        margin-top: 4px !important;
        border-width: 1px !important;
    }

    .review-empty {
        padding: 20px !important;
    }

    .review-empty i {
        font-size: 2rem !important;
    }

    .review-empty h6 {
        font-size: 9px !important;
    }

    .review-empty p {
        font-size: 8px !important;
    }

    /* Breadcrumb */
    .breadcrumb-custom {
        padding: 8px 0 4px !important;
        font-size: 7px !important;
    }

    .breadcrumb-custom .separator {
        margin: 0 4px !important;
    }

    /* Page setup */
    @page {
        size: A4;
        margin: 6mm 5mm !important;
    }

    /* Hilangkan hover effect */
    .rec-card:hover,
    .btn-cart:hover,
    .btn-buy:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    /* Sembunyikan elemen interaktif */
    .action-row {
        display: none !important;
    }

    /* Pastikan warna tercetak */
    .badge-stock,
    .badge-stock.ready,
    .badge-stock.limited,
    .badge-stock.soldout,
    .price-section .discount-badge {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* Container */
    .container {
        max-width: 100% !important;
        padding: 0 8px !important;
        margin: 0 !important;
    }

    /* Row dan col */
    .row {
        display: block !important;
    }

    .col-lg-6 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }

    /* Pastikan tidak ada page break di dalam card */
    .product-detail-card,
    .review-section {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }
}
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">
</head>

<body class="mf-body">

<!-- ============================================================
NAVBAR
============================================================ -->
<?= view('layout/mf_header', ['mfActive' => 'produk']) ?>

<!-- ============================================================
MAIN CONTENT
============================================================ -->
<div class="container">

    <!-- Breadcrumb -->
    <div class="breadcrumb-custom">
        <a href="<?= base_url('/') ?>">Beranda</a>
        <span class="separator">/</span>
        <a href="<?= base_url('shop') ?>">Produk</a>
        <span class="separator">/</span>
        <span class="current"><?= esc($produk['nama_barang'] ?? 'Detail Produk') ?></span>
    </div>

    <!-- Product Detail -->
    <div class="product-detail-card">
        <div class="row g-0">
            <!-- Gallery - Gambar Produk  -->
            <div class="col-lg-6">
                <div class="product-gallery">
                    <?php if (!empty($produk['gambar']) && file_exists(FCPATH . 'uploads/' . $produk['gambar'])): ?>
                        <img src="<?= base_url('uploads/' . $produk['gambar']) ?>" 
                             alt="<?= esc($produk['nama_barang']) ?>" 
                             class="main-image">
                    <?php else: ?>
                        <div class="placeholder-image">
                            <i class="fas fa-leaf"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Badge -->
                    <?php if ($produk['stok'] <= 0): ?>
                        <span class="badge-stock soldout"><i class="fas fa-times-circle"></i> Stok Habis</span>
                    <?php elseif ($produk['stok'] <= 5): ?>
                        <span class="badge-stock limited"><i class="fas fa-exclamation-triangle"></i> Stok Terbatas</span>
                    <?php else: ?>
                        <span class="badge-stock ready"><i class="fas fa-check-circle"></i> Tersedia</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info -->
            <div class="col-lg-6">
                <div class="product-body">
                    <div class="product-info">

                        <!-- Hidden Fields -->
                        <input type="hidden" id="productId" value="<?= $produk['id'] ?>">
                        <input type="hidden" id="maxStock" value="<?= $produk['stok'] ?>">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfToken">

                        <!-- Name -->
                        <h1 class="product-name"><?= esc($produk['nama_barang'] ?? 'Produk') ?></h1>
                        <div class="product-category">
                            <i class="fas fa-tag"></i> 
                            <?= isset($produk['kategori']) ? esc($produk['kategori']) : 'Produk Premium' ?>
                        </div>

                        <!-- Rating -->
                        <div class="rating-row">
                            <div class="stars">
                                <?php 
                                $avgRating = $rataRating ?? 0;
                                $full = floor($avgRating);
                                $half = ($avgRating - $full) >= 0.5;
                                $empty = 5 - $full - ($half ? 1 : 0);
                                ?>
                                <?php for ($i = 1; $i <= $full; $i++): ?>
                                    <i class="fas fa-star"></i>
                                <?php endfor; ?>
                                <?php if ($half): ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $empty; $i++): ?>
                                    <i class="far fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="rating-text">
                                <strong><?= number_format($avgRating, 1) ?></strong> · <?= $totalUlasan ?? 0 ?> ulasan
                            </span>
                        </div>

                        <!-- Price -->
                        <div class="price-section">
                            <?php 
                            $isPromo = isset($produk['is_promo']) && $produk['is_promo'] && ($produk['harga_diskon'] ?? 0) > 0;
                            $finalPrice = $isPromo ? $produk['harga_diskon'] : ($produk['harga'] ?? 0);
                            ?>
                            <span class="price-current">Rp <?= number_format($finalPrice, 0, ',', '.') ?></span>
                            <?php if ($isPromo): ?>
                                <span class="price-original">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span>
                                <span class="discount-badge">
                                    -<?= round((($produk['harga'] - $produk['harga_diskon']) / $produk['harga']) * 100) ?>%
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Stock -->
                        <div class="stock-row">
                            <?php if ($produk['stok'] > 0): ?>
                                <span class="stock-badge available">
                                    <i class="fas fa-check-circle"></i> Tersedia
                                </span>
                                <span class="stock-text">Stok: <?= $produk['stok'] ?> unit</span>
                            <?php else: ?>
                                <span class="stock-badge soldout">
                                    <i class="fas fa-times-circle"></i> Stok Habis
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Quantity -->
                        <div class="qty-section">
                            <span class="qty-label">Jumlah</span>
                            <div class="qty-selector">
                                <button type="button" class="qty-btn" id="qtyMinus">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantityInput" class="qty-input" value="1" min="1" max="<?= $produk['stok'] ?>" readonly>
                                <button type="button" class="qty-btn" id="qtyPlus">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Buttons Desktop -->
                        <div class="action-row">
                            <?php if (session()->get('pelanggan_id')): ?>
                                <?php if ($produk['stok'] > 0): ?>
                                    <button class="btn-cart" id="addToCartBtn">
                                        <i class="fas fa-shopping-bag"></i> Tambah Keranjang
                                    </button>
                                    <button class="btn-buy" id="buyNowBtn">
                                        <i class="fas fa-bolt"></i> Beli Sekarang
                                    </button>
                                <?php else: ?>
                                    <button class="btn-cart" disabled><i class="fas fa-times-circle"></i> Stok Habis</button>
                                    <button class="btn-buy" disabled><i class="fas fa-times-circle"></i> Stok Habis</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?= base_url('login') ?>" class="btn-cart">
                                    <i class="fas fa-lock"></i> Login
                                </a>
                                <a href="<?= base_url('register') ?>" class="btn-buy" style="background: var(--gold); border-color: var(--gold); color: var(--green-deep);">
                                    <i class="fas fa-user-plus"></i> Daftar
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Meta -->
                        <div class="meta-grid">
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                <span>SKU: YSP-<?= str_pad($produk['id'], 4, '0', STR_PAD_LEFT) ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-leaf"></i>
                                <span>100% Fresh Premium</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-truck"></i>
                                <span>Pengiriman Cepat</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Kualitas Terjamin</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Description (lebar penuh) -->
        <div class="desc-full">
            <div class="desc-section">
                <div class="desc-title"><i class="fas fa-leaf"></i> Deskripsi Produk</div>
                <div class="desc-text">
                    <?= !empty($produk['deskripsi'])
                        ? format_deskripsi($produk['deskripsi'])
                        : 'Nikmati kesegaran melati pilihan berkualitas premium dari kebun terbaik. Setiap bunga dipetik dengan tangan pada waktu yang tepat untuk memastikan aroma dan keindahan yang maksimal. Cocok untuk berbagai keperluan seperti hiasan, rangkaian bunga, atau hadiah istimewa.' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================
    ULASAN - Gambar Ulasan 
    ============================================================ -->
    <section class="review-section">
        <div class="review-header">
            <h4>
                <i class="fas fa-star"></i> Ulasan Pelanggan
            </h4>
            <div class="summary">
                <span class="avg"><?= number_format($avgRating ?? 0, 1) ?></span>
                <span class="stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star<?= $i <= round($avgRating ?? 0) ? '' : '-o' ?>"></i>
                    <?php endfor; ?>
                </span>
                <span>(<?= $totalUlasan ?? 0 ?> ulasan)</span>
            </div>
        </div>

        <?php if (!empty($ulasan)): ?>
            <?php foreach ($ulasan as $u): ?>
                <div class="review-card">
                    <div class="d-flex gap-3">
                        <div class="review-avatar">
                            <?= strtoupper(substr($u['nama_pelanggan'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <div class="review-name"><?= esc($u['nama_pelanggan'] ?? 'Pengguna') ?></div>
                                    <div class="review-stars mt-1">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star<?= $i <= ($u['rating'] ?? 0) ? '' : '-o' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="review-date"><?= date('d M Y', strtotime($u['tanggal_ulasan'] ?? 'now')) ?></div>
                            </div>
                            <div class="review-comment">"<?= esc($u['komentar']) ?>"</div>
                            
                            <!-- Gambar Ulasan Diperbesar -->
                            <?php if (!empty($u['foto_ulasan']) && file_exists(FCPATH . 'uploads/ulasan/' . $u['foto_ulasan'])): ?>
                                <div class="review-photo mt-2">
                                    <img src="<?= base_url('uploads/ulasan/' . $u['foto_ulasan']) ?>" 
                                         alt="Foto Ulasan" 
                                         onclick="window.open(this.src)">
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($u['balasan'])): ?>
                                <div class="review-reply">
                                    <div class="label"><i class="fas fa-reply"></i> Balasan Admin</div>
                                    <div class="text"><?= esc($u['balasan']) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="review-empty">
                <i class="far fa-star"></i>
                <h6>Belum Ada Ulasan</h6>
                <p>Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- ============================================================
    Gambar Rekomendasi 
    ============================================================ -->
    <?php if (!empty($rekomendasi) && count($rekomendasi) > 1): ?>
    <section class="recommended-section">
        <div class="section-header">
            <h4>Anda Mungkin Juga Suka</h4>
            <a href="<?= base_url('shop') ?>">Lihat Semua <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="row g-3">
            <?php foreach ($rekomendasi as $rec): ?>
                <?php if ($rec['id'] == $produk['id']) continue; ?>
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="<?= base_url('shop/detail/' . $rec['id']) ?>" class="rec-card">
                        <!-- Gambar Rekomendasi Diperbesar -->
                        <?php if (!empty($rec['gambar']) && file_exists(FCPATH . 'uploads/' . $rec['gambar'])): ?>
                            <img src="<?= base_url('uploads/' . $rec['gambar']) ?>" alt="<?= esc($rec['nama_barang']) ?>" class="rec-img" loading="lazy">
                        <?php else: ?>
                            <div class="rec-img-placeholder"><i class="fas fa-flower"></i></div>
                        <?php endif; ?>
                        <div class="rec-body">
                            <div class="rec-name"><?= esc($rec['nama_barang']) ?></div>
                            <div class="rec-price">
                                Rp <?= number_format($rec['harga'] ?? 0, 0, ',', '.') ?>
                                <?php if (isset($rec['is_promo']) && $rec['is_promo'] && ($rec['harga_diskon'] ?? 0) > 0): ?>
                                    <span class="original">Rp <?= number_format($rec['harga'], 0, ',', '.') ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</div>

<!-- ============================================================
STICKY BOTTOM
============================================================ -->
<div class="sticky-bottom" id="stickyBottom">
    <div class="sticky-content">
        <div class="sticky-price">
            Rp <?= number_format($finalPrice ?? 0, 0, ',', '.') ?>
        </div>
        <div class="sticky-buttons">
            <?php if (session()->get('pelanggan_id')): ?>
                <?php if ($produk['stok'] > 0): ?>
                    <button class="btn-cart" id="stickyAddToCartBtn">
                        <i class="fas fa-shopping-bag"></i> Keranjang
                    </button>
                    <button class="btn-buy" id="stickyBuyNowBtn">
                        <i class="fas fa-bolt"></i> Beli
                    </button>
                <?php else: ?>
                    <button class="btn-cart" disabled>Stok Habis</button>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="btn-cart">Login</a>
                <a href="<?= base_url('register') ?>" class="btn-buy" style="background: var(--gold); border-color: var(--gold); color: var(--green-deep);">Daftar</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ============================================================
TOAST
============================================================ -->
<div class="toast-notif" id="toastNotif">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">Produk ditambahkan ke keranjang</span>
</div>

<!-- ============================================================
SCRIPTS
============================================================ -->
<?= view('layout/mf_footer') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ===== NAVBAR SCROLL =====
    const nav = document.getElementById('mainNav');
    if (nav) {
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });
    }

    // ===== QUANTITY =====
    const qtyInput = document.getElementById('quantityInput');
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus = document.getElementById('qtyPlus');
    const maxStock = parseInt(document.getElementById('maxStock')?.value || 0);
    const productId = document.getElementById('productId')?.value;
    let currentQty = 1;

    function updateQty() {
        if (qtyInput) qtyInput.value = currentQty;
        if (qtyMinus) qtyMinus.disabled = currentQty <= 1;
        if (qtyPlus) qtyPlus.disabled = currentQty >= maxStock;
    }

    if (qtyMinus) {
        qtyMinus.addEventListener('click', () => {
            if (currentQty > 1) { currentQty--; updateQty(); }
        });
    }

    if (qtyPlus) {
        qtyPlus.addEventListener('click', () => {
            if (currentQty < maxStock) { currentQty++; updateQty(); }
        });
    }

    updateQty();

    // ===== TOAST =====
    function showToast(message, isError = false) {
        const toast = document.getElementById('toastNotif');
        const msg = document.getElementById('toastMessage');
        const icon = toast.querySelector('i');
        
        msg.textContent = message;
        toast.style.background = isError ? '#C62828' : '#212121';
        icon.className = isError ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
        
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // ===== ADD TO CART =====
    async function addToCart() {
        if (maxStock <= 0) {
            showToast('Stok produk habis', true);
            return false;
        }

        const csrfToken = document.getElementById('csrfToken')?.value;
        const csrfName = '<?= csrf_token() ?>';

        try {
            const formData = new FormData();
            formData.append('quantity', currentQty);
            if (csrfToken) formData.append(csrfName, csrfToken);

            const response = await fetch('<?= base_url("shop/addToCart/" . ($produk['id'] ?? 0)) ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await response.json();

            if (data.success) {
                showToast('✓ Berhasil ditambahkan ke keranjang');
                const countEl = document.querySelector('.cart-count');
                if (countEl && data.cart_count !== undefined) {
                    countEl.textContent = data.cart_count;
                }
                return true;
            } else {
                if (data.redirect) {
                    window.location.href = data.redirect;
                    return false;
                }
                showToast(data.message || 'Gagal menambahkan', true);
                return false;
            }
        } catch (error) {
            showToast('Terjadi kesalahan, coba lagi', true);
            return false;
        }
    }

    async function buyNow() {
        const added = await addToCart();
        if (added) {
            window.location.href = '<?= base_url("shop/checkout") ?>';
        }
    }

    // ===== EVENT LISTENERS =====
    document.getElementById('addToCartBtn')?.addEventListener('click', addToCart);
    document.getElementById('buyNowBtn')?.addEventListener('click', buyNow);
    document.getElementById('stickyAddToCartBtn')?.addEventListener('click', addToCart);
    document.getElementById('stickyBuyNowBtn')?.addEventListener('click', buyNow);

    // ===== STICKY BOTTOM =====
    const sticky = document.getElementById('stickyBottom');
    let lastScroll = 0;

    function handleSticky() {
        if (window.innerWidth <= 768) {
            const scrollY = window.scrollY;
            const info = document.querySelector('.product-info');
            if (info) {
                const bottom = info.getBoundingClientRect().bottom;
                if (bottom < 60 || (scrollY > lastScroll && scrollY > 150)) {
                    sticky.classList.add('show');
                } else {
                    sticky.classList.remove('show');
                }
            }
            lastScroll = scrollY;
        }
    }

    window.addEventListener('scroll', handleSticky);
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) sticky.classList.remove('show');
        else handleSticky();
    });

    handleSticky();
});
</script>

</body>
</html>