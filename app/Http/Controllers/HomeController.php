<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __invoke()
    {
        $categories = Category::onHome()->limit(6)->get();
        $products   = Product::onHome()->limit(6)->get();
        $brands     = Brand::onHome()->limit(6)->get();

        return view('home', compact([
                'categories',
                'products',
                'brands'
            ]
        ));
    }
}
