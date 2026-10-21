<?php
/**
 * Navbar + dropdown akun + modal Edit Profil (dipakai di semua halaman akun).
 * Pakai: <?= view('User/layout/account_nav', ['active' => 'dashboard']) ?>
 * $active: dashboard | riwayat | keranjang
 */
$active   = $active ?? '';
$namaUser = session()->get('nama') ?: (session()->get('username') ?: 'Pengguna');
$inisial  = mb_strtoupper(mb_substr(trim($namaUser), 0, 1));
$cartCount = 0;
$cart = session()->get('cart');
if ($cart && is_array($cart)) {
    foreach ($cart as $item) {
        $cartCount += (int) ($item['qty'] ?? 0);
    }
}
?>
<style>
    .acc-header .bar { display: grid; grid-template-columns: 1fr auto 1fr; }
    .acc-header .bar .left  { display: flex; align-items: center; gap: 4px; }
    .acc-header .bar .right { display: flex; align-items: center; justify-content: flex-end; gap: 8px; }
    @media (max-width: 480px) {
        .acc-header .bar { gap: 6px; }
        .acc-brand .name { font-size: 1.15rem; letter-spacing: 2px; }
        .acc-brand .tag { font-size: .5rem; letter-spacing: 3px; }
        .acc-announce { font-size: .74rem; padding: 8px 10px; }
    }
</style>

<div class="acc-announce">
    Gratis konsultasi pesanan via WhatsApp &nbsp;·&nbsp; Buka setiap hari 08.00–17.00 &nbsp;
    <a href="https://wa.me/6285647695804" target="_blank" rel="noopener">Chat sekarang</a>
</div>

<header class="acc-header" id="accHeader">
    <div class="container">
        <div class="bar">
            <div class="left">
                <button class="acc-icon-btn menu-toggle" type="button" id="menuToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="accNavWrap">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="acc-icon-btn d-none d-lg-inline-flex" href="<?= base_url('shop') ?>" aria-label="Cari produk" title="Cari produk">
                    <i class="fas fa-magnifying-glass"></i>
                </a>
            </div>

            <a class="acc-brand" href="<?= base_url() ?>" aria-label="YSP Jasmine - Beranda">
                <span class="name">YSP JASMINE</span>
                <span class="tag">PURE ELEGANCE</span>
            </a>

            <div class="right">
                <a href="<?= base_url('shop/cart') ?>" class="acc-icon-btn" aria-label="Keranjang belanja" title="Keranjang">
                    <i class="fas fa-bag-shopping"></i>
                    <?php if ($cartCount > 0): ?><span class="acc-cart-count"><?= $cartCount ?></span><?php endif; ?>
                </a>

                <div class="dropdown">
                    <button class="acc-user-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu akun">
                        <span class="avatar"><?= esc($inisial) ?></span>
                        <span class="uname"><?= esc(mb_strimwidth($namaUser, 0, 18, '…')) ?></span>
                        <i class="fas fa-chevron-down small d-none d-md-inline"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end acc-menu">
                        <li class="menu-head">
                            <span class="avatar"><?= esc($inisial) ?></span>
                            <span>
                                <small>Halo,</small>
                                <strong><?= esc($namaUser) ?></strong>
                            </span>
                        </li>
                        <li><a class="dropdown-item <?= $active === 'dashboard' ? 'active' : '' ?>" href="<?= base_url('user/dashboard') ?>"><i class="fas fa-table-cells-large"></i> Dashboard</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="fas fa-user-pen"></i> Edit Profil</a></li>
                        <li><a class="dropdown-item <?= $active === 'riwayat' ? 'active' : '' ?>" href="<?= base_url('shop/riwayat') ?>"><i class="fas fa-receipt"></i> Riwayat Pesanan</a></li>
                        <li><a class="dropdown-item <?= $active === 'keranjang' ? 'active' : '' ?>" href="<?= base_url('shop/cart') ?>"><i class="fas fa-bag-shopping"></i> Keranjang</a></li>
                        <li><hr class="dropdown-divider my-0"></li>
                        <li><a class="dropdown-item logout" href="<?= base_url('logout') ?>" id="logoutLink"><i class="fas fa-right-from-bracket"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="acc-nav-wrap" id="accNavWrap">
            <nav class="acc-nav" aria-label="Navigasi utama">
                <a href="<?= base_url() ?>">Beranda</a>
                <a href="<?= base_url('/#best-seller') ?>">Best Seller</a>
                <a href="<?= base_url('shop') ?>">Semua Produk</a>
                <a href="<?= base_url('/#tentang') ?>">Tentang Kami</a>
                <a href="<?= base_url('/#pemesanan') ?>">Cara Pesan</a>
                <a href="<?= base_url('/#testimoni') ?>">Testimoni</a>
            </nav>
        </div>
    </div>
