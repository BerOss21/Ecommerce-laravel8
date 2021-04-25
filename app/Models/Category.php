<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function products(){
        return $this->belongsToMany('App\Models\Product','product_category');
    }

    protected $appends = ['image_path'];

    public function getImagePathAttribute($val){
        return  '/storage/images/categories/'.$this->image;
    }

    protected static function booted()
    {
        static::deleted(function ($category) {
            Storage::disk('local')->delete('public/images/categories/'.$category->image);
            // foreach($category->products as $product){
            //     foreach($product->galleries as $img){
            //         Storage::disk('local')->delete('public/images/galleries/'.$img->image);
            //     }
            //     Storage::disk('local')->delete('public/images/products/'.$product->image);
            //     $product->galleries()->delete();
            // } 
            // $category->products()->delete();
        });

        
    }
}
