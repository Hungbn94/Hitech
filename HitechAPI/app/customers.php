<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'CustomerID';
    protected $fillable = ['CustomerCode','CompanyName','ContactName','ContactNumber','ContactEmail','Active'];

    public function products()
    {
        return $this->hasMany('App\products','CustomerID','CustomerID');
    }
}
