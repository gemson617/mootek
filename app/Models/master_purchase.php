<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_purchase extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at', 'updated_at'];  

    protected $table="master_purchase";

}
