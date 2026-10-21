<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PelangganModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $pelangganModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pelangganModel = new PelangganModel();
    }

    public function register()
    {
        return view('auth/register');
    }

    public function saveRegister()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'alamat'   => 'required',
            'telepon'  => 'required|min_length[10]|max_length[15]',
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[4]',
            'confirm_password' => 'matches[password]',
            'email'    => 'permit_empty|valid_email|is_unique[pelanggan.email]'
        ];

        if (!$this->validate($rules)) {
            // getErrors() berupa array -> gabungkan jadi teks agar bisa ditampilkan di view
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // Email opsional: kosong harus disimpan sebagai NULL (bukan ''), karena kolom email UNIQUE
        $email = trim((string) $this->request->getPost('email'));
        $email = $email === '' ? null : $email;

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Simpan ke tabel users
        $userData = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'user'
        ];
        $this->userModel->insert($userData);
        $userId = $this->userModel->getInsertID();

        // 2. Simpan ke tabel pelanggan
        $pelangganData = [
            'nama'     => $this->request->getPost('nama'),
            'alamat'   => $this->request->getPost('alamat'),
            'telepon'  => $this->request->getPost('telepon'),
            'email'    => $email,
            'user_id'  => $userId
        ];
        $this->pelangganModel->insert($pelangganData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Pendaftaran gagal, silakan coba lagi.');
        }

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function prosesLogin()
{
    $login = $this->request->getPost('login');  // ← GANTI dari 'username' ke 'login'
    $password = $this->request->getPost('password');

    // Cek apakah login itu email atau username
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        // Login menggunakan email
        $user = $this->userModel->where('email', $login)->first();
    } else {
        // Login menggunakan username
        $user = $this->userModel->where('username', $login)->first();
    }

    if ($user && password_verify($password, $user['password'])) {
        
        // Ambil data pelanggan
        $pelanggan = $this->pelangganModel->where('user_id', $user['id'])->first();
        
        // Set session lengkap
        session()->set([
            'id_user'       => $user['id'],
            'pelanggan_id'  => $pelanggan['id'] ?? $user['id'],
            'username'      => $user['username'],
            'nama'          => $pelanggan['nama'] ?? $user['username'],
            'email'         => $pelanggan['email'] ?? '',
            'role'          => $user['role'],
            'isLoggedIn'    => true
        ]);

        if ($user['role'] == 'admin') {
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->to('/');
        }
    } else {
        return redirect()->back()->with('error', 'Username/Email atau password salah');
    }
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}