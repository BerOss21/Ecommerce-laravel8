<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;

class CheckCategory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $categories=Category::all();
        
        if(count($categories)==0){
            $request->session()->flash('flash.banner', 'You should add a category!');
            $request->session()->flash('flash.bannerStyle', 'danger');
            return Inertia::render('Dashboard/Categories/Index');
        }

        else{
            return $next($request);
        }
      
    }
}
