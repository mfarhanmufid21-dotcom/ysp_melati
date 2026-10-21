<?php

/**
 * Helper tampilan area akun (dashboard & riwayat pesanan).
 * Dipakai lewat: helper('akun');
 */

if (!function_exists('us_rp')) {
    function us_rp($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}

if (!function_exists('us_invoice')) {
    /** Nomor invoice (pakai kolom invoice, jika kosong pakai id). */
    function us_invoice(array $t): string
    {
        return !empty($t['invoice']) ? $t['invoice'] : '#' . str_pad((string) $t['id'], 6, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('us_tanggal')) {
    /** 14 Mei 2026, 11.35 */
    function us_tanggal(?string $waktu, bool $denganJam = true): string
    {
        if (empty($waktu) || ($ts = strtotime($waktu)) === false) {
            return '-';
        }
        $bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $teks  = date('j', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
        return $denganJam ? $teks . ', ' . date('H.i', $ts) : $teks;
    }
}

if (!function_exists('us_status')) {
    /** Status pesanan => [label, kelas badge, ikon] */
    function us_status(?string $status): array
    {
        switch ($status) {
            case 'Pending':  return ['Menunggu Konfirmasi', 'pending', 'fa-clock'];
            case 'Diproses': return ['Sedang Diproses',     'proses',  'fa-box-open'];
            case 'Dikirim':  return ['Sedang Dikirim',      'kirim',   'fa-truck'];
            case 'Selesai':  return ['Selesai',             'selesai', 'fa-check-circle'];
            case 'Batal':    return ['Dibatalkan',          'batal',   'fa-times-circle'];
            default:         return [(string) $status,      'pending', 'fa-clock'];
        }
    }
}

if (!function_exists('us_pay')) {
    /** Status pembayaran => [label, kelas badge, ikon] */
    function us_pay(array $t): array
    {
        $s = strtolower((string) ($t['status_pembayaran'] ?? 'pending'));
        $m = strtolower((string) ($t['metode_pembayaran'] ?? ''));

        if ($s === 'lunas')               return ['Lunas',               'lunas',   'fa-check'];
        if ($s === 'menunggu_verifikasi') return ['Menunggu Verifikasi', 'verif',   'fa-hourglass-half'];
        if ($s === 'gagal')               return ['Pembayaran Gagal',    'gagal',   'fa-exclamation'];
        if ($s === 'cod' || $m === 'cod') return ['Bayar di Tempat',    'cod',     'fa-money-bill-wave'];
        return ['Belum Dibayar', 'pending', 'fa-wallet'];
    }
}

if (!function_exists('us_group')) {
    /** Kelompok filter di halaman riwayat. */
    function us_group(?string $status): string
    {
        if ($status === 'Selesai') return 'selesai';
        if ($status === 'Batal')   return 'batal';
        return 'proses';   // Pending, Diproses, Dikirim
    }
}
