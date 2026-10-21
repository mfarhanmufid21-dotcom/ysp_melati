<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    // Ganti pengecekan dari 'pelanggan_id' ke 'isLoggedIn'
    if (!session()->get('isLoggedIn')) {
        if ($request->isAJAX()) {
            return service('response')->setJSON([
                'success' => false,
                'redirect' => base_url('login')
            ])->setStatusCode(401);
        }
        
        return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
    }
    
    return $request;
}
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan
    }
}