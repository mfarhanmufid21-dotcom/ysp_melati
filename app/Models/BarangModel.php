<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_barang','deskripsi', 'harga', 'stok', 'gambar','harga_diskon', 'is_promo'];

    public function getFinalPrice($harga, $harga_diskon, $is_promo)
    {
        if ($is_promo && $harga_diskon > 0) {
            return $harga_diskon;
        }
        return $harga;
    }
}