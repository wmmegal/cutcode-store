@extends('layouts.app')

@section('title', $product->title)

@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">
            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Главная</a></li>
                <li><a href="{{ route('catalog') }}" class="text-body hover:text-pink text-xs">Каталог</a></li>
                <li><span class="text-body text-xs">{{ $product->title }}</span></li>
            </ul>

            <!-- Main product -->
            <section class="flex flex-col lg:flex-row gap-10 xl:gap-14 2xl:gap-20 mt-12">

                <div class="basis-full lg:basis-2/5 xl:basis-2/4">
                    <div class="overflow-hidden h-auto max-h-[620px] lg:h-[480px] xl:h-[620px] rounded-3xl">
                        <img src="{{ $product->thumbnail }}" class="object-cover w-full h-full"
                             alt="{{ $product->title }}">
                    </div>
                </div>

                <div class="basis-full lg:basis-3/5 xl:basis-2/4">
                    <div class="grow flex flex-col lg:py-8">
                        <h1 class="text-lg md:text-xl xl:text-[42px] font-black">
                            {{ $product->title }}
                        </h1>

                        <div class="flex items-baseline gap-4 mt-4">
                            <div class="text-pink text-lg md:text-xl font-black">{{ $product->price }}</div>
                        </div>

                        <ul class="sm:max-w-[360px] space-y-2 mt-8">
                            @foreach($product->properties as $property)
                                <li class="flex justify-between text-body">
                                    <strong>{{ $property->title }}:</strong>
                                    {{ $property->pivot->value }}
                                </li>
                            @endforeach
                        </ul>

                        <!-- Add to cart -->
                        <div class="space-y-8 mt-8" x-data="addToCart"
                             x-on:checked-product-in-cart.window="inCart = $event.detail[0];"
                             x-init="productId = {{ $product->id }}; inCart = {{ cart()->inCart($product->id, $firstOptions) }}">
                            @csrf
                            <div class="grid grid-cols-2 md:grid-cols-3 2xl:grid-cols-4 gap-4">
                                @foreach($options as $optionLabel => $values)
                                    <div class="flex flex-col gap-2">
                                        <label for="filter-item-{{ $loop->index }}"
                                               class="cursor-pointer text-body text-xxs font-medium">
                                            {{ $optionLabel }}
                                        </label>

                                        <select name="options[]" id="filter-item-{{ $loop->index }}"
                                                @change="checkInCart(); getOptions();"
                                                class="form-select w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition">
                                            @foreach($values as $value)
                                                <option value="{{ $value->id }}" class="text-dark">
                                                    {{ $value->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex flex-wrap items-center gap-3 xs:gap-4">
                                <div class="flex items-stretch h-[54px] lg:h-[72px] gap-2">
                                    <button type="button" @click="count--; count = count < 1 ? 1: count"
                                            class="w-12 h-full rounded-lg border border-body/10 hover:bg-card/20 active:bg-card/50 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs text-center font-bold shadow-transparent outline-0 transition">
                                        -
                                    </button>
                                    <input type="number"
                                           name="quantity"
                                           class="h-full px-2 md:px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs text-center font-bold shadow-transparent outline-0 transition"
                                           min="1" max="999" value="1" placeholder="К-во" x-model="count">
                                    <button type="button"
                                            @click="count++;"
                                            class="w-12 h-full rounded-lg border border-body/10 hover:bg-card/20 active:bg-card/50 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs text-center font-bold shadow-transparent outline-0 transition">
                                        +
                                    </button>
                                </div>

                                <button type="submit" class="!px-6 xs:!px-8 btn btn-pink" x-show="!inCart"
                                        @click="
                                            getOptions();
                                            $dispatch('addToCart', { productId: {{ $product->id }}, quantity: count, options});
                                            inCart = true
                                        ">Add to cart
                                </button>
                                <a href="{{ route('cart') }}" class="!px-6 xs:!px-8 btn btn-pink" x-show="inCart">
                                    View cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <!-- Description -->
            <section class="mt-12 xl:mt-16 pt-8 lg:pt-12 border-t border-white/10">
                <h2 class="mb-12 text-lg lg:text-[42px] font-black">Описание</h2>
                <article class="text-xs md:text-sm">
                    {!! $product->text !!}
                </article>
            </section>
        </div>
    </main>
@endsection
