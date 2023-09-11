@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <!-- Breadcrumbs -->
    <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
        <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Home</a></li>
        <li><a href="{{ route('account.orders') }}" class="text-body hover:text-pink text-xs">My orders</a></li>
        <li><span class="text-body text-xs">Order #{{ $order->id }}</span></li>
    </ul>

    <section>
        <!-- Section heading -->
        <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-6 mb-8">
            <h1 class="pb-4 md:pb-0 text-lg lg:text-[42px] font-black">Order # {{ $order->id }}</h1>
            <div class="px-6 py-3 rounded-lg {{ $order->status->bgColor() }}">{{ $order->status->humanValue() }}</div>
            <div class="px-6 py-3 rounded-lg bg-card">Date: {{ $order->created_at->format('d.m.Y') }}</div>
        </div>

        <!-- Message -->
        <div class="md:hidden py-3 px-6 rounded-lg bg-pink text-white">The table may be swiped to the right →</div>

        <!-- Adaptive table -->
        <div class="overflow-auto">
            <table class="min-w-full border-spacing-y-4 text-white text-sm text-left" style="border-collapse: separate">
                <thead class="text-xs uppercase">
                <th scope="col" class="py-3 px-6">Product</th>
                <th scope="col" class="py-3 px-6">Price</th>
                <th scope="col" class="py-3 px-6">Quantity</th>
                <th scope="col" class="py-3 px-6">Sum</th>
                </thead>
                <tbody>
                @foreach($orderItems as $orderItem)
                    <tr>
                        <td scope="row" class="py-4 px-6 rounded-l-2xl bg-card">
                            <div class="flex flex-col lg:flex-row min-w-[200px] gap-2 lg:gap-6">
                                <div
                                    class="shrink-0 overflow-hidden w-[64px] lg:w-[84px] h-[64px] lg:h-[84px] rounded-2xl">
                                    <img src="{{ $orderItem->product->thumbnail }}" class="object-cover w-full h-full"
                                         alt="{{ $orderItem->product->title }}">
                                </div>
                                <div class="py-3">
                                    <h4 class="text-xs sm:text-sm xl:text-md font-bold">
                                        <a href="{{ route('product', $orderItem->product) }}" class="inline-block text-white hover:text-pink">
                                            {{ $orderItem->product->title }}
                                        </a>
                                    </h4>
                                    @if($orderItem->optionValues->isNotEmpty())
                                        <ul class="space-y-1 mt-2 text-xs">
                                            @foreach($orderItem->optionValues as $value)
                                                <li class="text-body">{{ $value->option->title }}
                                                    : {{ $value->title }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 bg-card">
                            <div class="font-medium whitespace-nowrap">{{ $orderItem->price }}</div>
                        </td>
                        <td class="py-4 px-6 bg-card">{{ $orderItem->quantity }}</td>
                        <td class="py-4 px-6 bg-card rounded-r-2xl">
                            <div class="font-medium whitespace-nowrap">{{ $orderItem->amount }}</div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="flex flex-col-reverse md:flex-row md:items-center md:justify-between mt-8 gap-6">
            <div class="flex md:justify-end">
                <a href="{{ route('account.orders') }}" class="btn btn-pink">←&nbsp; Back</a>
            </div>
            <div class="text-[32px] font-black md:text-right">Total: {{ $order->amount }}</div>
        </div>

    </section>
@endsection
