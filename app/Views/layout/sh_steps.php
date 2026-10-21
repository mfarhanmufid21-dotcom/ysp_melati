<?php
/** Indikator langkah belanja. Variabel: $shStep (1 = Keranjang, 2 = Checkout, 3 = Selesai) */
$shStep = $shStep ?? 1;
$shLabels = [1 => 'Keranjang', 2 => 'Checkout', 3 => 'Selesai'];
?>
<nav class="sh-steps" aria-label="Langkah belanja">
    <?php foreach ($shLabels as $n => $label):
        $cls = $n < $shStep ? 'done' : ($n === $shStep ? 'on' : ''); ?>
        <?php if ($n > 1): ?><span class="sh-step-line <?= $n <= $shStep ? 'done' : '' ?>"></span><?php endif; ?>
        <span class="sh-step <?= $cls ?>" <?= $n === $shStep ? 'aria-current="step"' : '' ?>>
            <span class="n"><?= $n < $shStep ? '<i class="fas fa-check" style="font-size:.7rem"></i>' : $n ?></span>
            <span class="t"><?= $label ?></span>
        </span>
    <?php endforeach; ?>
</nav>
