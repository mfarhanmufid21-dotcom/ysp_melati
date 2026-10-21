<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiModel;
use App\Models\DetailtransaksiModel;
use App\Models\UlasanModel;
use App\Models\PelangganModel;
use CodeIgniter\I18n\Time;

class Shop extends BaseController
{
    protected $barang;
    protected $session;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->barang = new BarangModel();
        $this->session = session();
    }

    // ======================
    // LANDING PAGE
    // ======================
    public function landing()
    {
        $ulasanModel = new UlasanModel();
        
        $data['testimoni'] = $ulasanModel
            ->select('ulasan.*, barang.nama_barang, users.username, pelanggan.nama as nama_pelanggan')
            ->join('barang', 'barang.id = ulasan.id_barang', 'left')
            ->join('users', 'users.id = ulasan.id_user', 'left')
            ->join('pelanggan', 'pelanggan.user_id = users.id', 'left')
            ->where('ulasan.status', 'approved')
            ->orderBy('ulasan.id', 'DESC')
            ->limit(6)
            ->findAll();
        
        $data['produk'] = $this->barang->where('stok >', 0)->findAll(8);
        $data['isLoggedIn'] = (bool) $this->session->get('id_user');

        return view('landing_page', $data);
    }

    // ======================
    // KATALOG PRODUK - DIPERBAIKI
    // ======================
    public function index()
    {
        // Ambil parameter filter dari URL
        $keyword = $this->request->getGet('search');
        $sort    = $this->request->getGet('sort');
        $stock   = $this->request->getGet('stock');
        
        // Mulai query builder
        $builder = $this->barang;
        
        // Filter pencarian
        if (!empty($keyword)) {
            $builder = $builder->like('nama_barang', $keyword);
        }
        
        // ===== FILTER STOK (TANPA is_roncean) =====
        if ($stock == 'tersedia') {
            // TERSEDIA: stok > 0 DAN BUKAN roncean (melati segar)
            $builder = $builder->where('stok >', 0)
                              ->where('nama_barang NOT LIKE', '%ronce%')
                              ->where('nama_barang NOT LIKE', '%pengantin%')
                              ->where('nama_barang NOT LIKE', '%gelang%')
                              ->where('nama_barang NOT LIKE', '%set%');
        } elseif ($stock == 'po') {
            // PRE-ORDER: hanya produk roncean
            $builder = $builder->groupStart()
                              ->where('nama_barang LIKE', '%ronce%')
                              ->orWhere('nama_barang LIKE', '%pengantin%')
                              ->orWhere('nama_barang LIKE', '%gelang%')
                              ->orWhere('nama_barang LIKE', '%set%')
                              ->groupEnd();
        }
        
        // Sorting
        if ($sort == 'newest') {
            $builder = $builder->orderBy('id', 'DESC');
        } elseif ($sort == 'price_asc') {
            $builder = $builder->orderBy('harga', 'ASC');
        } elseif ($sort == 'price_desc') {
            $builder = $builder->orderBy('harga', 'DESC');
        } elseif ($sort == 'popular') {
            $builder = $builder->orderBy('terjual', 'DESC');
        } else {
            $builder = $builder->orderBy('id', 'DESC');
        }
        
        // Pagination
        $currentPage = $this->request->getGet('page') ?: 1;
        $perPage = 12;
        $total = $builder->countAllResults(false);
        
        $data['barang'] = $builder->paginate($perPage, 'default', $currentPage);
        
        // ========== TAMBAHAN UNTUK PROMO ==========
        foreach ($data['barang'] as &$item) {
            $item['final_price'] = ($item['is_promo'] && $item['harga_diskon']) 
                ? $item['harga_diskon'] 
                : $item['harga'];
        }
        
        // Membuat pagination links
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');
        
        $data['total_produk'] = $total;
        $data['keyword'] = $keyword;
        $data['sort'] = $sort;
        $data['stockFilter'] = $stock;
        $data['isLoggedIn'] = (bool) $this->session->get('id_user');
        
        return view('User/shop/katalog', $data);
    }

    // ======================
    // DETAIL PRODUK 
    // ======================
    public function detail($id)
    {
        $ulasanModel = new UlasanModel();

        $data['produk'] = $this->barang->find($id);

        if (!$data['produk']) {
            return redirect()->to('/shop')->with('error', 'Produk tidak ditemukan');
        }

        $data['produk']['final_price'] = ($data['produk']['is_promo'] && $data['produk']['harga_diskon']) 
            ? $data['produk']['harga_diskon'] 
            : $data['produk']['harga'];

        $data['rataRating'] = $ulasanModel
            ->selectAvg('rating')
            ->where('id_barang', $id)
            ->where('status', 'approved')
            ->first()['rating'] ?? 0;
        
        $data['totalUlasan'] = $ulasanModel
            ->where('id_barang', $id)
            ->where('status', 'approved')
            ->countAllResults();
        
        $data['rekomendasi'] = $this->barang
            ->where('id !=', $id)
            ->limit(4)
            ->findAll();

        $data['ulasan'] = $ulasanModel
            ->where('id_barang', $id)
            ->findAll();
        
        $data['isLoggedIn'] = (bool) $this->session->get('id_user');

        return view('User/shop/detail', $data);
    }
    
    // ======================
    // CART VIEW
    // ======================
    public function cart()
    {
        $cart = $this->session->get('cart') ?: [];
        
        $barangModel = new \App\Models\BarangModel();
        foreach ($cart as $id => &$item) {
            $produk = $barangModel->find($id);
            if ($produk) {
                $item['is_roncean'] = $produk['is_roncean'] ?? 0;
                $item['nama_barang'] = $produk['nama_barang'] ?? $item['nama_barang'] ?? 'Produk';
                $item['harga'] = $produk['harga'] ?? $item['harga'];
                $item['gambar'] = $produk['gambar'] ?? $item['gambar'] ?? '';
            } else {
                $item['is_roncean'] = 0;
            }
        }
        
        $data['cart'] = $cart;
        $data['isLoggedIn'] = (bool) $this->session->get('id_user');
        
        return view('User/shop/cart', $data);
    }

    // ======================
    // ADD TO CART
    // ======================
    public function addToCart($id)
    {
        if (!session()->get('id_user')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'redirect' => base_url('login')
                ]);
            }
            return redirect()->to('/login');
        }

        $barangModel = new \App\Models\BarangModel();
        $barang = $barangModel->find($id);
    
        if (!$barang) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }
    
        if ($barang['stok'] <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Stok produk habis'
            ]);
        }
    
        $harga_final = ($barang['is_promo'] && $barang['harga_diskon']) 
            ? $barang['harga_diskon'] 
            : $barang['harga'];
    
        $cart = session()->get('cart') ?? [];
    
        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] + 1 > $barang['stok']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $barang['stok']
                ]);
            }
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                'id' => $barang['id'],
                'nama_barang' => $barang['nama_barang'],
                'harga' => $harga_final,
                'gambar' => $barang['gambar'],
                'qty' => 1
            ];
        }
    
        session()->set('cart', $cart);
    
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['qty'];
        }
    
        return $this->response->setJSON([
            'success' => true,
            'cart_count' => $cartCount,
            'message' => 'Berhasil ditambahkan'
        ]);
    }
    
    // ======================
    // UPDATE CART
    // ======================
    public function updateCart()
    {
        $id     = $this->request->getPost('id');
        $action = $this->request->getPost('action');
        $cart   = session()->get('cart') ?? [];
        $removed = false;

        if (isset($cart[$id])) {
            $barangModel = new \App\Models\BarangModel();
            $barang = $barangModel->find($id);

            if ($action == 'plus') {
                if ($cart[$id]['qty'] + 1 > $barang['stok']) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Stok tidak mencukupi. Maksimal: ' . $barang['stok']
                    ]);
                }
                $cart[$id]['qty'] += 1;
            } elseif ($action == 'minus') {
                if ($cart[$id]['qty'] > 1) {
                    $cart[$id]['qty'] -= 1;
                } else {
                    unset($cart[$id]);
                    $removed = true;
                }
            }

            session()->set('cart', $cart);

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['harga'] * $item['qty'];
            }

            return $this->response->setJSON([
                'success'    => true,
                'qty'        => isset($cart[$id]) ? $cart[$id]['qty'] : 0,
                'subtotal'   => isset($cart[$id]) ? ($cart[$id]['harga'] * $cart[$id]['qty']) : 0,
                'total'      => $total,
                'removed'    => $removed,
                'csrf_hash'  => csrf_hash(),
                'cart_count' => array_sum(array_column($cart, 'qty'))
            ]);
        }

        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Item tidak ditemukan di keranjang'
        ]);
    }
    
    // ======================
    // REMOVE ITEM
    // ======================
    public function remove()
    {
        $id = $this->request->getPost('id');
        
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $session->set('cart', $cart);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['harga'] * $item['qty']);
        }

        return $this->response->setJSON([
            'success'    => true,
            'total'      => $total,
            'cart_count' => count($cart),
            'csrf_hash'  => csrf_hash()
        ]);
    }
    
    // ======================
    // HALAMAN CHECKOUT
    // ======================
    public function checkout()
    {
        if (!$this->session->get('id_user')) {
            return redirect()->to('/login')->with('error', 'Login dulu');
        }

        $cart = $this->session->get('cart');

        if (!$cart) {
            return redirect()->to('/shop')->with('error', 'Keranjang kosong');
        }

        $data['cart'] = $cart;
        $data['isLoggedIn'] = true;

        return view('User/shop/checkout', $data);
    }

    // ======================
    // GENERATE INVOICE NUMBER
    // ======================
    private function generateInvoiceNumber()
    {
        $transaksiModel = new TransaksiModel();
        $date = date('Ymd');
        
        $lastInvoice = $transaksiModel
            ->like('invoice', $date, 'after')
            ->orderBy('id', 'DESC')
            ->first();
        
        if ($lastInvoice && !empty($lastInvoice['invoice'])) {
            $lastNumber = (int) substr($lastInvoice['invoice'], -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return 'INV-' . $date . '-' . $newNumber;
    }

    // ======================
    // PROSES CHECKOUT
    // ======================
    public function processCheckout()
    {
        $transaksiModel = new TransaksiModel();
        $detailModel = new DetailtransaksiModel();
        $barangModel = new BarangModel();
        $pelangganModel = new PelangganModel();

        if (!$this->session->get('id_user')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ]);
        }

        $cart = $this->session->get('cart');
        if (!$cart) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Keranjang kosong'
            ]);
        }

        $pelanggan = $pelangganModel->where('user_id', $this->session->get('id_user'))->first();
        
        if (!$pelanggan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan'
            ]);
        }

        $metode_pengiriman = $this->request->getPost('metode_pengiriman');
        $alamat = $this->request->getPost('alamat_tujuan');
        $metode_pembayaran = $this->request->getPost('metode_pembayaran');
        $ewallet_type = $this->request->getPost('ewallet_type');
        
        if (empty($metode_pengiriman)) {
            $metode_pengiriman = 'ambil';
        }

        if ($diskon = $this->request->getPost('diskon')) {
            $diskon = floatval($diskon);
        } else {
            $diskon = 0;
        }
        
        if (empty($metode_pembayaran)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Harap pilih metode pembayaran terlebih dahulu'
            ]);
        }
        
        $invoice = $this->generateInvoiceNumber();
        
        $ongkir = 0;
        $biaya_proteksi = 0;
        if ($metode_pengiriman === 'delivery') {
            $ongkir = 15000;
            $biaya_proteksi = 3000;
        }



        if ($metode_pengiriman === 'delivery' && empty($alamat)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Alamat wajib diisi untuk pengiriman'
            ]);
        }
        
        $bukti_pembayaran = null;
        $status_pembayaran = 'pending';

        if ($metode_pembayaran !== 'cod') {
            $file = $this->request->getFile('bukti_pembayaran');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $uploadPath = FCPATH . 'uploads/bukti_pembayaran';
                
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                if ($file->getSize() > 2 * 1024 * 1024) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Ukuran file terlalu besar. Maksimal 2MB.'
                    ]);
                }
                
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Tipe file tidak didukung. Gunakan JPG, PNG, atau PDF.'
                    ]);
                }
                
                $newName = 'pay_' . time() . '_' . rand(100, 999) . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);
                
                if ($file->hasMoved()) {
                    $bukti_pembayaran = $newName;
                    $status_pembayaran = 'menunggu_verifikasi';
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal mengupload bukti pembayaran'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Harap upload bukti pembayaran yang valid'
                ]);
            }
        }
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }
        
        $total_akhir = $subtotal + $ongkir + $biaya_proteksi;

        $dataTransaksi = [
            'pelanggan_id'      => $pelanggan['id'],
            'tanggal'           => date('Y-m-d H:i:s'),
            'total'             => $subtotal,
            'status'            => 'Pending',
            'metode_pengiriman' => $metode_pengiriman,
            'alamat_tujuan'     => $alamat,
            'metode_pembayaran' => $metode_pembayaran,
            'bukti_pembayaran'  => $bukti_pembayaran,
            'status_pembayaran' => $status_pembayaran,
            'ongkir'            => $ongkir,
            'biaya_proteksi'    => $biaya_proteksi,
            'total_akhir'       => $total_akhir,
            'ewallet_type'      => $ewallet_type,
            'invoice'           => $invoice
        ];

        try {
            if (!$transaksiModel->insert($dataTransaksi)) {
                $errors = $transaksiModel->errors();
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal membuat transaksi: ' . json_encode($errors)
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }

        $id_transaksi = $transaksiModel->insertID();

        foreach ($cart as $id => $item) {
            $barang = $barangModel->find($id);

            if ($barang['stok'] < $item['qty']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Maaf, stok ' . $item['nama_barang'] . ' habis'
                ]);
            }

            $detailModel->insert([
                'transaksi_id' => $id_transaksi,
                'barang_id'    => $id,
                'jumlah'       => $item['qty'],
                'harga'        => $item['harga'],
                'subtotal'     => ($item['harga'] * $item['qty']),
            ]);

            $barangModel->update($id, [
                'stok'    => $barang['stok'] - $item['qty'],
                'terjual' => ($barang['terjual'] ?? 0) + $item['qty']
            ]);
        }

        $this->session->remove('cart');

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Checkout berhasil! Invoice: ' . $invoice,
            'redirect' => base_url('shop/nota/' . $id_transaksi)
        ]);
    }

    // ======================
    // RIWAYAT
    // ======================
    public function riwayat()
    {
        if (!$this->session->get('id_user')) {
            return redirect()->to('/login')->with('error', 'Login dulu');
        }

        $pelangganModel = new PelangganModel();
        $pelanggan = $pelangganModel->where('user_id', $this->session->get('id_user'))->first();
        
        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan');
        }

        $transaksiModel = new TransaksiModel();
        $detailModel = new DetailtransaksiModel();

        $transaksi = $transaksiModel
            ->where('pelanggan_id', $pelanggan['id'])
            ->orderBy('id', 'DESC')
            ->findAll();
        
        foreach ($transaksi as &$t) {
            $t['details'] = $detailModel
                ->select('detail_transaksi.*, barang.nama_barang, barang.gambar')
                ->join('barang', 'barang.id = detail_transaksi.barang_id')
                ->where('transaksi_id', $t['id'])
                ->findAll();
        }
        
        $data['transaksi'] = $transaksi;
        $data['isLoggedIn'] = true;

        return view('User/shop/riwayat', $data);
    }

    // ======================
    // NOTA
    // ======================
    public function nota($id)
    {
        if (!$this->session->get('id_user')) {
            return redirect()->to('/login')->with('error', 'Login dulu');
        }

        $transaksiModel = new TransaksiModel();
        $detailModel    = new DetailtransaksiModel();

        $data['transaksi'] = $transaksiModel->find($id);
        
        if (!$data['transaksi']) {
            return redirect()->to('/shop/riwayat')->with('error', 'Transaksi tidak ditemukan');
        }
        
        $data['detail'] = $detailModel
            ->join('barang', 'barang.id = detail_transaksi.barang_id')
            ->where('transaksi_id', $id)
            ->findAll();
        
        $subtotal = 0;
        foreach ($data['detail'] as $item) {
            $subtotal += $item['jumlah'] * $item['harga'];
        }
        $data['subtotal'] = $subtotal;
        
        $data['ongkir'] = $data['transaksi']['ongkir'] ?? 0;
        $data['biaya_proteksi'] = $data['transaksi']['biaya_proteksi'] ?? 0;
        
        if (empty($data['transaksi']['total_akhir']) || $data['transaksi']['total_akhir'] == 0) {
            $data['total_akhir'] = $subtotal + $data['ongkir'] + $data['biaya_proteksi'];
        } else {
            $data['total_akhir'] = $data['transaksi']['total_akhir'];
        }
        
        $data['isLoggedIn'] = true;

        return view('User/shop/nota', $data);
    }
}