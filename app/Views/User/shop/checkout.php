<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | YSP Jasmine</title>
    <link rel="icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-theme.css') ?>?v=1">
    <link rel="stylesheet" href="<?= base_url('assets/css/mf-shop.css') ?>?v=1">
</head>

<?php
$cart     = $cart ?? [];
$hasItems = !empty($cart);

/* Produk roncean / pre-order (logika sama seperti sebelumnya) */
$isPreOrder = function (array $item) {
    $n = strtolower($item['nama_barang'] ?? '');
    return strpos($n, 'ronce') !== false || strpos($n, 'pengantin') !== false
        || strpos($n, 'gelang') !== false || strpos($n, 'set') !== false;
};

$subtotal = 0;
$hasPreOrder = false;
foreach ($cart as $it) {
    $subtotal += $it['harga'] * $it['qty'];
    if ($isPreOrder($it)) { $hasPreOrder = true; }
}
?>

<body class="mf-body<?= $hasItems ? ' sh-has-bar' : '' ?>">

    <!-- ========== NAVBAR ========== -->
    <?= $this->include('User/layout/navbar') ?>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <div class="spinner-border mb-3" role="status"></div>
            <p class="mb-0 fw-bold">Memproses Pesanan...</p>
            <small class="text-muted">Mohon tunggu sebentar</small>
        </div>
    </div>

    <main class="sh-page" id="main">

        <div class="mf-pagehead">
            <div class="mf-crumb"><a href="<?= base_url() ?>">Beranda</a> &nbsp;/&nbsp; <a href="<?= base_url('shop/cart') ?>">Keranjang</a> &nbsp;/&nbsp; Checkout</div>
            <h1>Checkout Pesanan</h1>
        </div>

        <?= view('layout/sh_steps', ['shStep' => 2]) ?>

        <div class="sh-wrap">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert mf-alert success alert-dismissible fade show" role="alert" style="margin-top:26px">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert mf-alert error alert-dismissible fade show" role="alert" style="margin-top:26px">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            <?php endif; ?>

            <?php if (!$hasItems): ?>
                <div class="sh-empty">
                    <div class="ic"><i class="fas fa-shopping-bag"></i></div>
                    <h2>Keranjang Belanja Kosong</h2>
                    <p>Tambahkan produk terlebih dahulu sebelum checkout.</p>
                    <a href="<?= base_url('shop') ?>" class="mf-btn solid"><i class="fas fa-shopping-bag"></i> Mulai Belanja</a>
                </div>
            <?php else: ?>

                <div class="sh-layout">

                    <!-- ================= FORM ================= -->
                    <div>
                        <form action="<?= base_url('shop/checkout') ?>" method="POST" id="checkoutForm" enctype="multipart/form-data" novalidate>
                            <?= csrf_field() ?>

                            <!-- 1. Data diri -->
                            <section class="sh-card" aria-labelledby="h-data">
                                <div class="sh-card-head">
                                    <span class="num">1</span>
                                    <h2 id="h-data">Data Diri<small>Untuk konfirmasi pesanan via WhatsApp</small></h2>
                                </div>
                                <div class="sh-grid-2">
                                    <div>
                                        <label class="form-label-custom" for="namaLengkap">Nama Lengkap</label>
                                        <input type="text" id="namaLengkap" name="nama_lengkap" class="form-control-custom" autocomplete="name"
                                               value="<?= esc(session()->get('nama') ?: old('nama_lengkap')) ?>" placeholder="Nama penerima" required>
                                        <div class="field-error">Nama lengkap wajib diisi.</div>
                                    </div>
                                    <div>
                                        <label class="form-label-custom" for="noHp">Nomor HP / WhatsApp</label>
                                        <input type="tel" id="noHp" name="no_hp" class="form-control-custom" autocomplete="tel" inputmode="tel"
                                               value="<?= esc(session()->get('telepon') ?: old('no_hp')) ?>" placeholder="08xxxxxxxxxx" required>
                                        <div class="field-error">Nomor HP/WhatsApp wajib diisi.</div>
                                    </div>
                                </div>
                            </section>

                            <!-- 2. Pengiriman -->
                            <section class="sh-card" aria-labelledby="h-kirim">
                                <div class="sh-card-head">
                                    <span class="num">2</span>
                                    <h2 id="h-kirim">Metode Pengiriman<small>Pilih diantar atau ambil sendiri</small></h2>
                                </div>

                                <div class="sh-options two">
                                    <div class="shipping-option" data-shipping="delivery" tabindex="0" role="radio" aria-checked="false">
                                        <input type="radio" name="metode_pengiriman" value="delivery" class="d-none" required>
                                        <div class="opt-ic"><i class="fas fa-truck"></i></div>
                                        <div class="opt-body">
                                            <div class="opt-title">Delivery ke Alamat</div>
                                            <div class="opt-desc">Diantar langsung ke rumah Anda</div>
                                            <span class="opt-price">Ongkir Rp 15.000 + Proteksi Rp 3.000</span>
                                        </div>
                                    </div>
                                    <div class="shipping-option" data-shipping="ambil" tabindex="0" role="radio" aria-checked="false">
                                        <input type="radio" name="metode_pengiriman" value="ambil" class="d-none" required>
                                        <div class="opt-ic"><i class="fas fa-store"></i></div>
                                        <div class="opt-body">
                                            <div class="opt-title">Ambil di Toko</div>
                                            <div class="opt-desc">YSP Jasmine, Jl. Desa Kertosari RT 03 RW 02 No.19, Ulujami, Pemalang</div>
                                            <span class="opt-price">Gratis ongkir</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat delivery -->
                                <div id="alamatContainer" class="d-none" style="margin-top:20px">
                                    <label class="form-label-custom" for="alamatTujuan">Alamat Lengkap</label>
                                    <textarea id="alamatTujuan" name="alamat_tujuan" class="form-control-custom" rows="3" autocomplete="street-address"
                                              placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota"><?= esc(old('alamat_tujuan')) ?></textarea>
                                    <div class="field-error">Alamat pengiriman wajib diisi.</div>
                                </div>

                                <!-- Info ambil di toko -->
                                <div id="infoAmbilContainer" class="sh-info d-none">
                                    <div class="t"><i class="fas fa-map-marker-alt"></i> Lokasi Pengambilan</div>
                                    <p><strong>YSP Jasmine</strong><br>
                                        Jl. Desa Kertosari RT 03 RW 02 No.19,<br>
                                        Kec. Ulujami, Kab. Pemalang, Jawa Tengah</p>
                                    <label class="sh-check" for="checkAgreement">
                                        <input type="checkbox" id="checkAgreement">
                                        <span>Saya setuju bahwa jika bunga tidak diambil dalam <strong>24 jam</strong>, risiko layu bukan tanggung jawab YSP Jasmine.</span>
                                    </label>
                                </div>
                            </section>

                            <!-- 3. Pembayaran -->
                            <section class="sh-card" aria-labelledby="h-bayar">
                                <div class="sh-card-head">
                                    <span class="num">3</span>
                                    <h2 id="h-bayar">Metode Pembayaran<small>Pilih cara bayar yang paling nyaman</small></h2>
                                    <div class="sh-secure"><span><i class="fas fa-shield-alt"></i> Aman</span></div>
                                </div>

                                <div class="sh-options">
                                    <!-- COD -->
                                    <div class="payment-option" data-payment="cod" tabindex="0" role="radio" aria-checked="false">
                                        <input type="radio" name="metode_pembayaran" value="cod" class="d-none" required>
                                        <div class="opt-ic"><i class="fas fa-money-bill-wave"></i></div>
                                        <div class="opt-body">
                                            <div class="opt-title">COD (Bayar di Tempat)</div>
                                            <div class="opt-desc">Bayar tunai saat Anda menerima barang</div>
                                        </div>
                                    </div>

                                    <!-- Transfer -->
                                    <div class="payment-option" data-payment="transfer" tabindex="0" role="radio" aria-checked="false">
                                        <input type="radio" name="metode_pembayaran" value="transfer" class="d-none">
                                        <div class="opt-ic"><i class="fas fa-university"></i></div>
                                        <div class="opt-body">
                                            <div class="opt-title">Transfer Bank</div>
                                            <div class="opt-desc">BCA / Mandiri</div>
                                        </div>
                                    </div>

                                    <div id="rekeningInfo" class="sh-pay-panel" style="display:none">
                                        <div class="sh-acc-grid">
                                            <div class="sh-acc">
                                                <div class="bank">Bank BCA</div>
                                                <div class="no">1234 5678 9012 3456</div>
                                                <div class="an">a.n. YSP Jasmine</div>
                                                <button type="button" class="sh-copy" data-copy="1234567890123456"><i class="far fa-copy"></i> Salin</button>
                                            </div>
                                            <div class="sh-acc">
                                                <div class="bank">Bank Mandiri</div>
                                                <div class="no">1234 5678 9012 3456</div>
                                                <div class="an">a.n. YSP Jasmine</div>
                                                <button type="button" class="sh-copy" data-copy="1234567890123456"><i class="far fa-copy"></i> Salin</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- E-Wallet -->
                                    <div class="payment-option" data-payment="ewallet" tabindex="0" role="radio" aria-checked="false">
                                        <input type="radio" name="metode_pembayaran" value="ewallet" class="d-none">
                                        <div class="opt-ic"><i class="fas fa-wallet"></i></div>
                                        <div class="opt-body">
                                            <div class="opt-title">E-Wallet</div>
                                            <div class="opt-desc">DANA / OVO / GoPay</div>
                                        </div>
                                    </div>

                                    <div id="ewalletInfo" class="sh-pay-panel d-none">
                                        <div class="sh-ew">
                                            <div class="ewallet-option" data-ewallet="dana" tabindex="0">
                                                <input type="radio" name="ewallet_type" value="dana" class="d-none">
                                                <i class="fas fa-wallet"></i>
                                                <div class="nm">DANA</div>
                                            </div>
                                            <div class="ewallet-option" data-ewallet="ovo" tabindex="0">
                                                <input type="radio" name="ewallet_type" value="ovo" class="d-none">
                                                <i class="fas fa-wallet"></i>
                                                <div class="nm">OVO</div>
                                            </div>
                                            <div class="ewallet-option" data-ewallet="gopay" tabindex="0">
                                                <input type="radio" name="ewallet_type" value="gopay" class="d-none">
                                                <i class="fas fa-wallet"></i>
                                                <div class="nm">GoPay</div>
                                            </div>
                                        </div>
                                        <?php foreach (['dana' => 'DANA', 'ovo' => 'OVO', 'gopay' => 'GoPay'] as $k => $nm): ?>
                                            <div id="<?= $k ?>Info" class="ewallet-detail sh-acc" style="display:none">
                                                <div class="bank">Nomor <?= $nm ?></div>
                                                <div class="no">0856 4769 5804</div>
                                                <div class="an">a.n. YSP Jasmine</div>
                                                <button type="button" class="sh-copy" data-copy="085647695804"><i class="far fa-copy"></i> Salin</button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- QRIS -->
                                    <div class="payment-option" data-payment="qris" tabindex="0" role="radio" aria-checked="false">
                                        <input type="radio" name="metode_pembayaran" value="qris" class="d-none">
                                        <div class="opt-ic"><i class="fas fa-qrcode"></i></div>
                                        <div class="opt-body">
                                            <div class="opt-title">QRIS</div>
                                            <div class="opt-desc">Scan lewat mobile banking atau e-wallet apa pun</div>
                                        </div>
                                    </div>

                                    <div id="qrisInfo" class="sh-pay-panel" style="display:none">
                                        <div class="sh-qris">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=170x170&data=YSPJasminePayment" alt="Kode QRIS YSP Jasmine">
                                            <p>Scan kode di atas menggunakan aplikasi mobile banking atau e-wallet Anda.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload bukti -->
                                <div id="uploadContainer" class="sh-pay-panel" style="display:none;margin-top:22px">
                                    <div class="sh-pay-total"><span>Jumlah yang harus dibayar</span><b class="js-total">Rp <?= number_format($subtotal, 0, ',', '.') ?></b></div>
                                    <label class="form-label-custom">Upload Bukti Pembayaran</label>
                                    <div class="sh-upload">
                                        <input type="file" name="bukti_pembayaran" id="buktiPembayaran" class="d-none" accept=".jpg,.jpeg,.png,.pdf">
                                        <button type="button" class="mf-btn" onclick="document.getElementById('buktiPembayaran').click()">
                                            <i class="fas fa-cloud-upload-alt"></i> Pilih File
                                        </button>
                                        <div id="previewContainer"></div>
                                        <small>Format JPG, PNG, atau PDF &middot; maksimal 2MB</small>
                                    </div>
                                    <div id="uploadError"></div>
                                </div>

                                <?php if ($hasPreOrder): ?>
                                    <div class="sh-notice" style="margin:22px 0 0">
                                        <i class="fas fa-clock"></i>
                                        <div><b>Info Pre-Order:</b> produk berlabel Pre-Order dikirim <b>besok (H+1)</b>. Batas pemesanan pukul <b>17.00 WIB</b>.</div>
                                    </div>
                                <?php endif; ?>
                            </section>

                            <div class="sh-submit-desktop">
                                <button type="submit" class="mf-btn solid sh-submit js-submit" id="checkoutBtn">
                                    <i class="fas fa-check-circle"></i> Konfirmasi Pesanan
                                </button>
                                <p class="sh-form-note"><i class="fas fa-lock"></i> Dengan menekan tombol ini, pesanan Anda akan diproses.</p>
                            </div>
                        </form>

                        <a href="<?= base_url('shop/cart') ?>" class="sh-back"><i class="fas fa-arrow-left"></i> Kembali ke Keranjang</a>
                    </div>

                    <!-- ================= RINGKASAN ================= -->
                    <aside class="sh-aside" aria-label="Ringkasan pesanan">
                        <div class="sh-summary">
                            <h2>Ringkasan Pesanan</h2>

                            <div class="sh-mini-list">
                                <?php foreach ($cart as $id => $item):
                                    $itemSubtotal = $item['harga'] * $item['qty'];
                                    $isPO = $isPreOrder($item);
                                    $gp = FCPATH . 'uploads/' . ($item['gambar'] ?? '');
                                    $gambar = (!empty($item['gambar']) && file_exists($gp))
                                        ? base_url('uploads/' . $item['gambar'])
                                        : 'https://placehold.co/120x120/f7f5f0/1f5c46?text=YSP';
                                ?>
                                    <div class="sh-mini">
                                        <div class="sh-mini-img">
                                            <img src="<?= $gambar ?>" alt="<?= esc($item['nama_barang']) ?>" loading="lazy">
                                            <b><?= (int) $item['qty'] ?></b>
                                        </div>
                                        <div class="sh-mini-info">
                                            <?= esc($item['nama_barang']) ?>
                                            <small>Rp <?= number_format($item['harga'], 0, ',', '.') ?> / item</small>
                                            <?php if ($isPO): ?><span class="sh-tag" style="margin:4px 0 0"><i class="fas fa-clock"></i> Pre-Order H+1</span><?php endif; ?>
                                        </div>
                                        <div class="sh-mini-price">Rp <?= number_format($itemSubtotal, 0, ',', '.') ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="sh-sum-row" style="border-top:1px solid var(--mf-line);margin-top:6px;padding-top:14px">
                                <span class="muted">Subtotal</span><span id="subtotalDisplay">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>
                            <div class="sh-sum-row"><span class="muted">Ongkos kirim</span><span id="ongkirDisplay">Rp 0</span></div>
                            <div class="sh-sum-row"><span class="muted">Biaya proteksi</span><span id="proteksiDisplay">Rp 0</span></div>

                            <div class="sh-sum-total">
                                <span class="lbl">Total</span>
                                <span class="val js-total" id="totalDisplay">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>

                            <div class="sh-trust">
                                <div><i class="fas fa-lock"></i> Pembayaran aman &amp; terverifikasi</div>
                                <div><i class="fab fa-whatsapp"></i> Butuh bantuan? <a href="https://wa.me/6285647695804?text=Halo%20YSP%20Jasmine,%20saya%20butuh%20bantuan%20checkout" target="_blank" rel="noopener">Chat kami</a></div>
                            </div>
                        </div>

                        <input type="hidden" id="subtotalValue" value="<?= $subtotal ?>">
                    </aside>
                </div>

                <!-- Bar bawah (HP) -->
                <div class="sh-mobilebar">
                    <div class="tot"><small>Total</small><b class="js-total">Rp <?= number_format($subtotal, 0, ',', '.') ?></b></div>
                    <button type="submit" form="checkoutForm" class="mf-btn solid js-submit"><i class="fas fa-check-circle"></i> Pesan</button>
                </div>

            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <?= view('layout/mf_footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== CONSTANTS =====
        const subtotal = parseInt(document.getElementById('subtotalValue')?.value) || 0;
        const ONGKIR = 15000;
        const PROTEKSI = 3000;
        const BTN_LABEL = '<i class="fas fa-check-circle"></i> Konfirmasi Pesanan';
        const BTN_LABEL_M = '<i class="fas fa-check-circle"></i> Pesan';

        let currentOngkir = 0;
        let currentProteksi = 0;

        // ===== DOM Elements =====
        const ongkirDisplay = document.getElementById('ongkirDisplay');
        const proteksiDisplay = document.getElementById('proteksiDisplay');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const checkoutForm = document.getElementById('checkoutForm');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');

        // ===== Helper Functions =====
        function updateTotal() {
            const total = subtotal + currentOngkir + currentProteksi;
            document.querySelectorAll('.js-total').forEach(el => {
                el.textContent = rupiah(total);
                el.classList.add('total-animate');
                setTimeout(() => el.classList.remove('total-animate'), 500);
            });
        }

        function setBusy(busy) {
            document.querySelectorAll('.js-submit').forEach(btn => {
                btn.disabled = busy;
                const isMain = btn === checkoutBtn;
                btn.innerHTML = busy
                    ? '<i class="fas fa-spinner fa-spin"></i> Memproses...'
                    : (isMain ? BTN_LABEL : BTN_LABEL_M);
            });
            loadingOverlay.style.display = busy ? 'flex' : 'none';
        }

        // Pilihan bisa dipilih juga lewat keyboard (Enter / Spasi)
        function bindKeyboard(selector) {
            document.querySelectorAll(selector).forEach(el => {
                el.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); el.click(); }
                });
            });
        }

        function markActive(selector, active) {
            document.querySelectorAll(selector).forEach(opt => {
                const on = opt === active;
                opt.classList.toggle('active', on);
                if (opt.hasAttribute('role')) opt.setAttribute('aria-checked', on ? 'true' : 'false');
            });
        }

        // ===== Shipping Method Selection =====
        document.querySelectorAll('.shipping-option').forEach(option => {
            option.addEventListener('click', function () {
                markActive('.shipping-option', this);

                const radio = this.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;

                const isDelivery = radio.value === 'delivery';
                document.getElementById('alamatContainer').classList.toggle('d-none', !isDelivery);
                document.getElementById('infoAmbilContainer').classList.toggle('d-none', isDelivery);

                currentOngkir = isDelivery ? ONGKIR : 0;
                currentProteksi = isDelivery ? PROTEKSI : 0;

                ongkirDisplay.textContent = isDelivery ? rupiah(currentOngkir) : 'Gratis';
                proteksiDisplay.textContent = rupiah(currentProteksi);
                updateTotal();
            });
        });

        // ===== Payment Method Selection =====
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function () {
                markActive('.payment-option', this);

                const radio = this.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;

                const v = radio.value;
                document.getElementById('rekeningInfo').style.display = v === 'transfer' ? 'block' : 'none';
                document.getElementById('ewalletInfo').classList.toggle('d-none', v !== 'ewallet');
                document.getElementById('qrisInfo').style.display = v === 'qris' ? 'block' : 'none';
                document.getElementById('uploadContainer').style.display = v === 'cod' ? 'none' : 'block';
            });
        });

        // ===== E-Wallet Selection =====
        document.querySelectorAll('.ewallet-option').forEach(option => {
            option.addEventListener('click', function () {
                markActive('.ewallet-option', this);

                const radio = this.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;

                document.querySelectorAll('.ewallet-detail').forEach(d => d.style.display = 'none');
                const detail = document.getElementById(this.dataset.ewallet + 'Info');
                if (detail) detail.style.display = 'block';
            });
        });

        bindKeyboard('.shipping-option');
        bindKeyboard('.payment-option');
        bindKeyboard('.ewallet-option');

        // ===== Salin nomor rekening =====
        document.querySelectorAll('.sh-copy').forEach(btn => {
            btn.addEventListener('click', async function () {
                const text = this.dataset.copy;
                try {
                    await navigator.clipboard.writeText(text);
                } catch (e) {
                    const ta = document.createElement('textarea');
                    ta.value = text; document.body.appendChild(ta); ta.select();
                    try { document.execCommand('copy'); } catch (_) {}
                    ta.remove();
                }
                const old = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i> Tersalin';
                this.classList.add('ok');
                setTimeout(() => { this.innerHTML = old; this.classList.remove('ok'); }, 1600);
            });
        });

        // ===== File Upload Preview & Validation =====
        document.getElementById('buktiPembayaran')?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            const previewContainer = document.getElementById('previewContainer');
            const uploadError = document.getElementById('uploadError');

            if (!file) { previewContainer.innerHTML = ''; return; }

            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            const maxSize = 2 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                uploadError.textContent = 'Format tidak didukung. Gunakan JPG, PNG, atau PDF.';
                uploadError.style.display = 'block';
                previewContainer.innerHTML = '';
                this.value = '';
                return;
            }

            if (file.size > maxSize) {
                uploadError.textContent = 'Ukuran file maksimal 2MB.';
                uploadError.style.display = 'block';
                previewContainer.innerHTML = '';
                this.value = '';
                return;
            }

            uploadError.style.display = 'none';
            const safeName = file.name.replace(/[<>&"]/g, '');

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    previewContainer.innerHTML = `
                        <div class="sh-prev">
                            <img src="${ev.target.result}" class="upload-preview" alt="Pratinjau bukti pembayaran">
                            <button type="button" class="x" onclick="removeFile()" aria-label="Hapus file">&times;</button>
                        </div>
                        <div class="sh-fileok"><i class="fas fa-check-circle" style="color:var(--mf-accent)"></i> ${safeName}</div>`;
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = `
                    <div class="sh-prev">
                        <div class="pdf"><i class="fas fa-file-pdf"></i></div>
                        <button type="button" class="x" onclick="removeFile()" aria-label="Hapus file">&times;</button>
                    </div>
                    <div class="sh-fileok"><i class="fas fa-check-circle" style="color:var(--mf-accent)"></i> ${safeName}</div>`;
            }
        });

        window.removeFile = function () {
            document.getElementById('buktiPembayaran').value = '';
            document.getElementById('previewContainer').innerHTML = '';
        };

        // Hapus tanda error begitu kolom diperbaiki
        document.querySelectorAll('.form-control-custom').forEach(el => {
            el.addEventListener('input', () => el.classList.remove('is-invalid'));
        });

        // ===== Form Validation & Submit =====
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                let isValid = true;
                let firstBad = null;
                const flag = el => { el.classList.add('is-invalid'); isValid = false; if (!firstBad) firstBad = el; };

                const nama = document.querySelector('input[name="nama_lengkap"]');
                if (!nama.value.trim()) flag(nama);

                const hp = document.querySelector('input[name="no_hp"]');
                if (!hp.value.trim()) flag(hp);

                const shippingRadio = document.querySelector('input[name="metode_pengiriman"]:checked');
                if (!shippingRadio) {
                    await Swal.fire({ icon: 'error', title: 'Pilih metode pengiriman', confirmButtonColor: '#1f5c46' });
                    return;
                }

                if (shippingRadio.value === 'delivery') {
                    const alamat = document.querySelector('textarea[name="alamat_tujuan"]');
                    if (!alamat.value.trim()) flag(alamat);
                }

                if (firstBad) {
                    firstBad.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstBad.focus({ preventScroll: true });
                    return;
                }

                if (shippingRadio.value === 'ambil') {
                    const agreement = document.getElementById('checkAgreement');
                    if (!agreement.checked) {
                        await Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Harap centang persetujuan pengambilan di toko.', confirmButtonColor: '#1f5c46' });
                        agreement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return;
                    }
                }

                const paymentRadio = document.querySelector('input[name="metode_pembayaran"]:checked');
                if (!paymentRadio) {
                    await Swal.fire({ icon: 'error', title: 'Pilih metode pembayaran', confirmButtonColor: '#1f5c46' });
                    return;
                }

                if (paymentRadio.value === 'ewallet' && !document.querySelector('input[name="ewallet_type"]:checked')) {
                    await Swal.fire({ icon: 'warning', title: 'Pilih e-wallet', text: 'Pilih DANA, OVO, atau GoPay terlebih dahulu.', confirmButtonColor: '#1f5c46' });
                    document.getElementById('ewalletInfo').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }

                if (paymentRadio.value !== 'cod') {
                    const fileInput = document.getElementById('buktiPembayaran');
                    if (!fileInput.files.length) {
                        await Swal.fire({ icon: 'error', title: 'Bukti pembayaran belum diunggah', text: 'Harap upload bukti pembayaran.', confirmButtonColor: '#1f5c46' });
                        document.getElementById('uploadContainer').scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return;
                    }
                }

                setBusy(true);

                const formData = new FormData(this);

                const csrfToken = document.querySelector('input[name="csrf_test_name"]')?.value;
                if (csrfToken) formData.append('csrf_test_name', csrfToken);

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pesanan berhasil!',
                            text: result.message,
                            confirmButtonColor: '#1f5c46'
                        }).then(() => { window.location.href = result.redirect; });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: result.message, confirmButtonColor: '#1f5c46' });
                        setBusy(false);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Koneksi',
                        text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
                        confirmButtonColor: '#1f5c46'
                    });
                    setBusy(false);
                }
            });
        }

        // ===== Initialize =====
        function init() {
            if (!document.querySelector('input[name="metode_pengiriman"]:checked')) {
                const defaultShipping = document.querySelector('.shipping-option');
                if (defaultShipping) defaultShipping.click();
            }
            if (!document.querySelector('input[name="metode_pembayaran"]:checked')) {
                const defaultPayment = document.querySelector('.payment-option');
                if (defaultPayment) defaultPayment.click();
            }
        }

        init();
    </script>
</body>

</html>
