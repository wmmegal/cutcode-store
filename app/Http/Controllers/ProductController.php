<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->load(['optionValues.option']);

        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });

        $firstOptions = collect($options)->reduce(function ($acc, $option) {
            $acc[] = $option[0]->id;

            return $acc;
        });


        return view('product.show', [
            'product' => $product,
            'options' => $options,
            'firstOptions' => $firstOptions
        ]);
    }
}
