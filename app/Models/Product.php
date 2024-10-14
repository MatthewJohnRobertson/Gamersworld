<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'Product_id';
    public $incrementing = true;

    protected $fillable = [
        
        'ProductName',
        'Description',
        'ItemType',
        'QtyRemaining',
        'ProductPrice',
    ];
}