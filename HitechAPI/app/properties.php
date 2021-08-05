<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class properties extends Model
{
    protected $table = 'properties';
    protected $primaryKey = 'PropertiesID';
    protected $fillable = ['ProductID','PropertiesName','Quantity'];

    public function products()
    {
        return $this->belongsTo('App\products','ProductID');
    }

}
