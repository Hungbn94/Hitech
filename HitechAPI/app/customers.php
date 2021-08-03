<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    protected $fillable = ['CustomerCode','CompanyName','ContactName','ContactNumber','ContactEmail','Active'];
}
