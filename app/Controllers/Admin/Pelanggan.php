<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PelangganModel;
use App\Models\UserModel;

class Pelanggan extends BaseController
{
    protected $pelanggan;
    protected $user;

    public function __construct()
    {
        $this->pelanggan = new PelangganModel();
        $this->user = new UserModel();
    }

    // ============================================
    // INDEX - TAMPIL DATA PELANGGAN (READ ONLY)
    // ============================================
    public function index()
    {
        // Ambil data pelanggan dengan join ke users
        $data['pelanggan'] = $this->pelanggan->getPelangganWithUser();
        
        // Jika belum ada data, sinkronisasi dari users yang sudah register
        if (empty($data['pelanggan'])) {
            $this->sinkronisasiPelanggan();
            $data['pelanggan'] = $this->pelanggan->getPelangganWithUser();
        }
        
        return view('Admin/pelanggan/index', $data);
    }
    
    // ============================================
    // SINKRONISASI PELANGGAN DARI USERS
    // ============================================
    private function sinkronisasiPelanggan()
    {
        // Ambil semua user dengan role 'user' atau 'pelanggan'
        $users = $this->user->whereIn('role', ['user', 'pelanggan'])->findAll();
        
        foreach ($users as $user) {
            // Cek apakah sudah ada di tabel pelanggan
            $existing = $this->pelanggan->where('user_id', $user['id'])->first();
            
            if (!$existing) {
                // Insert ke tabel pelanggan
                $this->pelanggan->insert([
                    'nama'     => $user['username'] ?? 'User',
                    'email'    => $user['email'] ?? '',
                    'user_id'  => $user['id'],
                    'telepon'  => '',
                    'alamat'   => ''
                ]);
            }
        }
    }
}