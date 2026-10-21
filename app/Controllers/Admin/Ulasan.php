<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UlasanModel;

class Ulasan extends BaseController
{
    protected $ulasanModel;

    public function __construct()
    {
        $this->ulasanModel = new UlasanModel();
    }

    public function index()
    {
        
        $ulasan = $this->ulasanModel
            ->select('ulasan.*, barang.nama_barang, pelanggan.nama as nama_pelanggan, users.username')
            ->join('barang', 'barang.id = ulasan.id_barang', 'left')
            // 1. Hubungkan dulu id_user ulasan ke id tabel users
            ->join('users', 'users.id = ulasan.id_user', 'left')  
            // 2. Hubungkan tabel pelanggan berdasarkan relasi user_id-nya
            ->join('pelanggan', 'pelanggan.user_id = users.id', 'left')  
            ->orderBy('ulasan.id', 'DESC')
            ->findAll();

        $data['ulasan'] = $ulasan;
        $data['title'] = 'Kelola Ulasan';

        return view('Admin/ulasan/index', $data);
    }


    public function updateStatus()
    {
        $json = $this->request->getJSON();
        $id = $json->id;
        $status = $json->status;

        $this->ulasanModel->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status ulasan berhasil diupdate'
        ]);
    }

    public function balas()
    {
        $json = $this->request->getJSON();
        $id = $json->id;
        $balasan = $json->balasan;

        $this->ulasanModel->update($id, [
            'balasan' => $balasan,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Balasan berhasil dikirim'
        ]);
    }

    public function hapus($id)
    {
        // Hapus foto jika ada
        $ulasan = $this->ulasanModel->find($id);
        if ($ulasan && !empty($ulasan['foto_ulasan'])) {
            $fotoPath = FCPATH . 'uploads/ulasan/' . $ulasan['foto_ulasan'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $this->ulasanModel->delete($id);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Ulasan berhasil dihapus'
        ]);
    }
}