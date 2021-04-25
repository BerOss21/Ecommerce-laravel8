<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    protected $appends=["image_path"];

    public function getImagePathAttribute($val){
        return  \Image::make(public_path('/storage/images/galleries/'.$this->image))->encode("data-url")->encoded;
    }
}
