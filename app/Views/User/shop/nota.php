<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pesanan | YSP Jasmine</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --gold-pale: #F5EDD3;
            --green-deep: #2D5016;
            --green-mid: #4A7C2F;
            --green-fresh: #6BA847;
            --green-pale: #EBF4E3;
            --cream: #FDFAF4;
            --white: #FFFFFF;
            --text-dark: #1A2A0E;
            --text-mid: #4A5E37;
            --text-muted: #8A9E78;
            --shadow-sm: 0 2px 12px rgba(45, 80, 22, 0.06);
            --shadow-md: 0 8px 32px rgba(45, 80, 22, 0.10);
            --shadow-lg: 0 16px 48px rgba(45, 80, 22, 0.12);
            --radius-card: 20px;
            --radius-pill: 50px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8F6F0;
            color: var(--text-dark);
            padding-top: 80px;
            padding-bottom: 40px;
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        h4,
        .display-font {
            font-family: 'Playfair Display', serif;
        }

        /* ===== NAVBAR ===== */
        .navbar-ysp {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 10px 0;
            background: rgba(253, 250, 244, 0.97);
            backdrop-filter: blur(20px);
            box-shadow: 0 1px 20px rgba(45, 80, 22, 0.05);
            transition: var(--transition);
        }

        .navbar-ysp.scrolled {
            box-shadow: 0 4px 30px rgba(45, 80, 22, 0.08);
        }

        .navbar-brand-ysp {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--green-deep) !important;
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .navbar-brand-ysp span {
            color: var(--gold);
        }

        .nav-link-ysp {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-mid) !important;
            padding: 6px 16px !important;
            transition: var(--transition);
            border-radius: 8px;
            text-decoration: none;
        }

        .nav-link-ysp:hover {
            color: var(--gold) !important;
            background: var(--gold-pale);
        }

        .btn-nav-login {
            font-size: 0.8rem;
            font-weight: 500;
            padding: 6px 20px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--green-mid);
            color: var(--green-mid) !important;
            transition: var(--transition);
            background: transparent;
            text-decoration: none;
        }

        .btn-nav-login:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: white !important;
        }

        .btn-nav-register {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 20px;
            border-radius: var(--radius-pill);
            background: var(--gold);
            border: 1.5px solid var(--gold);
            color: white !important;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-nav-register:hover {
            background: var(--gold-light);
            border-color: var(--gold-light);
            transform: translateY(-1px);
        }

        /* ===== NOTA STYLES ===== */
        .nota-wrapper {
            max-width: 820px;
            margin: 0 auto;
        }

        .nota-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .nota-header h1 {
            font-size: 2rem;
            font-weight: 400;
            color: var(--green-deep);
            letter-spacing: -0.5px;
        }

        .nota-header h1 em {
            font-style: italic;
            color: var(--gold);
            font-weight: 600;
        }

        .nota-header .subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .divider-gold {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            margin: 10px auto 0;
            border-radius: 4px;
        }

        /* Nota Card */
        .nota-card {
            background: var(--white);
            border-radius: var(--radius-card);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .nota-card:hover {
            box-shadow: var(--shadow-lg);
        }

        /* Header Invoice */
        .nota-header-invoice {
            background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
            padding: 20px 28px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .nota-header-invoice::after {
            content: '✦';
            position: absolute;
            right: 20px;
            top: -10px;
            font-size: 6rem;
            opacity: 0.06;
            font-family: serif;
        }

        .invoice-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .invoice-title small {
            font-size: 0.65rem;
            font-weight: 400;
            opacity: 0.7;
            display: block;
            font-family: 'Inter', sans-serif;
            letter-spacing: 1px;
        }

        .invoice-number {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 1px;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 16px;
            border-radius: 8px;
            display: inline-block;
        }

        .invoice-date {
            font-size: 0.75rem;
            opacity: 0.75;
            margin-top: 4px;
        }

        /* Nota Body */
        .nota-body {
            padding: 28px 32px;
        }

        /* Status Badge */
        .status-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: var(--radius-pill);
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-pending {
            background: #FFF8E1;
            color: #F57C00;
        }

        .badge-proses {
            background: #E3F2FD;
            color: #1565C0;
        }

        .badge-selesai {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .badge-batal {
            background: #FFEBEE;
            color: #C62828;
        }

        .badge-status .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .badge-pending .dot {
            background: #F57C00;
        }
        .badge-proses .dot {
            background: #1565C0;
        }
        .badge-selesai .dot {
            background: #2E7D32;
        }
        .badge-batal .dot {
            background: #C62828;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            background: var(--cream);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 24px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .info-item .label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
        }

        .info-item .value {
            font-weight: 600;
            color: var(--green-deep);
            font-size: 0.9rem;
        }

        .info-item .value .icon {
            color: var(--gold);
            margin-right: 6px;
            width: 18px;
        }

        .info-item .value small {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        /* Timeline */
        .timeline-section {
            margin-bottom: 24px;
        }

        .timeline-section .title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        .timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            padding: 0 8px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 16px;
            left: 12%;
            right: 12%;
            height: 2px;
            background: rgba(74, 124, 47, 0.12);
            z-index: 0;
        }

        .timeline-step {
            text-align: center;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .timeline-icon {
            width: 34px;
            height: 34px;
            background: var(--white);
            border: 2px solid rgba(74, 124, 47, 0.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            font-size: 0.75rem;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .timeline-step.completed .timeline-icon {
            background: var(--gold);
            border-color: var(--gold);
            color: white;
        }

        .timeline-step.active .timeline-icon {
            border-color: var(--gold);
            background: var(--gold-pale);
            color: var(--gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%,
            100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .timeline-label {
            font-size: 0.65rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .timeline-step.completed .timeline-label {
            color: var(--green-deep);
            font-weight: 600;
        }

        /* Product Table */
        .product-section {
            margin-bottom: 20px;
        }

        .product-section .section-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--green-deep);
            margin-bottom: 12px;
        }

        .product-section .section-title .icon {
            color: var(--gold);
            margin-right: 8px;
        }

        .table-items {
            width: 100%;
            font-size: 0.85rem;
        }

        .table-items thead th {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            padding: 10px 0 8px;
            border-bottom: 2px solid rgba(74, 124, 47, 0.08);
        }

        .table-items tbody td {
            padding: 12px 0;
            border-bottom: 1px solid rgba(74, 124, 47, 0.05);
            vertical-align: middle;
        }

        .product-name {
            font-weight: 600;
            color: var(--green-deep);
            font-size: 0.9rem;
        }

        .product-name .badge-po {
            display: inline-block;
            background: #FF6B35;
            color: white;
            font-size: 0.55rem;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 20px;
            margin-left: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-name .badge-po i {
            margin-right: 4px;
        }

        .product-info {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .product-info .po-detail {
            color: #FF6B35;
            font-weight: 500;
            margin-right: 12px;
        }

        .product-info .po-detail i {
            margin-right: 4px;
        }

        .product-info .ready-detail {
            color: var(--green-mid);
            font-weight: 500;
        }

        .product-info .ready-detail i {
            margin-right: 4px;
        }

        .product-sku {
            font-size: 0.65rem;
            color: var(--text-muted);
        }

        .product-price {
            font-weight: 500;
            color: var(--text-mid);
        }

        .product-subtotal {
            font-weight: 700;
            color: var(--gold);
        }

        /* Total */
        .total-section {
            background: var(--cream);
            border-radius: 16px;
            padding: 20px 24px;
            margin-top: 4px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 0.9rem;
        }

        .total-row .label {
            color: var(--text-mid);
        }

        .total-row .amount {
            font-weight: 500;
        }

        .total-row .amount.free {
            color: #4CAF50;
            font-weight: 400;
            font-size: 0.8rem;
        }

        .grand-total {
            border-top: 2px solid var(--gold);
            margin-top: 10px;
            padding-top: 14px;
            font-size: 1.1rem;
        }

        .grand-total .label {
            font-weight: 700;
            color: var(--green-deep);
            font-size: 1.1rem;
        }

        .grand-total .amount {
            font-weight: 700;
            color: var(--gold);
            font-size: 1.2rem;
        }

        /* Notes */
        .notes-box {
            background: var(--gold-pale);
            border-radius: 12px;
            padding: 12px 18px;
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notes-box .icon {
            color: var(--gold);
            font-size: 1rem;
        }

        .notes-box .text {
            font-size: 0.75rem;
            color: var(--text-mid);
            margin: 0;
        }

        /* Actions */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(201, 168, 76, 0.12);
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 28px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--green-mid);
            color: var(--green-mid);
            background: transparent;
            font-weight: 600;
            font-size: 0.8rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-print:hover {
            background: var(--green-mid);
            color: white;
            transform: translateY(-2px);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 28px;
            border-radius: var(--radius-pill);
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border: none;
            color: var(--green-deep);
            font-weight: 600;
            font-size: 0.8rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-gold);
            color: var(--green-deep);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state .icon {
            font-size: 4rem;
            color: var(--text-muted);
            opacity: 0.3;
            margin-bottom: 16px;
        }

        .empty-state h5 {
            color: var(--green-deep);
            margin-bottom: 8px;
        }

        /* ===== FOOTER ===== */
        footer {
            background: var(--green-deep);
            color: rgba(255, 255, 255, 0.75);
            padding: 48px 0 24px;
            margin-top: 60px;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--gold-light);
            margin-bottom: 8px;
        }

        .footer-desc {
            font-size: 0.8rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.5);
        }

        .footer-heading {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold-light);
            margin-bottom: 14px;
        }

        .footer-link {
            display: block;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            margin-bottom: 6px;
            transition: var(--transition);
        }

        .footer-link:hover {
            color: var(--gold-light);
        }

        .social-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.06);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: var(--transition);
            margin-right: 4px;
        }

        .social-btn:hover {
            background: var(--gold);
            color: white;
        }

        .footer-divider {
            border-color: rgba(255, 255, 255, 0.06);
            margin: 24px 0 16px;
        }

        .copyright {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.3);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
                padding-bottom: 20px;
            }

            .nota-body {
                padding: 20px 16px;
            }

            .nota-header-invoice {
                padding: 16px 20px;
            }

            .info-grid {
                grid-template-columns: 1fr 1fr;
                padding: 16px;
            }

            .timeline {
                flex-wrap: wrap;
                gap: 8px;
            }

            .timeline::before {
                display: none;
            }

            .timeline-step {
                flex: 1;
                min-width: 60px;
            }

            .timeline-icon {
                width: 28px;
                height: 28px;
                font-size: 0.6rem;
            }

            .table-items {
                font-size: 0.75rem;
            }

            .table-items thead th {
                font-size: 0.55rem;
            }

            .table-items tbody td {
                padding: 8px 0;
            }

            .product-name {
                font-size: 0.8rem;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-print,
            .btn-back {
                width: 100%;
                justify-content: center;
                padding: 12px;
            }

            .total-section {
                padding: 16px;
            }

            .grand-total {
                font-size: 1rem;
            }

            .grand-total .amount {
                font-size: 1.1rem;
            }

            .nota-header h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .status-section {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* ===== PRINT STYLES - OPTIMAL 1 LEMBAR ===== */
        @media print {
            /* Reset dasar untuk print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            body {
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
                font-size: 11px !important;
                line-height: 1.4 !important;
                min-height: auto !important;
            }

            /* Sembunyikan elemen yang tidak perlu */
            .navbar-ysp,
            .action-buttons,
            footer,
            .no-print,
            .btn-print,
            .btn-back,
            #mainNav,
            .nota-header .subtitle,
            .nota-header .divider-gold {
                display: none !important;
            }

            /* Wrapper nota */
            .nota-wrapper {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Header utama */
            .nota-header {
                margin-bottom: 8px !important;
                padding: 0 !important;
            }

            .nota-header h1 {
                font-size: 16px !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .nota-header h1 em {
                font-size: 16px !important;
            }

            /* Card nota */
            .nota-card {
                border-radius: 0 !important;
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .nota-card:hover {
                box-shadow: none !important;
            }

            /* Header invoice */
            .nota-header-invoice {
                padding: 10px 16px !important;
                background: #2D5016 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .nota-header-invoice::after {
                display: none !important;
            }

            .invoice-title {
                font-size: 14px !important;
            }

            .invoice-title small {
                font-size: 8px !important;
            }

            .invoice-number {
                font-size: 12px !important;
                padding: 2px 12px !important;
            }

            .invoice-date {
                font-size: 9px !important;
            }

            /* Body nota */
            .nota-body {
                padding: 12px 16px !important;
            }

            /* Status */
            .status-section {
                margin-bottom: 10px !important;
                gap: 6px !important;
            }

            .badge-status {
                font-size: 8px !important;
                padding: 4px 12px !important;
                border-radius: 20px !important;
            }

            .badge-status .dot {
                width: 5px !important;
                height: 5px !important;
            }

            /* Timeline - lebih kompak */
            .timeline-section {
                margin-bottom: 8px !important;
            }

            .timeline-section .title {
                font-size: 8px !important;
                margin-bottom: 6px !important;
            }

            .timeline {
                padding: 0 4px !important;
                gap: 0 !important;
            }

            .timeline::before {
                top: 10px !important;
                left: 8% !important;
                right: 8% !important;
                height: 1.5px !important;
            }

            .timeline-icon {
                width: 20px !important;
                height: 20px !important;
                font-size: 8px !important;
                margin-bottom: 3px !important;
                border-width: 1.5px !important;
            }

            .timeline-label {
                font-size: 7px !important;
            }

            /* Info grid - lebih kompak */
            .info-grid {
                padding: 10px 14px !important;
                margin-bottom: 10px !important;
                gap: 6px 12px !important;
                border-radius: 10px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .info-item .label {
                font-size: 7px !important;
                letter-spacing: 0.5px !important;
            }

            .info-item .value {
                font-size: 9px !important;
            }

            .info-item .value .icon {
                font-size: 8px !important;
                width: 14px !important;
            }

            .info-item .value small {
                font-size: 7px !important;
            }

            /* Tabel produk - lebih kompak */
            .product-section {
                margin-bottom: 8px !important;
            }

            .product-section .section-title {
                font-size: 9px !important;
                margin-bottom: 6px !important;
            }

            .product-section .section-title .icon {
                font-size: 8px !important;
            }

            .table-items {
                font-size: 9px !important;
            }

            .table-items thead th {
                font-size: 7px !important;
                padding: 4px 0 !important;
                letter-spacing: 0.5px !important;
                border-bottom-width: 1px !important;
            }

            .table-items tbody td {
                padding: 4px 0 !important;
                border-bottom-width: 0.5px !important;
            }

            .product-name {
                font-size: 9px !important;
            }

            .product-name .badge-po {
                font-size: 6px !important;
                padding: 1px 6px !important;
                margin-left: 4px !important;
            }

            .product-info {
                font-size: 6.5px !important;
            }

            .product-sku {
                font-size: 6.5px !important;
            }

            .product-price {
                font-size: 9px !important;
            }

            .product-subtotal {
                font-size: 9px !important;
            }

            /* Total - lebih kompak */
            .total-section {
                padding: 10px 14px !important;
                margin-top: 2px !important;
                border-radius: 10px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .total-row {
                padding: 3px 0 !important;
                font-size: 9px !important;
            }

            .grand-total {
                margin-top: 4px !important;
                padding-top: 6px !important;
                border-top-width: 1.5px !important;
            }

            .grand-total .label {
                font-size: 10px !important;
            }

            .grand-total .amount {
                font-size: 11px !important;
            }

            /* Notes */
            .notes-box {
                padding: 6px 12px !important;
                margin-top: 8px !important;
                border-radius: 8px !important;
                gap: 6px !important;
            }

            .notes-box .icon {
                font-size: 9px !important;
            }

            .notes-box .text {
                font-size: 8px !important;
            }

            /* Pastikan tidak ada page break di dalam card */
            .nota-card,
            .nota-body,
            .status-section,
            .info-grid,
            .product-section,
            .total-section {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Hilangkan jarak berlebih */
            .container {
                padding: 0 !important;
                max-width: 100% !important;
            }

            /* Empty state */
            .empty-state {
                padding: 30px 20px !important;
            }

            .empty-state .icon {
                font-size: 32px !important;
            }

            .empty-state h5 {
                font-size: 13px !important;
            }

            .empty-state p {
                font-size: 9px !important;
            }

            /* Aturan tambahan untuk memastikan 1 lembar */
            @page {
                size: A4;
                margin: 8mm 6mm !important;
            }

            /* Aturan untuk elemen yang tidak mau pecah */
            .nota-card {
                max-width: 100% !important;
            }

            /* Sembunyikan border hover */
            .nota-card:hover {
                box-shadow: none !important;
            }

            /* Pastikan warna background tercetak */
            .badge-pending,
            .badge-proses,
            .badge-selesai,
            .badge-batal,
            .timeline-step.completed .timeline-icon,
            .total-section,
            .info-grid,
            .notes-box {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Tombol print di browser */
            .action-buttons {
                display: none !important;
            }
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">
</head>

<body class="mf-body">

    <!-- ========== NAVBAR ========== -->
    <?= view('layout/mf_header', ['mfActive' => 'produk']) ?>

    <!-- ========== MAIN CONTENT ========== -->
    <div class="container">
        <div class="nota-wrapper">
            <div class="nota-header">
                <h1>Detail <em>Pesanan</em></h1>
                <p class="subtitle">Lihat informasi lengkap pesanan Anda</p>
                <div class="divider-gold"></div>
            </div>

            <?php if (isset($transaksi) && $transaksi): ?>
                <div class="nota-card">
                    <!-- Header Invoice -->
                    <div class="nota-header-invoice">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <div class="invoice-title">
                                    YSP Jasmine
                                    <small>Premium Florist</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="invoice-number">#<?= str_pad($transaksi['id'], 6, '0', STR_PAD_LEFT) ?></div>
                                <div class="invoice-date">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= date('d M Y, H:i', strtotime($transaksi['tanggal'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Body Nota -->
                    <div class="nota-body">
                        <!-- ===== STATUS SECTION ===== -->
                        <div class="status-section">
                            <?php
                            $statusPesanan = strtolower($transaksi['status'] ?? '');
                            $statusBayar = strtolower($transaksi['status_pembayaran'] ?? 'pending');

                            $pesananClass = 'badge-pending';
                            $pesananLabel = 'Menunggu Konfirmasi';
                            $pesananIcon = 'fa-clock';

                            if (in_array($statusPesanan, ['pending'])) {
                                $pesananClass = 'badge-pending';
                                $pesananLabel = 'Menunggu Konfirmasi Pesanan';
                                $pesananIcon = 'fa-clock';
                            } elseif (in_array($statusPesanan, ['proses', 'diproses'])) {
                                $pesananClass = 'badge-proses';
                                $pesananLabel = 'Sedang Diproses';
                                $pesananIcon = 'fa-spinner fa-spin';
                            } elseif (in_array($statusPesanan, ['dikirim'])) {
                                $pesananClass = 'badge-proses';
                                $pesananLabel = 'Sedang Dikirim';
                                $pesananIcon = 'fa-truck';
                            } elseif (in_array($statusPesanan, ['selesai'])) {
                                $pesananClass = 'badge-selesai';
                                $pesananLabel = 'Pesanan Selesai';
                                $pesananIcon = 'fa-check-circle';
                            } elseif (in_array($statusPesanan, ['batal', 'dibatalkan', 'cancel', 'cancelled'])) {
                                $pesananClass = 'badge-batal';
                                $pesananLabel = 'Pesanan Dibatalkan';
                                $pesananIcon = 'fa-times-circle';
                            }

                            $bayarClass = 'badge-pending';
                            $bayarLabel = 'Menunggu Pembayaran';
                            $bayarIcon = 'fa-clock';

                            if (in_array($statusPesanan, ['batal', 'dibatalkan', 'cancel', 'cancelled'])) {
                                $bayarClass = 'badge-batal';
                                $bayarLabel = 'Pembayaran Dibatalkan';
                                $bayarIcon = 'fa-times-circle';
                            } elseif (in_array($statusBayar, ['lunas', 'success', 'paid', 'berhasil', 'settlement', 'capture'])) {
                                $bayarClass = 'badge-selesai';
                                $bayarLabel = 'Pembayaran Lunas';
                                $bayarIcon = 'fa-check-circle';
                            } elseif (in_array($statusBayar, ['gagal', 'failed', 'expired', 'deny', 'cancel'])) {
                                $bayarClass = 'badge-batal';
                                $bayarLabel = 'Pembayaran Gagal';
                                $bayarIcon = 'fa-times-circle';
                            } elseif (in_array($statusBayar, ['pending', 'waiting', 'menunggu', 'menunggu_verifikasi'])) {
                                $bayarClass = 'badge-pending';
                                $bayarLabel = 'Menunggu Pembayaran Dikonfirmasi';
                                $bayarIcon = 'fa-clock';
                            }
                            ?>

                            <!-- Badge Status Pesanan -->
                            <span class="badge-status <?= $pesananClass ?>">
                                <span class="dot"></span>
                                <i class="fas <?= $pesananIcon ?> me-1"></i>
                                <?= $pesananLabel ?>
                            </span>

                            <!-- Badge Status Pembayaran -->
                            <span class="badge-status <?= $bayarClass ?>">
                                <span class="dot"></span>
                                <i class="fas <?= $bayarIcon ?> me-1"></i>
                                <?= $bayarLabel ?>
                            </span>
                        </div>

                        <!-- ===== TIMELINE ===== -->
                        <div class="timeline-section">
                            <div class="title">Status Pesanan</div>
                            <div class="timeline">
                                <?php
                                $status = strtolower($transaksi['status'] ?? 'pending');
                                $steps = [
                                    'dibuat' => ['icon' => 'fa-shopping-cart', 'label' => 'Dibuat'],
                                    'diproses' => ['icon' => 'fa-check-double', 'label' => 'Diproses'],
                                    'dikirim' => ['icon' => 'fa-truck', 'label' => 'Dikirim'],
                                    'selesai' => ['icon' => 'fa-check-circle', 'label' => 'Selesai']
                                ];

                                $statusMap = [
                                    'pending' => 'dibuat',
                                    'proses' => 'diproses',
                                    'diproses' => 'diproses',
                                    'dikirim' => 'dikirim',
                                    'selesai' => 'selesai',
                                    'batal' => 'dibatalkan',
                                    'dibatalkan' => 'dibatalkan',
                                    'cancel' => 'dibatalkan',
                                    'cancelled' => 'dibatalkan'
                                ];

                                $currentStep = $statusMap[$status] ?? 'dibuat';
                                $stepIndex = array_keys($steps);
                                $currentIndex = array_search($currentStep, $stepIndex);
                                $isCancelled = ($currentStep == 'dibatalkan');
                                ?>

                                <?php foreach ($steps as $key => $step): ?>
                                    <?php
                                    $isCompleted = $isCancelled ? false : (array_search($key, $stepIndex) <= $currentIndex);
                                    $isActive = ($key == $currentStep && !$isCancelled);
                                    ?>
                                    <div class="timeline-step <?= $isCompleted ? 'completed' : '' ?> <?= $isActive ? 'active' : '' ?>">
                                        <div class="timeline-icon"><i class="fas <?= $step['icon'] ?> fa-xs"></i></div>
                                        <div class="timeline-label"><?= $step['label'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Informasi -->
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">ID Transaksi</span>
                                <span class="value">#<?= str_pad($transaksi['id'], 6, '0', STR_PAD_LEFT) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="label">Tanggal</span>
                                <span class="value"><?= date('d F Y', strtotime($transaksi['tanggal'])) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="label">Metode Pembayaran</span>
                                <span class="value">
                                    <i class="fas <?= ($transaksi['metode_pembayaran'] ?? 'cod') == 'cod' ? 'fa-money-bill-wave' : 'fa-university' ?> icon"></i>
                                    <?= strtoupper($transaksi['metode_pembayaran'] ?? 'COD') ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="label">Metode Pengiriman</span>
                                <span class="value">
                                    <i class="fas <?= $transaksi['metode_pengiriman'] == 'delivery' ? 'fa-truck' : 'fa-store' ?> icon"></i>
                                    <?= $transaksi['metode_pengiriman'] == 'delivery' ? 'Delivery' : 'Ambil di Toko' ?>
                                </span>
                            </div>
                            <div class="info-item" style="grid-column: span 2;">
                                <span class="label">Alamat Pengiriman</span>
                                <span class="value">
                                    <?= $transaksi['alamat_tujuan'] ?? 'Jl. Kertosari RT 03 RW 02, Pemalang' ?>
                                    <?php if ($transaksi['metode_pengiriman'] == 'delivery'): ?>
                                        <small>
                                            <br>Ongkir: Rp <?= number_format($transaksi['ongkir'] ?? 0, 0, ',', '.') ?>
                                            + Proteksi: Rp <?= number_format($transaksi['biaya_proteksi'] ?? 0, 0, ',', '.') ?>
                                        </small>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>

                        <!-- Daftar Produk -->
                        <div class="product-section">
                            <div class="section-title">
                                <i class="fas fa-box-open icon"></i> Daftar Produk
                            </div>

                            <table class="table-items">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center" style="width: 60px;">Qty</th>
                                        <th class="text-end" style="width: 100px;">Harga</th>
                                        <th class="text-end" style="width: 120px;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subtotal = 0;
                                    $hasPreOrder = false;
                                    foreach ($detail as $item):
                                        $itemSubtotal = $item['jumlah'] * $item['harga'];
                                        $subtotal += $itemSubtotal;

                                        $isRoncean = (strpos(strtolower($item['nama_barang']), 'ronce') !== false ||
                                            strpos(strtolower($item['nama_barang']), 'pengantin') !== false ||
                                            strpos(strtolower($item['nama_barang']), 'gelang') !== false ||
                                            strpos(strtolower($item['nama_barang']), 'set') !== false);
                                        if ($isRoncean) $hasPreOrder = true;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="product-name">
                                                    <?= esc($item['nama_barang']) ?>
                                                    <?php if ($isRoncean): ?>
                                                        <span class="badge-po">
                                                            <i class="fas fa-clock"></i> Pre-Order
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="product-info">
                                                    <?php if ($isRoncean): ?>
                                                        <span class="po-detail">
                                                            <i class="fas fa-calendar-check"></i> Kirim H+1
                                                        </span>
                                                        <span class="po-detail">
                                                            <i class="fas fa-clock"></i> PO sebelum 17.00 WIB
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="ready-detail">
                                                            <i class="fas fa-box"></i> Stok Tersedia
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="product-sku">
                                                    SKU: #<?= $item['barang_id'] ?>
                                                </div>
                                            </td>
                                            <td class="text-center"><?= $item['jumlah'] ?></td>
                                            <td class="text-end product-price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                            <td class="text-end product-subtotal">Rp <?= number_format($itemSubtotal, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Total -->
                        <div class="total-section">
                            <div class="total-row">
                                <span class="label">Subtotal</span>
                                <span class="amount">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>

                            <?php if ($transaksi['metode_pengiriman'] == 'delivery'): ?>
                                <div class="total-row">
                                    <span class="label">Biaya Kirim</span>
                                    <span class="amount">Rp <?= number_format($transaksi['ongkir'] ?? 0, 0, ',', '.') ?></span>
                                </div>
                                <div class="total-row">
                                    <span class="label">Proteksi Pengiriman</span>
                                    <span class="amount">Rp <?= number_format($transaksi['biaya_proteksi'] ?? 0, 0, ',', '.') ?></span>
                                </div>
                            <?php else: ?>
                                <div class="total-row">
                                    <span class="label">Biaya Kirim</span>
                                    <span class="amount free">Gratis</span>
                                </div>
                            <?php endif; ?>

                            <div class="grand-total total-row">
                                <span class="label">Total</span>
                                <span class="amount">Rp <?= number_format($transaksi['total_akhir'] ?? ($subtotal + ($transaksi['ongkir'] ?? 0) + ($transaksi['biaya_proteksi'] ?? 0)), 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="notes-box">
                            <i class="fas fa-info-circle icon"></i>
                            <p class="text">Pesanan akan segera diproses setelah pembayaran dikonfirmasi.</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button onclick="window.print()" class="btn-print no-print">
                                <i class="fas fa-print"></i> Cetak Nota
                            </button>
                            <a href="<?= base_url('shop/riwayat') ?>" class="btn-back no-print">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="nota-card">
                    <div class="empty-state">
                        <div class="icon"><i class="fas fa-file-invoice"></i></div>
                        <h5>Transaksi Tidak Ditemukan</h5>
                        <p class="text-muted small">Maaf, kami tidak dapat menemukan data pesanan yang Anda cari.</p>
                        <a href="<?= base_url('shop/riwayat') ?>" class="btn-back" style="display: inline-flex; padding: 10px 28px; margin-top: 12px;">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========== FOOTER ========== -->
    <?= view('layout/mf_footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        // Navbar scroll effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });
    </script>
</body>

</html>