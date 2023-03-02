<?php

namespace App\Http\Controllers;

use App\Models\ViewModels\BrandViewModel;
use App\Models\ViewModels\CategoryViewModel;
use App\Models\ViewModels\ProductViewModel;

class HomeController extends Controller
{

    public function __invoke()
    {
        $categories = CategoryViewModel::make()->onHome();
        $products   = ProductViewModel::make()->onHome();
        $brands     = BrandViewModel::make()->onHome();

        return view('home', compact([
                'categories',
                'products',
                'brands'
            ]
        ));
    }
}
