<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','product_id','product_varient_id','quantity','total','color','size'];
    protected $hidden = ['created_at','updated_at'];
    
    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function productVariant(){
        return $this->belongsTo(ProductVarient::class,'product_varient_id');
    }
}
