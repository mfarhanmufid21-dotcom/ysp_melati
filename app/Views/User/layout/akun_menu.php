<?php
/**
 * Menu akun (sisi kiri di desktop, tab geser di HP).
 * Variabel: $akunActive ('dashboard' | 'riwayat'), $akunNama, $akunEmail
 */
$akunActive = $akunActive ?? '';
$akunNama   = trim((string) ($akunNama ?? '')) ?: 'Pengguna';
$akunEmail  = (string) ($akunEmail ?? '');
$inisial    = mb_strtoupper(mb_substr($akunNama, 0, 1));

$akunCart = 0;
$akunCartData = session()->get('cart');
if ($akunCartData && is_array($akunCartData)) {
    foreach ($akunCartData as $it) { $akunCart += (int) ($it['qty'] ?? 0); }
}
?>
<aside class="us-side" aria-label="Menu akun">
    <div class="us-profile">
        <span class="us-avatar" aria-hidden="true"><?= esc($inisial) ?></span>
        <div>
            <b><?= esc($akunNama) ?></b>
            <?php if ($akunEmail !== ''): ?><span class="mail"><?= esc($akunEmail) ?></span><?php endif; ?>
        </div>
    </div>

    <nav class="us-menu">
        <a href="<?= base_url('user/dashboard') ?>" class="<?= $akunActive === 'dashboard' ? 'on' : '' ?>" <?= $akunActive === 'dashboard' ? 'aria-current="page"' : '' ?>>
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="<?= base_url('shop/riwayat') ?>" class="<?= $akunActive === 'riwayat' ? 'on' : '' ?>" <?= $akunActive === 'riwayat' ? 'aria-current="page"' : '' ?>>
            <i class="fas fa-receipt"></i> Riwayat Pesanan
        </a>
        <button type="button" data-bs-toggle="modal" data-bs-target="#editProfileModalNavbar">
            <i class="far fa-id-card"></i> Edit Profil
        </button>
        <a href="<?= base_url('shop/cart') ?>">
            <i class="fas fa-shopping-bag"></i> Keranjang
            <?php if ($akunCart > 0): ?><span class="us-count"><?= $akunCart ?></span><?php endif; ?>
        </a>
        <a href="<?= base_url('shop') ?>"><i class="fas fa-store"></i> Lanjut Belanja</a>
        <a href="<?= base_url('logout') ?>" class="danger" onclick="return confirm('Yakin ingin keluar?')">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
    </nav>
</aside>
