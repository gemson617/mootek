<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase_mode extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table="purchase_mode";   
}
