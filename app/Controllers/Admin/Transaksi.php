<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\DetailtransaksiModel; 

class Transaksi extends BaseController
{
    protected $transaksi;

    public function __construct()
    {
        $this->transaksi = new TransaksiModel();
    }

    // ============================================
    // LIST TRANSAKSI (READ ONLY)
    // ============================================
    public function index()
    {
        $data['transaksi'] = $this->transaksi
            ->select('transaksi.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.telepon') 
            ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id')
            ->orderBy('transaksi.id', 'DESC')
            ->findAll();

        return view('Admin/transaksi/index', $data);
    }

    // ============================================
    // UPDATE STATUS (AJAX) - METHOD GET (via URL)
    // ============================================
    public function updateStatus($id, $status)
    {
        $allowedStatus = ['Pending', 'Diproses', 'Dikirim', 'Selesai'];
        if (!in_array($status, $allowedStatus)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Status tidak valid']);
        }
        
        $transaksi = $this->transaksi->find($id);
        if (!$transaksi) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
        }
        
        $this->transaksi->update($id, ['status' => $status]);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui menjadi ' . $status
        ]);
    }

    // ============================================
    // UPDATE STATUS VIA POST (untuk route update-status)
    // ============================================
    public function updateStatusPost()
    {
        $data = $this->request->getJSON();
        $id = $data->id;
        $status = $data->status;
        
        $allowedStatus = ['Pending', 'Diproses', 'Dikirim', 'Selesai'];
        if (!in_array($status, $allowedStatus)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Status tidak valid']);
        }
        
        $transaksi = $this->transaksi->find($id);
        if (!$transaksi) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
        }
        
        $this->transaksi->update($id, ['status' => $status]);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui menjadi ' . $status
        ]);
    }

    // ============================================
    // VERIFIKASI PEMBAYARAN (AJAX)
    // ============================================
    public function verifikasiPembayaran()
    {
        $data = $this->request->getJSON();
        $id = $data->id;
        $status_pembayaran = $data->status_pembayaran;
        
        $allowedStatus = ['lunas', 'gagal', 'pending', 'menunggu_verifikasi'];
        if (!in_array($status_pembayaran, $allowedStatus)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Status tidak valid']);
        }
        
        $transaksi = $this->transaksi->find($id);
        if (!$transaksi) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
        }
        
        $this->transaksi->update($id, ['status_pembayaran' => $status_pembayaran]);
        
        $message = $status_pembayaran == 'lunas' ? 'Pembayaran berhasil dikonfirmasi' : 'Pembayaran ditolak';
        
        return $this->response->setJSON([
            'success' => true,
            'message' => $message
        ]);
    }

    // ============================================
    // VERIFIKASI PEMBAYARAN COD (DIPERBAIKI)
    // ============================================
    public function verifikasiPembayaranCOD()
    {
        $data = $this->request->getJSON();
        $id = $data->id;
        
        $transaksi = $this->transaksi->find($id);
        if (!$transaksi) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
        }
        
        // Hanya update status_pembayaran (kolom yang ada di database)
        $this->transaksi->update($id, [
            'status_pembayaran' => 'lunas'
        ]);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pembayaran COD berhasil dikonfirmasi'
        ]);
    }

    // ============================================
    // GET DETAIL TRANSAKSI (AJAX)
    // ============================================
    public function getDetail($id)
    {
        $transaksi = $this->transaksi
            ->select('transaksi.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.telepon')
            ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id')
            ->find($id);
        
        if (!$transaksi) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
        }
        
        $detailModel = new DetailtransaksiModel();
        $detail = $detailModel
            ->select('detail_transaksi.*, barang.nama_barang')
            ->join('barang', 'barang.id = detail_transaksi.barang_id')
            ->where('transaksi_id', $id)
            ->findAll();
        
        return $this->response->setJSON([
            'success' => true,
            'transaksi' => $transaksi,
            'detail' => $detail
        ]);
    }
}