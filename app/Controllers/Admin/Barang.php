<?php

namespace App\Controllers\Admin;

use App\Models\BarangModel;
use App\Controllers\BaseController;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data['barang'] = $this->barangModel->findAll();
        return view('Admin/barang/index', $data);
    }

    // ============================================
    // GET PRODUCTS WITH AJAX (PAGINATION, SEARCH, SORT)
    // ============================================
    public function getProducts()
    {
        $request = service('request');
        
        $page = $request->getGet('page') ?? 1;
        $search = $request->getGet('search') ?? '';
        $kategori = $request->getGet('kategori') ?? '';
        $sort = $request->getGet('sort') ?? 'terbaru';
        $perPage = 12;
        
        $builder = $this->barangModel;
        
        // Search
        if (!empty($search)) {
            $builder = $builder->like('nama_barang', $search);
        }
        
        // Filter stok
        if ($kategori == 'tersedia') {
            $builder = $builder->where('stok >', 0);
        } elseif ($kategori == 'habis') {
            $builder = $builder->where('stok', 0);
        }
        
        // Sorting
        switch ($sort) {
            case 'harga_asc':
                $builder = $builder->orderBy('harga', 'ASC');
                break;
            case 'harga_desc':
                $builder = $builder->orderBy('harga', 'DESC');
                break;
            case 'stok_asc':
                $builder = $builder->orderBy('stok', 'ASC');
                break;
            case 'terbaru':
            default:
                $builder = $builder->orderBy('id', 'DESC');
                break;
        }
        
        // Pagination
        $total = $builder->countAllResults(false);
        $offset = ($page - 1) * $perPage;
        $products = $builder->findAll($perPage, $offset);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $products,
            'total' => $total,
            'pagination' => [
                'currentPage' => (int)$page,
                'totalPages' => ceil($total / $perPage),
                'perPage' => $perPage,
                'total' => $total
            ]
        ]);
    }
    
    // ============================================
    // GET SINGLE PRODUCT (AJAX)
    // ============================================
    public function getProduct($id)
    {
        $product = $this->barangModel->find($id);
        
        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $product
        ]);
    }
    
    public function create()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request'
        ]);
    }
    
    $validation = \Config\Services::validation();
    $validation->setRules([
        'nama_barang' => 'required|min_length[3]',
        'harga' => 'required|numeric|greater_than[0]',
        'stok' => 'required|numeric|greater_than_equal_to[0]'
    ]);
    
    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => $validation->getErrors()
        ]);
    }
    
    $file = $this->request->getFile('gambar');
    $namaGambar = 'default.png';
    
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $ext = $file->getExtension();
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $namaGambar = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $namaGambar);
        }
    }
    
    // ========== LOGIKA PROMO FLEKSIBEL ==========
    $is_promo = $this->request->getPost('is_promo') ?: 0;
    $harga_diskon = $this->request->getPost('harga_diskon');
    
    if ($is_promo == 1) {
        // Promo aktif - simpan harga diskon
        if (empty($harga_diskon)) {
            $harga_diskon = null;
        }
    } else {
        // Promo tidak aktif - kosongkan
        $is_promo = 0;
        $harga_diskon = null;
    }
    // ============================================
    
    $this->barangModel->save([
        'nama_barang'  => $this->request->getPost('nama_barang'),
        'deskripsi'    => $this->request->getPost('deskripsi'),
        'harga'        => $this->request->getPost('harga'),
        'stok'         => $this->request->getPost('stok'),
        'gambar'       => $namaGambar,
        'harga_diskon' => $harga_diskon,
        'is_promo'     => $is_promo
    ]);
    
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Produk berhasil ditambahkan'
    ]);
}

/// CREATE PRODUCT (AJAX)
    
public function update($id)
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request'
        ]);
    }
    
    $barang = $this->barangModel->find($id);
    if (!$barang) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Produk tidak ditemukan'
        ]);
    }
    
    $file = $this->request->getFile('gambar');
    $namaGambar = $barang['gambar'];
    
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $ext = $file->getExtension();
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            if ($barang['gambar'] != 'default.png' && file_exists(FCPATH . 'uploads/' . $barang['gambar'])) {
                @unlink(FCPATH . 'uploads/' . $barang['gambar']);
            }
            $namaGambar = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $namaGambar);
        }
    }
    
    // ========== LOGIKA PROMO FLEKSIBEL ==========
    $is_promo = $this->request->getPost('is_promo') ?: 0;
    $harga_diskon = $this->request->getPost('harga_diskon');
    
    if ($is_promo == 1) {
        
        if (empty($harga_diskon)) {
            $harga_diskon = null;
        }
    } else {
        // Promo tidak aktif - kosongkan harga_diskon
        $is_promo = 0;
        $harga_diskon = null;
    }
    // ============================================
    
    $this->barangModel->update($id, [
        'nama_barang'  => $this->request->getPost('nama_barang'),
        'deskripsi'    => $this->request->getPost('deskripsi'),
        'harga'        => $this->request->getPost('harga'),
        'stok'         => $this->request->getPost('stok'),
        'gambar'       => $namaGambar,
        'harga_diskon' => $harga_diskon,
        'is_promo'     => $is_promo
    ]);
    
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Produk berhasil diupdate'
    ]);
}
    
    // ============================================
    // DELETE PRODUCT (AJAX)
    // ============================================
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }
        
        $barang = $this->barangModel->find($id);
        
        if (!$barang) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }
        
        // Hapus file gambar
        if (!empty($barang['gambar']) && $barang['gambar'] != 'default.png') {
            $path = FCPATH . 'uploads/' . $barang['gambar'];
            if (is_file($path)) {
                @unlink($path);
            }
        }
        
        $this->barangModel->delete($id);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}