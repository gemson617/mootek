<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_category extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 

    protected $table="customer_categories";
}
