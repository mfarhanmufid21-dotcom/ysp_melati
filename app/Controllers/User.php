<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\TransaksiModel;

class User extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }

    private function checkLogin()
    {
        // Gunakan id_user (dari tabel users)
        if (!$this->session->get('id_user')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        return null;
    }

    public function dashboard()
    {
        $redirect = $this->checkLogin();
        if ($redirect) return $redirect;

        $pelangganModel = new PelangganModel();
        $transaksiModel = new TransaksiModel();

        // Ambil data pelanggan berdasarkan user_id (dari session)
        $userId = $this->session->get('id_user');
        $pelanggan = $pelangganModel->where('user_id', $userId)->first();
        
        if (!$pelanggan) {
            return redirect()->to('/login')->with('error', 'Data pelanggan tidak ditemukan');
        }
        
        $pelangganId = $pelanggan['id']; // id dari tabel pelanggan

        // Statistik
        $data['total_pesanan'] = $transaksiModel->where('pelanggan_id', $pelangganId)->countAllResults();
        $data['pesanan_diproses'] = $transaksiModel->where('pelanggan_id', $pelangganId)
                                    ->whereIn('status', ['Pending', 'Diproses', 'Dikirim'])->countAllResults();
        $data['pesanan_selesai'] = $transaksiModel->where('pelanggan_id', $pelangganId)
                                   ->where('status', 'Selesai')->countAllResults();
        
        // Pesanan terbaru (limit 5)
        $data['pesanan_terbaru'] = $transaksiModel
            ->where('pelanggan_id', $pelangganId)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->findAll();
        
        $data['nama'] = $pelanggan['nama'] ?? $this->session->get('nama');
        $data['pelanggan'] = $pelanggan; // untuk kartu "Data Akun" di dashboard
        
        return view('User/shop/dashboard', $data);
    }


    public function getProfile()
{
    $pelangganModel = new \App\Models\PelangganModel();
    $userId = session()->get('id_user');
    
    $pelanggan = $pelangganModel->where('user_id', $userId)->first();
    
    if (!$pelanggan) {
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
    }
    
    return $this->response->setJSON([
        'success' => true,
        'data' => $pelanggan,
        'csrf_hash' => csrf_hash()
    ]);
}

public function updateProfile()
{
    $pelangganModel = new \App\Models\PelangganModel();
    $userModel = new \App\Models\UserModel();
    
    $userId = session()->get('id_user');
    $pelanggan = $pelangganModel->where('user_id', $userId)->first();
    
    if (!$pelanggan) {
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
    }
    
    // Update data pelanggan
    $pelangganModel->update($pelanggan['id'], [
        'nama'    => $this->request->getPost('nama'),
        'alamat'  => $this->request->getPost('alamat'),
        'telepon' => $this->request->getPost('telepon'),
        'email'   => $this->request->getPost('email')
    ]);
    
    // Update password (jika diisi)
    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $confirm = $this->request->getPost('confirm_password');
        if ($password !== $confirm) {
            return $this->response->setJSON(['success' => false, 'message' => 'Konfirmasi password tidak cocok', 'csrf_hash' => csrf_hash()]);
        }
        $userModel->update($userId, [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
    
    // Update session
    session()->set('nama', $this->request->getPost('nama'));
    
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Profil berhasil diperbarui',
        'csrf_hash' => csrf_hash()
    ]);
}
}