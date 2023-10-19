<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manual_product extends Model
{
    use HasFactory;
    protected $table="manual_products";
    protected $guarded = ['id'];  
    protected $fillable=[
        'user_id','companyID','branchID','product','active','created_by',	
    ]; 


}
