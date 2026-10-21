<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table            = 'detail_transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = false; // Tidak ada created_at/updated_at di tabel ini
    
    protected $allowedFields = [
        'transaksi_id', 
        'barang_id', 
        'harga',     
        'jumlah', 
        'subtotal'
    ];
}