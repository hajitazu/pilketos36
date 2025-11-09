<?php

namespace App\Models;

use CodeIgniter\Model;

class CandidateModel extends Model
{
    protected $table = 'candidates';
    protected $allowedFields = ['name', 'description', 'photo', 'created_at'];
    protected $useTimestamps = false;
}
