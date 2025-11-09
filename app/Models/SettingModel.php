<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $allowedFields = ['k', 'v'];

    public function getAll()
    {
        $rows = $this->findAll();
        $out = [];
        foreach ($rows as $r) {
            $out[$r['k']] = $r['v'];
        }
        return $out;
    }

    public function set($key, $value)
    {
        $existing = $this->where('k', $key)->first();
        if ($existing) {
            $this->update($existing['id'], ['v' => $value]);
        } else {
            $this->insert(['k' => $key, 'v' => $value]);
        }
    }

    public function isOpen()
    {
        $row = $this->where('k', 'is_open')->first();
        if (!$row) return true;
        return (bool)$row['v'];
    }
}
