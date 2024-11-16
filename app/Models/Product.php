<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [

        'ProductName',
        'Description',
        'ItemType',
        'QtyRemaining',
        'ProductPrice',
        'PicUrl'
    ];

    public function reviews() {
        return $this->hasMany(Review::class, 'product_id')->orderBy('created_at', 'desc');
    }
}
