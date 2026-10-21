<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Jika admin sudah login, redirect ke dashboard admin
        if (session()->get('isLoggedIn') && session()->get('role') === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        
        
        $shop = new \App\Controllers\Shop();
        return $shop->landing();
    }
}