<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;


class HomeController extends Controller
{
    //
    public function index()
    {
    
        // session()->flash('flash.banner', 'Get a huge discount of up to 80% on all items!');
        // session()->flash('flash.bannerStyle', 'warning');
        // \App\Models\Currency::find(1)->update(['default', 1]);
        $products = Product::with(['featuredImage', 'variant', 'variant.options'])->paginate(15);
        // dd($products[0]->featuredImage->getResponsiveImageUrls());
        // dd(asset('images/placeholder-image.webp'));
        return view('home', compact('products'));    

    }


    
}
