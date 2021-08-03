<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'ProductID';
    protected $fillable = ['ProductCode','CustomerID','ContractNumber','ProductName','StartDate','EndDate','SendStartDate','SendEndDate','ManuDate','ExternalForm','pH','AuthorizedComName','AuthorizedComAddress','method423','method402','method403','method406','method404','method405','Active'];

    public function properties()
    {
        return $this->hasMany('App\properties','ProductID','ProductID');
    }
}
