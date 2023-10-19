<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rent_day_month_week extends Model
{
    use HasFactory;
    protected $table="rent_day_month_week";
    protected $guarded=['id'];
}
