<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referer extends Model
{
    use HasFactory;
    protected $table="referer_master";
    protected $guarded = ['id']; 
}
