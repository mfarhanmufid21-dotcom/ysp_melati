<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah sudah login secara umum
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // 2. Cek apakah rolenya adalah admin
        if (session()->get('role') !== 'admin') {
            // Jika dia pelanggan tapi maksa masuk ke /admin, lempar ke shop
            return redirect()->to('/shop')->with('error', 'Akses ditolak! Halaman ini hanya untuk Admin.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}