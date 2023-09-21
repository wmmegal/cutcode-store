@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">

            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Home</a></li>
                <li><a href="{{ route('cart') }}" class="text-body hover:text-pink text-xs">Cart</a></li>
                <li><span class="text-body text-xs">Checkout</span></li>
            </ul>

            <section>
                <!-- Section heading -->
                <h1 class="mb-8 text-lg lg:text-[42px] font-black">Checkout</h1>

                <form action="{{ route('checkout.handle') }}" method="POST"
                      class="grid xl:grid-cols-3 items-start gap-6 2xl:gap-8 mt-12">
                    @csrf

                    <!-- Contact information -->
                    <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                        <h3 class="mb-6 text-md 2xl:text-lg font-bold">Contact information</h3>
                        <div class="space-y-3">

                            <x-forms.input
                                name="customer[name]"
                                type="text"
                                placeholder="Name"
                                value="{{ old('customer.name') }}"
                                :isError="$errors->has('customer.first_name')"
                            >
                            </x-forms.input>

                            @error('customer.name')
                            <x-forms.error>
                                {{ $message }}
                            </x-forms.error>
                            @enderror

                            <x-forms.input
                                name="customer[email]"
                                type="email"
                                placeholder="E-mail"
                                value="{{ old('customer.email') }}"
                                :isError="$errors->has('customer.email')"
                            >
                            </x-forms.input>

                            @error('customer.email')
                            <x-forms.error>
                                {{ $message }}
                            </x-forms.error>
                            @enderror

                            <x-forms.input
                                name="customer[phone]"
                                type="text"
                                placeholder="Phone"
                                value="{{ old('customer.phone') }}"
                                :isError="$errors->has('customer.phone')"
                            >
                            </x-forms.input>

                            @error('customer.phone')
                            <x-forms.error>
                                {{ $message }}
                            </x-forms.error>
                            @enderror
                        </div>
                    </div>

                    <!-- Shipping & Payment -->
                    <div class="space-y-6 2xl:space-y-8">

                        <!-- Shipping-->
                        <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                            <h3 class="mb-6 text-md 2xl:text-lg font-bold">Shipping methods</h3>
                            <div class="space-y-5">
                                @foreach($deliveries as $delivery)
                                    <div class="space-y-3">
                                        <div class="form-radio">
                                            <input type="radio"
                                                   name="delivery_type_id"
                                                   id="delivery-method-address-{{ $delivery->id }}"
                                                   value="{{ $delivery->id }}"
                                                @checked($loop->first || old('delivery_id') === $delivery->id)
                                            >
                                            <label for="delivery-method-address-{{ $delivery->id }}"
                                                   class="form-radio-label">
                                                {{ $delivery->title }}
                                            </label>
                                        </div>

                                        @if($delivery->with_address)
                                            <x-forms.input
                                                name="customer[city]"
                                                type="text"
                                                placeholder="City"
                                                value="{{ $customer->city ?? '' }}"
                                                :isError="$errors->has('customer.city')"
                                            >
                                            </x-forms.input>

                                            @error('customer.city')
                                            <x-forms.error>
                                                {{ $message }}
                                            </x-forms.error>
                                            @enderror

                                            <x-forms.input
                                                name="customer[address]"
                                                type="text"
                                                placeholder="Address"
                                                value="{{ $customer->address ?? '' }}"
                                                :isError="$errors->has('customer.address')"
                                            >
                                            </x-forms.input>

                                            @error('customer.address')
                                            <x-forms.error>
                                                {{ $message }}
                                            </x-forms.error>
                                            @enderror
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment-->
                        <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                            <h3 class="mb-6 text-md 2xl:text-lg font-bold">Payment methods</h3>
                            <div class="space-y-5">
                                @foreach($payments as $payment)
                                    <div class="form-radio">
                                        <input type="radio"
                                               name="payment_method_id"
                                               id="payment-method-{{ $payment->id }}"
                                               value="{{ $payment->id }}"
                                            @checked($loop->first || old('payment_method_id') === $payment->id)
                                        >

                                        <label for="payment-method-{{ $payment->id }}" class="form-radio-label">
                                            {{ $payment->title }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- Checkout -->
                    <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                        <h3 class="mb-6 text-md 2xl:text-lg font-bold">Order</h3>
                        <table class="w-full border-spacing-y-3 text-body text-xxs text-left"
                               style="border-collapse: separate">
                            <thead class="text-[12px] text-body uppercase">
                            <tr>
                                <th scope="col" class="pb-2 border-b border-body/60">Product</th>
                                <th scope="col" class="px-2 pb-2 border-b border-body/60">Qnt</th>
                                <th scope="col" class="px-2 pb-2 border-b border-body/60">Sum</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td scope="row" class="pb-3 border-b border-body/10">
                                        <h4 class="font-bold">
                                            <a href="{{ route('product', $item->product) }}"
                                               class="inline-block text-white hover:text-pink break-words pr-3">
                                                {{ $item->product->title }}
                                            </a>
                                        </h4>

                                        @if($item->optionValues->isNotEmpty())
                                            <ul>
                                                @foreach($item->optionValues as $value)
                                                    <li class="text-body">
                                                        {{ $value->option->title }}: {{ $value->title }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">{{ $item->amount }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="text-xs font-semibold text-right">Total: {{ cart()->total() }}</div>

                        <div class="mt-8 space-y-8">
                            <!-- Summary -->
                            <table class="w-full text-left">
                                <tbody>
                                <tr>
                                    <th scope="row" class="text-md 2xl:text-lg font-black">Total:</th>
                                    <td class="text-md 2xl:text-lg font-black">{{ cart()->total() }}</td>
                                </tr>
                                </tbody>
                            </table>

                            <!-- Process to checkout -->
                            <button type="submit" class="w-full btn btn-pink">Checkout</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </main>
@endsection
