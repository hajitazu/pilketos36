<?php

namespace Config;

use CodeIgniteriltersilters;

class Filters extends \CodeIgniter\Config\Filters
{
    public $aliases = [
        'csrf'     => CSRF::class,
        'authadmin' => \App\Filters\AuthAdmin::class,
    ];

    public $globals = [
        'before' => [
            // 'csrf',
        ],
        'after'  => [
            //
        ],
    ];

    public $methods = [];
    public $filters = [];
}
