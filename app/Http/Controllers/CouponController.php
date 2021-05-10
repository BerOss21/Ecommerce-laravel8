<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use Inertia\Inertia;
use App\Models\Coupon;


class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){  
        $this->middleware('isAdmin');
    }
    
    public function index()
    {
        return Inertia::render("Dashboard/Coupons/Index",[
            "coupons"=>Coupon::orderBy("created_at","desc")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Dashboard/Coupons/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        Coupon::create($request->all());
        $request->session()->flash('flash.banner', 'Coupon created successfully');
        return redirect(route("coupons.index"));

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
        return Inertia::render("Dashboard/Coupons/Edit",[
            "coupon"=>Coupon::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, $id)
    {
        $coupon=Coupon::find($id);
        $coupon->update($request->all());

        $request->session()->flash('flash.banner', 'Coupon updated successfully');
        return redirect(route("coupons.index"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::destroy($id);
        $request->session()->flash('flash.banner', 'Coupon deleted successfully');
        return redirect(route("coupons.index"));
    }
}
