<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_user',
        'access_token',
        'm_name',
        'os',
        'ip',
        'typeAccount',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
