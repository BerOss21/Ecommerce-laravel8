<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){  
        $this->middleware('isAdmin')->only("index");
    }

    public function index()
    {
        $orders=Order::with("user")->latest()->get();
        return Inertia::render('Dashboard/Orders/Index',[
            "orders"=>$orders
        ]);
    }

    public function myOrders()
    {
        $orders=Order::with("user")->whereUserId(auth()->id())->latest()->get();
        return Inertia::render('MyOrders',[
            "orders"=>$orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=[
            "user_id"=>auth()->id(),
            "amount"=>$request->amount,
            "detail"=>serialize($request->detail)
        ];

        if($request->adresse){
            $data["adresse"]=$request->adresse;
        }
        if($request->phone){
            $data["phone"]=$request->phone;
        }

        // dd($request->detail);

        foreach($request->detail as $item){
            $product=Product::find($item['id']);
            $product->update([
                "quantity"=>$product->quantity - $item['qty']
            ]);
        }

        $order=Order::create($data);

        $request->session()->flash('flash.banner', 'Order sent successfully');

        return Inertia::render("Success");




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
