<?php /** Modal Edit Profil – tema Clean Boutique. ID modal tetap #editProfileModalNavbar. */ ?>
<div class="modal fade us-modal" id="editProfileModalNavbar" tabindex="-1" aria-labelledby="editProfileTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editProfileTitle">Edit Profil</h5>
                    <span class="modal-sub">Perbarui data diri dan alamat pengiriman Anda.</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form id="profileFormNavbar" novalidate>
                <div class="modal-body">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                    <div class="us-flash error us-inline" id="profileMsg" role="alert">
                        <i class="fas fa-exclamation-circle"></i><span></span>
                    </div>

                    <p class="us-sect">Data Diri</p>

                    <div class="us-field">
                        <label for="navbar_profile_nama">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" id="navbar_profile_nama" autocomplete="name" required>
                    </div>

                    <div class="us-grid2">
                        <div class="us-field">
                            <label for="navbar_profile_email">Email</label>
                            <input type="email" class="form-control" name="email" id="navbar_profile_email" autocomplete="email" required>
                        </div>
                        <div class="us-field">
                            <label for="navbar_profile_telepon">No. Telepon / WhatsApp</label>
                            <input type="tel" class="form-control" name="telepon" id="navbar_profile_telepon" autocomplete="tel" required>
                        </div>
                    </div>

                    <div class="us-field">
                        <label for="navbar_profile_alamat">Alamat Pengiriman</label>
                        <textarea class="form-control" name="alamat" id="navbar_profile_alamat" rows="3" autocomplete="street-address" placeholder="Jalan, RT/RW, kelurahan, kecamatan, kota"></textarea>
                    </div>

                    <p class="us-sect sp">Ganti Password <em style="font-style:normal;text-transform:none;letter-spacing:0;font-weight:400;color:var(--mf-muted)">(opsional)</em></p>

                    <div class="us-grid2">
                        <div class="us-field">
                            <label for="navbar_profile_password">Password Baru</label>
                            <div class="us-pass">
                                <input type="password" class="form-control" name="password" id="navbar_profile_password" autocomplete="new-password" minlength="6">
                                <button type="button" data-toggle-pass="navbar_profile_password" aria-label="Tampilkan password"><i class="far fa-eye"></i></button>
                            </div>
                            <span class="hint">Minimal 6 karakter. Kosongkan jika tidak diganti.</span>
                        </div>
                        <div class="us-field">
                            <label for="navbar_profile_confirm_password">Ulangi Password Baru</label>
                            <div class="us-pass">
                                <input type="password" class="form-control" name="confirm_password" id="navbar_profile_confirm_password" autocomplete="new-password">
                                <button type="button" data-toggle-pass="navbar_profile_confirm_password" aria-label="Tampilkan password"><i class="far fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="mf-btn" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="mf-btn solid" id="saveProfileBtnNavbar"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('editProfileModalNavbar');
    var form    = document.getElementById('profileFormNavbar');
    if (!modalEl || !form) return;

    var msgBox  = document.getElementById('profileMsg');
    var saveBtn = document.getElementById('saveProfileBtnNavbar');
    var csrfEl  = form.querySelector('input[name="<?= csrf_token() ?>"]');
    var f = {
        nama: document.getElementById('navbar_profile_nama'),
        email: document.getElementById('navbar_profile_email'),
        telepon: document.getElementById('navbar_profile_telepon'),
        alamat: document.getElementById('navbar_profile_alamat'),
        pass: document.getElementById('navbar_profile_password'),
        pass2: document.getElementById('navbar_profile_confirm_password')
    };
    var btnLabel = saveBtn.innerHTML;

    function showMsg(text) {
        if (!text) { msgBox.classList.remove('show'); return; }
        msgBox.querySelector('span').textContent = text;
        msgBox.classList.add('show');
    }
    function setCsrf(h) { if (h && csrfEl) csrfEl.value = h; }

    // Tombol mata untuk menampilkan / menyembunyikan password
    modalEl.querySelectorAll('[data-toggle-pass]').forEach(function (b) {
        b.addEventListener('click', function () {
            var input = document.getElementById(b.getAttribute('data-toggle-pass'));
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            b.querySelector('i').className = show ? 'far fa-eye-slash' : 'far fa-eye';
        });
    });

    // Muat data profil saat modal dibuka
    modalEl.addEventListener('show.bs.modal', async function () {
        showMsg('');
        f.pass.value = ''; f.pass2.value = '';
        try {
            var res  = await fetch('<?= base_url('user/getProfile') ?>', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            var data = await res.json();
            if (data.success) {
                f.nama.value    = data.data.nama || '';
                f.email.value   = data.data.email || '';
                f.telepon.value = data.data.telepon || '';
                f.alamat.value  = data.data.alamat || '';
                setCsrf(data.csrf_hash);
            } else {
                showMsg('Data profil belum bisa dimuat. Coba tutup lalu buka kembali.');
            }
        } catch (e) {
            showMsg('Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
        }
    });

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        showMsg('');

        if (!f.nama.value.trim() || !f.email.value.trim() || !f.telepon.value.trim()) {
            showMsg('Nama, email, dan nomor telepon wajib diisi.');
            return;
        }
        if (f.pass.value !== '') {
            if (f.pass.value.length < 6)       { showMsg('Password baru minimal 6 karakter.'); return; }
            if (f.pass.value !== f.pass2.value) { showMsg('Konfirmasi password tidak cocok.'); return; }
        }

        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        try {
            var res  = await fetch('<?= base_url('user/updateProfile') ?>', {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            var data = await res.json();
            setCsrf(data.csrf_hash);

            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message || 'Profil berhasil diperbarui', confirmButtonColor: '#1f5c46' })
                    .then(function () { location.reload(); });
            } else {
                showMsg(data.message || 'Profil gagal disimpan. Silakan coba lagi.');
            }
        } catch (err) {
            showMsg('Gagal menyimpan data. Silakan coba lagi.');
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = btnLabel;
        }
    });
});
</script>