</header>

<!-- ================= MODAL EDIT PROFIL ================= -->
<div class="modal fade modal-ysp" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="profileForm" novalidate autocomplete="off">
                <div class="modal-head">
                    <span class="avatar lg"><?= esc($inisial) ?></span>
                    <div>
                        <h5 id="editProfileTitle">Edit Profil</h5>
                        <p>Perbarui data diri agar pesanan sampai dengan tepat.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="<?= csrf_token() ?>" id="csrf_token_field" value="<?= csrf_hash() ?>">

                    <div class="form-section">Data Diri</div>

                    <div class="field">
                        <label for="profile_nama">Nama Lengkap</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="nama" id="profile_nama" placeholder="Nama lengkap Anda" required>
                            <div class="invalid-feedback">Nama wajib diisi.</div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="profile_email">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" id="profile_email" placeholder="contoh@email.com" required>
                            <div class="invalid-feedback">Masukkan alamat email yang valid.</div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="profile_telepon">No. Telepon / WhatsApp</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="tel" inputmode="tel" class="form-control" name="telepon" id="profile_telepon" placeholder="08xxxxxxxxxx" required>
                            <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="profile_alamat">Alamat Pengiriman</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-location-dot"></i></span>
                            <textarea class="form-control" name="alamat" id="profile_alamat" rows="3" placeholder="Jalan, RT/RW, desa, kecamatan, kota"></textarea>
                        </div>
                    </div>

                    <div class="form-section mt-4">Ganti Password <span class="fw-normal text-lowercase" style="letter-spacing:0">(opsional)</span></div>

                    <div class="field">
                        <label for="profile_password">Password Baru</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" id="profile_password" placeholder="Minimal 6 karakter" autocomplete="new-password">
                            <button class="btn toggle-pass" type="button" data-target="profile_password" aria-label="Tampilkan password"><i class="fas fa-eye"></i></button>
                            <div class="invalid-feedback">Password minimal 6 karakter.</div>
                        </div>
                        <div class="hint">Kosongkan jika tidak ingin mengubah password.</div>
                    </div>

                    <div class="field">
                        <label for="profile_confirm_password">Ulangi Password Baru</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-shield-halved"></i></span>
                            <input type="password" class="form-control" name="confirm_password" id="profile_confirm_password" placeholder="Ketik ulang password baru" autocomplete="new-password">
                            <button class="btn toggle-pass" type="button" data-target="profile_confirm_password" aria-label="Tampilkan password"><i class="fas fa-eye"></i></button>
                            <div class="invalid-feedback">Konfirmasi password tidak cocok.</div>
                        </div>
                    </div>
                </div>

                <div class="modal-foot">
                    <button type="button" class="btn-ysp btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-ysp" id="saveProfileBtn"><i class="fas fa-floppy-disk"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ---------- Menu mobile ----------
    const toggle = document.getElementById('menuToggle');
    const wrap   = document.getElementById('accNavWrap');
    if (toggle && wrap) {
        toggle.addEventListener('click', function () {
            const open = wrap.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open);
            toggle.querySelector('i').className = open ? 'fas fa-xmark' : 'fas fa-bars';
        });
    }

    // ---------- Konfirmasi keluar ----------
    const logout = document.getElementById('logoutLink');
    if (logout) {
        logout.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Keluar dari akun?',
                text: 'Anda perlu masuk lagi untuk melihat pesanan.',
                icon: 'question', showCancelButton: true,
                confirmButtonText: 'Ya, keluar', cancelButtonText: 'Batal',
                confirmButtonColor: '#2D5016', cancelButtonColor: '#8A9E78', reverseButtons: true
            }).then(r => { if (r.isConfirmed) window.location.href = logout.href; });
        });
    }

    // ---------- Tampil/sembunyi password ----------
    document.querySelectorAll('.toggle-pass').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            this.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

    // ---------- Edit profil ----------
    const modalEl = document.getElementById('editProfileModal');
    const form    = document.getElementById('profileForm');
    const saveBtn = document.getElementById('saveProfileBtn');
    const SAVE_HTML = '<i class="fas fa-floppy-disk"></i> Simpan Perubahan';
    if (!modalEl || !form) return;

    const fields = form.querySelectorAll('input.form-control, textarea.form-control');
    const setBusy = (busy) => fields.forEach(f => f.disabled = busy);
    const clearInvalid = () => form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    const updateToken = (d) => { if (d && d.csrf_hash) document.getElementById('csrf_token_field').value = d.csrf_hash; };

    modalEl.addEventListener('show.bs.modal', async function () {
        clearInvalid();
        form.querySelectorAll('input[type=password]').forEach(i => { i.value = ''; i.type = 'password'; });
        form.querySelectorAll('.toggle-pass i').forEach(i => i.className = 'fas fa-eye');
        setBusy(true);
        saveBtn.disabled = true;
        try {
            const res  = await fetch('<?= base_url('user/getProfile') ?>', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            updateToken(data);
            if (data.success) {
                document.getElementById('profile_nama').value    = data.data.nama    || '';
                document.getElementById('profile_email').value   = data.data.email   || '';
                document.getElementById('profile_telepon').value = data.data.telepon || '';
                document.getElementById('profile_alamat').value  = data.data.alamat  || '';
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal memuat profil', text: data.message || '', confirmButtonColor: '#2D5016' });
            }
        } catch (err) {
            console.error(err);
            Swal.fire({ icon: 'error', title: 'Tidak bisa terhubung ke server', confirmButtonColor: '#2D5016' });
        } finally {
            setBusy(false);
            saveBtn.disabled = false;
        }
    });

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearInvalid();

        // Validasi sisi klien dengan pesan di bawah kolom
        let firstBad = null;
        const mark = (id) => { const el = document.getElementById(id); el.classList.add('is-invalid'); firstBad = firstBad || el; };
        const v = (id) => document.getElementById(id).value.trim();

        if (!v('profile_nama')) mark('profile_nama');
        if (!/^\S+@\S+\.\S+$/.test(v('profile_email'))) mark('profile_email');
        if (!v('profile_telepon')) mark('profile_telepon');

        const pass = document.getElementById('profile_password').value;
        const conf = document.getElementById('profile_confirm_password').value;
        if (pass !== '' && pass.length < 6) mark('profile_password');
        if (pass !== '' && pass !== conf)   mark('profile_confirm_password');

        if (firstBad) { firstBad.focus(); return; }

        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        try {
            const res  = await fetch('<?= base_url('user/updateProfile') ?>', {
                method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            updateToken(data);
            if (data.success) {
                bootstrap.Modal.getInstance(modalEl).hide();
                Swal.fire({ icon: 'success', title: 'Profil diperbarui', text: data.message || '', confirmButtonColor: '#2D5016', timer: 1800, timerProgressBar: true })
                    .then(() => location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Belum berhasil', text: data.message || 'Terjadi kesalahan.', confirmButtonColor: '#2D5016' });
            }
        } catch (err) {
            console.error(err);
            Swal.fire({ icon: 'error', title: 'Gagal menyimpan', text: 'Periksa koneksi lalu coba lagi.', confirmButtonColor: '#2D5016' });
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = SAVE_HTML;
        }
    });
});
</script>
