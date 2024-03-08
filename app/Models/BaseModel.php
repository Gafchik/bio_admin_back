<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;
    use GetStaticTableName;

    public $timestamps = false; // no ORM custom timestamps fields in table
    public $guarded = ['disable_this_feature']; // disables mass assignment protection
}
