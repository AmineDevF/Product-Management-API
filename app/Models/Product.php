<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Choose a hosting environment for the API
    protected $fillable = ["name", "detail","prix","quantite","image"];

   

    public function users(){
        return $this->belongsTo(User::class);
    }
}
