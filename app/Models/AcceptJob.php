<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptJob extends Model
{
    use HasFactory;
    protected $table="accept_job";
    protected $fillable = [
        'lead_id','employee_id','status'
    ];   
}
