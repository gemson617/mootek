<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_sub_category extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 

    protected $table="customer_sub_categories";
}
