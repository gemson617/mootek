<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank_master extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table="bank_master";   

}
