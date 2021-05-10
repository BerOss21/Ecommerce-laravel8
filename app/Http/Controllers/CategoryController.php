<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request as Req;
use Inertia\Inertia;
use App\Models\Category;


class CategoryController extends Controller
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
        $categories=Category::all();
        return Inertia::render('Dashboard/Categories/Index', [
            'categories'=>$categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Dashboard/Categories/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $file_extention=$request->image->getClientOriginalExtension();
        $file_name=time().'.'.$file_extention;
        \Image::make($request->image)->resize(300,400)->save(public_path('storage/images/categories/'.$file_name));
        
        Category::create([
            "name"=>$request->name,
            "description"=>$request->description,
            "image"=>$file_name
        ]);
        $request->session()->flash('flash.banner', 'Category created successfully');
        return redirect(route('categories.index'));
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
        return Inertia::render("Dashboard/Categories/Edit",[
            "category"=>Category::find($id)
        ]);
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
        $category=Category::find($id);
        $data=[
            "name"=>$request->name,
            "description"=>$request->description
        ];
        if($request->image){
            Storage::disk("local")->delete("public/images/categories/".$category->image);
            $file_extention=$request->image->getClientOriginalExtension();
            $file_name=time().'.'.$file_extention;
            \Image::make($request->image)->resize(300,400)->save(public_path('storage/images/categories/'.$file_name));
            $data["image"]=$file_name;
        }
        $category->update($data);

        $request->session()->flash('flash.banner', 'Category updated successfully');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);

        Req::session()->flash('flash.banner', 'Category deleted successfully');
        
        return redirect(route('categories.index'));

    }
}
