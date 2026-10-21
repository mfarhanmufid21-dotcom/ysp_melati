<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Shop');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// ============================================================
// 1. LANDING PAGE & SHOP (PUBLIC)
// ============================================================
$routes->get('/',                                 'Home::index');
$routes->get('shop',                             'Shop::index');
$routes->get('shop/search',                      'Shop::index');
$routes->get('shop/produk/(:num)',               'Shop::detail/$1');
$routes->get('shop/cart',                        'Shop::cart');
$routes->get('katalog',                          'Shop::index');

// Halaman informasi (masing-masing punya halaman sendiri)
$routes->get('best-seller',                      'Pages::bestSeller');
$routes->get('tentang-kami',                     'Pages::tentang');
$routes->get('cara-pesan',                       'Pages::caraPesan');
$routes->get('testimoni',                        'Pages::testimoni');
$routes->get('kontak',                           'Pages::kontak');

// ============================================================
// 2. AUTH
// ============================================================
$routes->get('login',           'Auth::login');
$routes->post('login',          'Auth::prosesLogin');
$routes->get('logout',          'Auth::logout');
$routes->get('register',        'Auth::register');
$routes->post('register',       'Auth::saveRegister');

// ============================================================
// 3. SHOP AJAX
// ============================================================
$routes->post('shop/addToCart/(:num)', 'Shop::addToCart/$1');
$routes->post('shop/updateCart',        'Shop::updateCart'); 
$routes->post('shop/remove',            'Shop::remove');
$routes->get('shop/detail/(:num)',      'Shop::detail/$1');

// ============================================================
// 4. SHOP – AREA TERPROTEKSI (wajib login)
// ============================================================
$routes->group('shop', ['filter' => 'auth'], function ($routes) {
    $routes->get('checkout',         'Shop::checkout');
    $routes->post('checkout',        'Shop::processCheckout');
    $routes->post('ulasan',          'Shop::kirimUlasan');
    $routes->get('riwayat',          'Shop::riwayat');
    $routes->get('nota/(:num)',      'Shop::nota/$1');
});

// ============================================================
// 5. ADMIN
// ============================================================
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/',              'Admin\Dashboard::index');
    $routes->get('dashboard',      'Admin\Dashboard::index');

    // ===== BARANG =====
    $routes->group('barang', function ($routes) {
        $routes->get('/',                    'Admin\Barang::index');
        $routes->get('getProducts',          'Admin\Barang::getProducts');
        $routes->get('getProduct/(:num)',    'Admin\Barang::getProduct/$1');
        $routes->post('create',              'Admin\Barang::create');
        $routes->post('update/(:num)',       'Admin\Barang::update/$1');
        $routes->delete('delete/(:num)',     'Admin\Barang::delete/$1');
    });

    // ===== PELANGGAN (READ ONLY) =====
    $routes->group('pelanggan', function ($routes) {
        $routes->get('/', 'Admin\Pelanggan::index');
    });

    // ===== TRANSAKSI =====
    $routes->group('transaksi', function ($routes) {
        $routes->get('/',                               'Admin\Transaksi::index');
        $routes->post('update-status',                  'Admin\Transaksi::updateStatusPost');
        $routes->get('updateStatus/(:num)/(:any)',      'Admin\Transaksi::updateStatus/$1/$2');
        $routes->get('getDetail/(:num)',                'Admin\Transaksi::getDetail/$1');
        $routes->post('verifikasiPembayaran',           'Admin\Transaksi::verifikasiPembayaran');
        $routes->post('verifikasiPembayaranCOD',        'Admin\Transaksi::verifikasiPembayaranCOD');
    });

   // / ===== ULASAN =====
$routes->group('ulasan', function ($routes) {
    $routes->get('/', 'Admin\Ulasan::index');
    $routes->post('update-status', 'Admin\Ulasan::updateStatus');
    $routes->post('balas', 'Admin\Ulasan::balas');
    $routes->delete('hapus/(:num)', 'Admin\Ulasan::hapus/$1');
});

    // ===== LAPORAN  =====
    $routes->group('laporan', function ($routes) {
        $routes->get('/',                    'Admin\Laporan::index');
        $routes->get('transaksi',            'Admin\Laporan::transaksi');
        $routes->get('barang',               'Admin\Laporan::barang');
        $routes->get('cetakpdf_transaksi', 'Admin\Laporan::cetakpdf_transaksi');
        $routes->get('cetakpdf_penjualan', 'Admin\Laporan::cetakpdf_penjualan');
        $routes->get('cetakpdf_barang', 'Admin\Laporan::cetakpdf_barang'); 
        $routes->get('cetak-excel',          'Admin\Laporan::cetakExcel');
    });
});

// ============================================================
// 6. USER DASHBOARD & PROFILE
// ============================================================
$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard',     'User::dashboard');
    $routes->get('getProfile',    'User::getProfile');     
    $routes->post('updateProfile', 'User::updateProfile');  
});

// ===== ULASAN =====
$routes->group('ulasan', ['filter' => 'auth'], function ($routes) {
    $routes->post('tambah', 'Ulasan::tambah');
    $routes->get('produk/(:num)', 'Ulasan::getByProduk/$1');
});