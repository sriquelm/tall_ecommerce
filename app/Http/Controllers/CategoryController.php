<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index(Request $request)
    {
        return $this->shop($request);
    }

    /**
     * Display all products (unified shop/products view)
     */
    public function shop(Request $request)
    {
        $query = Product::with(['variant', 'featuredImage', 'category'])
            ->whereHas('variant')
            ->active();

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Handle category filtering
        $category = null;
        if ($request->has('category') && !empty($request->category)) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Get all categories for filters
        $categories = Category::with(['children'])
            ->onlyParents()
            ->active()
            ->get();

        $products = $query->paginate(12)->appends($request->query());

        return view('categories.index', compact('products', 'categories', 'category'));
    }

    /**
     * Display products by specific category
     */
    public function category(Category $category, Request $request)
    {
        $query = Product::with(['variant', 'featuredImage', 'category'])
            ->whereHas('variant')
            ->where('category_id', $category->id)
            ->active();

        // Handle search within category
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Get all categories for navigation
        $categories = Category::with(['children'])
            ->onlyParents()
            ->active()
            ->get();

        $products = $query->paginate(12)->appends($request->query());

        return view('categories.index', compact('products', 'categories', 'category'));
    }

    /**
     * Display all products (legacy products route)
     */
    public function products(Request $request)
    {
        return $this->shop($request);
    }
}
