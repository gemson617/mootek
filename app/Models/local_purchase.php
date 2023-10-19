<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class local_purchase extends Model
{
    use HasFactory;
    protected $table="local_purchase";
    protected $guarded = ['id','created_at', 'updated_at'];  

}
