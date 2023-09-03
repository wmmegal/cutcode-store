@extends('layouts.app')

@section('content')
    @if(!$products->isEmpty())
        <section class="mt-16 lg:mt-16">
            <!-- Section heading -->
            <h2 class="text-lg lg:text-[42px] font-black">Каталог товаров</h2>

            <!-- Products list -->
            <div
                class="products grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-x-8 gap-y-8 lg:gap-y-10 2xl:gap-y-12 mt-8">
                @each('product.shared.product', $products, 'item')
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('catalog') }}" class="btn btn-purple">Все товары &nbsp;→</a>
            </div>
        </section>
    @endif
@endsection
