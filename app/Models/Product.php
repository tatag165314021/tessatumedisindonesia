<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'price',
        'created_at',
        'updated_at',
    ];

    // protected $hidden = [
    //     'created_at',
    //     'updated_at',
    // ];
}
