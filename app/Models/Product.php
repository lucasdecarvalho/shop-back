<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store',
        'name',
        'caption',
        'brand',
        'storage_initial',
        'storage_current',
        'available',
        'description',
        'details',
        'price',
        'discount',
        'photo1',
        'photo2',
        'photo3',
        'photo4',
        'photo5',
        'photo6',
        'video',
    ];
}
