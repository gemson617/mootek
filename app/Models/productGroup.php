<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_group_name', 'price'
    ];
}
