<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;  // ✅ Opsional, untuk auto created_at/updated_at
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    
    protected $allowedFields    = ['nama', 'alamat', 'telepon', 'email', 'user_id'];
    // Hapus 'foto' jika tidak ada kolomnya di database
    
    // ============================================
    // GET PELANGGAN WITH USER DATA (JOIN)
    // ============================================
    public function getPelangganWithUser()
    {
        return $this->select('pelanggan.*, users.username, users.role')
                    ->join('users', 'users.id = pelanggan.user_id', 'left')
                    ->orderBy('pelanggan.id', 'DESC')
                    ->findAll();
    }
    
    // ============================================
    // GET PELANGGAN BY USER ID
    // ============================================
    public function getByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}