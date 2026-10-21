<?php
/** Kartu produk. Variabel: $p (array produk), $label (string, opsional), $isLoggedCustomer (bool) */
$label            = $label ?? '';
$isLoggedCustomer = $isLoggedCustomer ?? (session()->get('pelanggan_id') !== null);
$stok   = (int) ($p['stok'] ?? 0);
$promo  = !empty($p['is_promo']) && ($p['harga_diskon'] ?? 0) > 0;
$img    = (!empty($p['gambar']) && file_exists(FCPATH . 'uploads/' . $p['gambar'])) ? base_url('uploads/' . $p['gambar']) : null;
$detail = base_url('shop/detail/' . $p['id']);
?>
<article class="mf-card mf-reveal">
    <a class="mf-card-img" href="<?= $detail ?>" aria-label="Lihat <?= esc($p['nama_barang']) ?>">
        <?php if ($img): ?>
            <img src="<?= $img ?>" alt="<?= esc($p['nama_barang']) ?> – Bunga Melati YSP Jasmine" loading="lazy">
        <?php else: ?>
            <div class="ph">🌸</div>
        <?php endif; ?>
        <div class="mf-badges">
            <?php if ($label): ?><span class="mf-badge best"><?= esc($label) ?></span><?php endif; ?>
            <?php if ($promo): ?><span class="mf-badge sale">-<?= round((($p['harga'] - $p['harga_diskon']) / $p['harga']) * 100) ?>%</span><?php endif; ?>
            <?php if ($stok <= 0): ?><span class="mf-badge out">Habis</span>
            <?php elseif ($stok <= 5): ?><span class="mf-badge low">Sisa <?= $stok ?></span><?php endif; ?>
        </div>
    </a>
    <div class="mf-card-body">
        <h3 class="mf-card-name"><a href="<?= $detail ?>"><?= esc($p['nama_barang']) ?></a></h3>
        <?php if (!empty($p['rating']) && $p['rating'] > 0): ?>
            <div class="mf-rate"><i class="fas fa-star"></i> <?= number_format($p['rating'], 1) ?></div>
        <?php endif; ?>
        <div class="mf-price">
            <?php if ($promo): ?>
                <s>Rp <?= number_format($p['harga'], 0, ',', '.') ?></s><em>Rp <?= number_format($p['harga_diskon'], 0, ',', '.') ?></em>
            <?php else: ?>
                Rp <?= number_format($p['harga'], 0, ',', '.') ?>
            <?php endif; ?>
        </div>
        <?php if (!empty($p['terjual'])): ?><div class="mf-meta"><?= (int) $p['terjual'] ?> terjual</div><?php endif; ?>
        <div class="mf-card-actions">
            <?php if ($isLoggedCustomer): ?>
                <?php if ($stok > 0): ?>
                    <form action="<?= base_url('shop/addToCart/' . $p['id']) ?>" method="post" class="add-to-cart-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="mf-btn"><i class="fas fa-shopping-bag"></i> Tambah ke Keranjang</button>
                    </form>
                <?php else: ?>
                    <button class="mf-btn" disabled>Stok Habis</button>
                <?php endif; ?>
            <?php else: ?>
                <button type="button" class="mf-btn" onclick="showAuthAlert()"><i class="fas fa-lock"></i> Login untuk Beli</button>
            <?php endif; ?>
        </div>
    </div>
</article>
