<?php

namespace App\Models;

use CodeIgniter\Model;

class UlasanModel extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    // MATIKAN useTimestamps (HANYA SEKALI, jangan dua kali)
    protected $useTimestamps = false;
    
    protected $allowedFields = [
        'id_barang',
        'id_user',
        'pelanggan_id',
        'rating',
        'komentar',
        'balasan',
        'foto_ulasan',
        'status',
        'transaksi_id',
        'tanggal_ulasan'
    ];


    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'id_barang');
    }


    public function getRatingStats($id_barang)
{
    $query = $this->selectAvg('rating')
        ->select('COUNT(*) as total')
        ->where('id_barang', $id_barang)
        ->where('status', 'approved')
        ->first();
    
    return [
        'rataRating' => $query['rating'] ?? 0,
        'totalUlasan' => $query['total'] ?? 0
    ];
}
}