<?php

namespace App\Models;

use CodeIgniter\Model;

class VoteModel extends Model
{
    protected $table = 'votes';
    protected $allowedFields = ['candidate_id', 'token', 'voted_at'];
    protected $useTimestamps = false;
}
