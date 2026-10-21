<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\UlasanModel;

/**
 * Halaman informasi publik (masing-masing punya URL sendiri):
 *   /best-seller  /tentang-kami  /cara-pesan  /testimoni  /kontak
 */
class Pages extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    // ======================
    // BEST SELLER
    // ======================
    public function bestSeller()
    {
        $barang = new BarangModel();

        $produk = $barang
            ->select("barang.*, (SELECT ROUND(AVG(u.rating), 1) FROM ulasan u WHERE u.id_barang = barang.id AND u.status = 'approved') AS rating", false)
            ->orderBy('terjual', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll(12);

        return view('pages/best_seller', ['produk' => $produk]);
    }

    // ======================
    // TENTANG KAMI
    // ======================
    public function tentang()
    {
        return view('pages/tentang');
    }

    // ======================
    // CARA PESAN
    // ======================
    public function caraPesan()
    {
        return view('pages/cara_pesan');
    }

    // ======================
    // TESTIMONI
    // ======================
    public function testimoni()
    {
        $ulasan = new UlasanModel();

        $testimoni = $ulasan
            ->select('ulasan.*, barang.nama_barang, users.username, pelanggan.nama as nama_pelanggan')
            ->join('barang', 'barang.id = ulasan.id_barang', 'left')
            ->join('users', 'users.id = ulasan.id_user', 'left')
            ->join('pelanggan', 'pelanggan.user_id = users.id', 'left')
            ->where('ulasan.status', 'approved')
            ->orderBy('ulasan.id', 'DESC')
            ->paginate(12, 'default');

        return view('pages/testimoni', [
            'testimoni'  => $testimoni,
            'pager'      => $ulasan->pager,
        ]);
    }

    // ======================
    // KONTAK
    // ======================
    public function kontak()
    {
        return view('pages/kontak');
    }
}
