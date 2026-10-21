<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php /* $navActive (opsional) menentukan menu header yang ditandai; default 'produk' seperti sebelumnya. */ ?>
<?= view('layout/mf_header', ['mfActive' => $navActive ?? 'produk', 'mfProfileModal' => true]) ?>

<!-- Modal Edit Profil (dipakai bersama oleh semua halaman yang memuat navbar ini) -->
<?= view('User/layout/modal_profil') ?>
