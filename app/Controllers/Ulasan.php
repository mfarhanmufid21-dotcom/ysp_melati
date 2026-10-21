<?php

namespace App\Controllers;

use App\Models\UlasanModel;
use App\Models\BarangModel;
use App\Models\TransaksiModel;
use App\Models\DetailtransaksiModel;

class Ulasan extends BaseController
{
    protected $ulasanModel;
    protected $barangModel;
    protected $transaksiModel;
    protected $detailModel;

    public function __construct()
    {
        $this->ulasanModel = new UlasanModel();
        $this->barangModel = new BarangModel();
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel = new DetailtransaksiModel();
    }

    public function tambah()
{
    ///if (!$this->request->isAJAX()) {
       /// return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
    //}

    $userId = session()->get('id_user');
    if (!$userId) {
        return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
    }

    $transaksiId = $this->request->getPost('transaksi_id');  // Ambil transaksi_id
    $rating = $this->request->getPost('rating');
    $komentar = $this->request->getPost('komentar');
    
    // Ambil detail produk dari transaksi
    $details = $this->detailModel->where('transaksi_id', $transaksiId)->findAll();
    
    if (empty($details)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Data produk tidak ditemukan']);
    }
    
    // Simpan ulasan untuk setiap produk
    foreach ($details as $detail) {
        // Cek apakah sudah pernah review
        $sudahReview = $this->ulasanModel
            ->where('id_barang', $detail['barang_id'])
            ->where('id_user', $userId)
            ->first();
        
        if (!$sudahReview) {
            // Upload foto
            $foto = null;
            $file = $this->request->getFile('foto_ulasan');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = 'review_' . time() . '_' . rand(100, 999) . '.' . $file->getExtension();
                $file->move(FCPATH . 'uploads/ulasan', $newName);
                $foto = $newName;
            }
            
            $this->ulasanModel->insert([
                'id_barang' => $detail['barang_id'],
                'id_user' => $userId,
                'rating' => $rating,
                'komentar' => $komentar,
                'foto_ulasan' => $foto,
                'transaksi_id' => $transaksiId,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Terima kasih! Ulasan Anda akan ditampilkan setelah disetujui admin.'
    ]);
}
public function getByProduk($id_barang)
{
    $ulasan = $this->ulasanModel
        ->select('ulasan.*, pelanggan.nama as nama_pelanggan, pelanggan.foto, pelanggan.user_id')
        ->join('pelanggan', 'pelanggan.id = ulasan.id_user', 'left')  // ✅ JOIN LANGSUNG
        ->where('ulasan.id_barang', $id_barang)
        ->where('ulasan.status', 'approved')
        ->orderBy('ulasan.id', 'DESC')
        ->findAll();

    $formatted = array_map(function($u) {
        // Ambil nama dari pelanggan
        $nama = !empty($u['nama_pelanggan']) ? $u['nama_pelanggan'] : 'Pelanggan YSP';
        
        return [
            'id' => $u['id'],
            'id_barang' => $u['id_barang'],
            'rating' => $u['rating'],
            'komentar' => $u['komentar'],
            'balasan' => $u['balasan'],
            'foto_ulasan' => $u['foto_ulasan'],
            'tanggal_ulasan' => $u['tanggal_ulasan'] ?? $u['created_at'],
            'nama_pelanggan' => $nama,
            'foto' => $u['foto'] ?? null,
            'status' => $u['status']
        ];
    }, $ulasan);

    return $this->response->setJSON([
        'success' => true,
        'data' => $formatted,
        'total' => count($formatted)
    ]);
}
}