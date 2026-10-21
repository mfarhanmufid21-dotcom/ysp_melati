<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    
    // ========== SEMUA KOLOM HARUS ADA DI SINI ==========
    protected $allowedFields = [
        'invoice',
        'pelanggan_id',
        'tanggal',
        'total',
        'status',
        'metode_pengiriman',
        'alamat_tujuan',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status_pembayaran',
        'ongkir',
        'biaya_proteksi',
        'total_akhir',
        'ewallet_type'
    ];
    
    // Optional: Validation rules
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}