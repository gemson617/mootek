<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadLogs extends Model
{
    use HasFactory;
    protected $table="jobs_log";
    protected $guarded=['id'];
}
