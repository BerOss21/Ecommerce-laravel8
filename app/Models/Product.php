<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function categories(){
        return $this->belongsToMany('App\Models\Category','product_category');
    }

    public function comments(){
        return $this->hasMany("App\Models\Comment");
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function galleries(){
        return $this->hasMany('App\Models\Gallery');
    }

    protected $appends=["image_path"];

    public function getImagePathAttribute($val){
        return  '/storage/images/products/'.$this->image;
    }

    protected static function booted()
    {
        static::deleted(function ($product) {
            foreach($product->galleries as $img){
                Storage::disk('local')->delete('public/images/galleries/'.$img->image);
            }
            Storage::disk('local')->delete('public/images/products/'.$product->image);
            $product->galleries()->delete();
            $product->categories()->detach();
        });
    } 
}
