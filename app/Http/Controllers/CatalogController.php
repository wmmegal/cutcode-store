<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $categories = Category::has('products')
                              ->get();

        $products = Product::select(['id', 'title', 'thumbnail', 'price', 'slug', 'json_properties'])
                           ->search()
                           ->category($category)
                           ->filtered()
                           ->sorted()
                           ->paginate(8);

        return view('catalog.index', compact([
            'products',
            'categories',
            'category'
        ]));
    }
}
