<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table = 'tokens';
    protected $allowedFields = ['token', 'class', 'number', 'used', 'created_at', 'used_at'];
    protected $useTimestamps = false;
}
