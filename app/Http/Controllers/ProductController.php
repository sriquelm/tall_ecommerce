<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['variant', 'featuredImage'])
            ->whereHas('variant')
            ->active();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $products = $query->paginate(12)->appends($request->query());

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
