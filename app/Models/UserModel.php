<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true; 
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'username',
        'email',     
        'password',
        'role'
        
    ];

    // Optional: Untuk validasi
    protected $validationRules = [
        'username' => 'required|min_length[3]|is_unique[users.username]',
        'email'    => 'permit_empty|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[4]',
    ];
}