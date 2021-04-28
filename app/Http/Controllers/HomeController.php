<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Coupon;

class HomeController extends Controller
{
    public function index(){
        return Inertia::render("Home",[
            "products"=>Product::with("user","categories")->latest()->get()
        ]);
    }

    public function show($id)
    {
        return Inertia::render("Details",[
            "product"=>Product::whereId($id)->with("user","categories","galleries")->first()
        ]);
    }

    public function cart(){
        return Inertia::render("Cart");
    }

    public function getCoupon($code){
        $coupon=Coupon::whereRaw("BINARY `code`= ?",[$code])->first();

        if($coupon){
            return response()->json(["coupon"=>$coupon->percent_off]);
        }
        else{
            return response()->json(["message"=>"No found"]);
        }
    }
}