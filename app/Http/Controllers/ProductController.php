<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request as Req;
use Inertia\Inertia;
use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){  
        $this->middleware('isAdmin');
        $this->middleware('checkCategory')->only('create','edit');
    }
    
    public function index()
    {
        $products=Product::with("categories","user","galleries")->latest()->get();
        return Inertia::render('Dashboard/Products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Dashboard/Products/Create',[
            "categories"=>\App\Models\Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {   
        $file_extention=$request->image->getClientOriginalExtension();
        $file_name=time().'.'.$file_extention;
        \Image::make($request->image)->resize(300,400)->save(public_path('storage/images/products/'.$file_name));
        $product=Product::create([
            "name"=>$request->name,
            "description"=>$request->description,
            "price"=>$request->price,
            "image"=>$file_name,
            "quantity"=>$request->quantity,
            "user_id"=>auth()->id()
        ]);
        $product->categories()->attach($request->categories);

        $images=[];

        // foreach($request->galleries as $key=>$img){
        //     $file_extention=$img->getClientOriginalExtension();
        //     $file_name=$key.time().'.'.$file_extention;
        //     \Image::make($img)->resize(300,400)->save(public_path('storage/images/galleries/'.$file_name));
        //     $images[$key]["image"]=$file_name;
        // }

        foreach($request->currentGallery as $key=>$img){
            $file_name =$key.time().'.' . explode('/', explode(':', substr($img, 0, strpos($img, ';')))[1])[1];
            \Image::make($img)->resize(300,400)->save(public_path('storage/images/galleries/'.$file_name));
            $images[$key]["image"]=$file_name;
        }
        $product->galleries()->createMany($images);

        $request->session()->flash('flash.banner', 'Product created successfully');

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render("Dashboard/Products/Edit",[
            "product"=>Product::whereId($id)->with("categories","galleries","user")->first(),
            "categories"=>\App\Models\Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        // dd($request->currentGallery);

        $product=Product::whereId($id)->with("galleries")->first();

        $data=[
            "name"=>$request->name,
            "description"=>$request->description,
            "price"=>$request->price,
            "quantity"=>$request->quantity
        ];

        
        if($request->image){
            $file_extention=$request->image->getClientOriginalExtension();
            $file_name=time().'.'.$file_extention;
            \Image::make($request->image)->resize(300,400)->save(public_path('storage/images/products/'.$file_name));
            $data["image"]=$file_name;
            Storage::disk('local')->delete('public/images/products/'.$product->image);
        }
        $product->update($data);
       
        $product->categories()->sync($request->categories);

        if($request->currentGallery){
            $gallery=[];
            foreach($product->galleries as $img){
                Storage::disk('local')->delete('public/images/galleries/'.$img->image);
            }

            foreach($request->currentGallery as $key=>$img){
                $file_name =$key.time().'.' . explode('/', explode(':', substr($img, 0, strpos($img, ';')))[1])[1];
                \Image::make($img)->resize(300,400)->save(public_path('storage/images/galleries/'.$file_name));
                $gallery[$key]["image"]=$file_name;
            }
     
            $product->galleries()->delete();
            $product->galleries()->createMany($gallery);
        }

        $request->session()->flash('flash.banner', 'Product updated successfully');

        return redirect(route("products.index"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);

        Req::session()->flash('flash.banner', 'Product deleted successfully');

        return redirect(route("products.index"));

    }
}
