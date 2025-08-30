<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['variant', 'featuredImage'])
            ->whereHas('variant')
            ->active()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function category(Category $category)
    {
        $products = Product::with(['variant', 'featuredImage'])
            ->whereHas('variant')
            ->where('category_id', $category->id)
            ->active()
            ->paginate(12);

        return view('products.category', compact('products', 'category'));
    }
}
