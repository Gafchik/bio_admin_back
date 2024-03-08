<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Users extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'users';
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
}
