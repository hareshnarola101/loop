<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['productname', 'price'];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

}