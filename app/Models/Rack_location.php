<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rack_location extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table="rack_location";   

}
