<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productGroup_sub extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_group_id','product_type','product_name','model_no'
    ];
}
