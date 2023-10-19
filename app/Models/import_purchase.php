<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class import_purchase extends Model
{
    use HasFactory;
    protected $table="import_purchase";
    protected $guarded = ['id','created_at', 'updated_at'];  

}
