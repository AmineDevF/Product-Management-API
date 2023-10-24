<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['id','content','key','userID'];  
    public $incrementing = false;

    public function items () {
        return $this->hasMany(CartItem::class , 'Cart_id');
        // 'App\CartItem'
    }
}

