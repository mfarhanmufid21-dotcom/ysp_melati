<footer class="sticky-footer py-4">
    <div class="container my-auto">
        <div class="row align-items-center g-3">
            
            <!-- Left Side - Copyright -->
            <div class="col-md-6 text-center text-md-start">
                <div class="copyright-wrapper">
                    <div class="copyright-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="copyright-text">
                        &copy; <?= date('Y') ?> <strong>YSP Jasmine</strong>
                        <span class="separator">|</span>
                        <span class="rights">All Rights Reserved</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Brand & Version -->
            <div class="col-md-6 text-center text-md-end">
                <div class="brand-footer">
                    <div class="brand-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <div class="brand-info">
                        <div class="brand-name">YSP JASMINE</div>
                        <div class="brand-version">
                            <i class="fas fa-gem me-1"></i> Premium Quality
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Line - Additional Info (Mobile Friendly) -->
        <div class="row mt-3">
            <div class="col-12 text-center">
                <div class="footer-bottom">
                    <span class="badge-footer">
                        <i class="fas fa-flower"></i> Fresh From Garden
                    </span>
                    <span class="badge-footer mx-2">
                        <i class="fas fa-truck"></i> Fast Delivery
                    </span>
                    <span class="badge-footer">
                        <i class="fas fa-check-circle"></i> Quality Guaranteed
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* ===== FOOTER PREMIUM STYLES ===== */
    .sticky-footer {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-top: 1px solid rgba(184,150,62, 0.15);
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        margin-top: auto;
        position: relative;
        z-index: 10;
    }

    /* Subtle gradient overlay */
    .sticky-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            var(--gold) 25%,
            var(--gold-light) 50%,
            var(--gold) 75%,
            transparent 100%);
        opacity: 0.6;
    }

    /* Copyright Wrapper */
    .copyright-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 6px 16px 6px 12px;
        background: rgba(31,92,70, 0.04);
        border-radius: 40px;
        transition: all 0.3s ease;
    }

    .copyright-wrapper:hover {
        background: rgba(31,92,70, 0.08);
        transform: translateX(2px);
    }

    .copyright-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--green-pale), var(--cream));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .copyright-icon i {
        color: var(--green-mid);
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .copyright-wrapper:hover .copyright-icon {
        transform: rotate(8deg) scale(1.05);
        background: linear-gradient(135deg, var(--gold-pale), var(--gold-light));
    }

    .copyright-wrapper:hover .copyright-icon i {
        color: var(--gold);
    }

    .copyright-text {
        font-size: 0.8rem;
        color: var(--gray-600);
        letter-spacing: 0.3px;
    }

    .copyright-text strong {
        color: var(--green-deep);
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .copyright-wrapper:hover .copyright-text strong {
        color: var(--gold);
    }

    .copyright-text .separator {
        color: var(--gray-400);
        margin: 0 8px;
    }

    .copyright-text .rights {
        color: var(--gray-500);
        font-weight: 400;
    }

    /* Brand Footer */
    .brand-footer {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 6px 20px 6px 16px;
        background: linear-gradient(135deg, rgba(184,150,62, 0.06), rgba(184,150,62, 0.02));
        border-radius: 40px;
        border: 1px solid rgba(184,150,62, 0.1);
        transition: all 0.3s ease;
        cursor: default;
    }

    .brand-footer:hover {
        background: linear-gradient(135deg, rgba(184,150,62, 0.1), rgba(184,150,62, 0.04));
        border-color: rgba(184,150,62, 0.2);
        transform: translateX(-2px);
    }

    .brand-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(184,150,62, 0.2);
        transition: all 0.3s ease;
    }

    .brand-icon i {
        color: var(--green-deep);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .brand-footer:hover .brand-icon {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(184,150,62, 0.3);
    }

    .brand-info {
        text-align: left;
    }

    .brand-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: var(--green-deep);
        line-height: 1.2;
        transition: all 0.3s ease;
    }

    .brand-footer:hover .brand-name {
        color: var(--gold);
        letter-spacing: 2px;
    }

    .brand-version {
        font-size: 0.65rem;
        color: var(--gray-500);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Footer Bottom Badges */
    .footer-bottom {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        padding-top: 12px;
        margin-top: 8px;
        border-top: 1px solid rgba(0, 0, 0, 0.04);
    }

    .badge-footer {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 30px;
        font-size: 0.7rem;
        color: var(--gray-600);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .badge-footer i {
        color: var(--gold);
        font-size: 0.65rem;
        transition: all 0.3s ease;
    }

    .badge-footer:hover {
        background: rgba(184,150,62, 0.08);
        color: var(--gold);
        transform: translateY(-2px);
    }

    .badge-footer:hover i {
        transform: scale(1.1);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .sticky-footer {
            padding: 20px 16px !important;
        }
        
        .copyright-wrapper,
        .brand-footer {
            padding: 5px 12px;
        }
        
        .copyright-icon,
        .brand-icon {
            width: 28px;
            height: 28px;
        }
        
        .copyright-icon i,
        .brand-icon i {
            font-size: 0.75rem;
        }
        
        .copyright-text {
            font-size: 0.7rem;
        }
        
        .brand-name {
            font-size: 0.85rem;
        }
        
        .brand-version {
            font-size: 0.55rem;
        }
        
        .footer-bottom {
            gap: 6px;
        }
        
        .badge-footer {
            padding: 3px 10px;
            font-size: 0.65rem;
        }
    }

    /* ===== DARK MODE READY ===== */
    @media (prefers-color-scheme: dark) {
        .sticky-footer {
            background: rgba(26, 26, 26, 0.92);
            border-top-color: rgba(184,150,62, 0.1);
        }
        
        .copyright-text,
        .copyright-text .rights {
            color: var(--gray-500);
        }
        
        .badge-footer {
            background: rgba(255, 255, 255, 0.03);
            color: var(--gray-500);
        }
    }

    /* Subtle animation on load */
    @keyframes footerFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .sticky-footer {
        animation: footerFadeIn 0.5s ease forwards;
    }
</style>