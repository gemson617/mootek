<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rent_agreement extends Model
{
    use HasFactory;
    protected $table="rent_agreement";
    protected $guarded=['id'];
}
