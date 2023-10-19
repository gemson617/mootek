<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_delivery extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 

    protected $table="customer_delivery";
}
