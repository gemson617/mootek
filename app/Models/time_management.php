<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class time_management extends Model
{
    use HasFactory;
    protected $table="time_managements";
    protected $guarded = ['id'];   

}
