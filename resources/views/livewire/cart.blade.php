<div>
    <!-- Breadcrumbs -->
    <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
        <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Home</a></li>
        <li><span class="text-body text-xs">Cart</span></li>
    </ul>

    <section>
        <!-- Section heading -->
        <h1 class="mb-8 text-lg lg:text-[42px] font-black">Cart</h1>

        @if($items->isEmpty())
            <div class="py-3 px-6 rounded-lg bg-pink text-white">Cart is empty</div>
        @else
            <!-- Message -->
            <div class="lg:hidden py-3 px-6 rounded-lg bg-pink text-white">You can swipe →</div>

            <!-- Adaptive table -->
            <div class="overflow-auto">
                <table class="min-w-full border-spacing-y-4 text-white text-sm text-left"
                       style="border-collapse: separate">
                    <thead class="text-xs uppercase">
                    <th scope="col" class="py-3 px-6">Product</th>
                    <th scope="col" class="py-3 px-6">Price</th>
                    <th scope="col" class="py-3 px-6">Quantity</th>
                    <th scope="col" class="py-3 px-6">Sum</th>
                    <th scope="col" class="py-3 px-6"></th>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <livewire:cart-item :$item :key="$item->id" />
                    @endforeach

                    </tbody>
                </table>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mt-8">
                <div class="text-[32px] font-black">Total: {{ $total }}</div>
                <div class="pb-3 lg:pb-0">
                    <form action="{{ route('cart.truncate') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-body hover:text-pink font-medium">Clear cart</button>
                    </form>

                </div>
                <div class="flex flex-col sm:flex-row lg:justify-end gap-4">
                    <a href="{{ route('catalog') }}" class="btn btn-pink">Catalog</a>
                    <a href="{{ route('checkout') }}" class="btn btn-purple">Checkout</a>
                </div>
            </div>
        @endif
    </section>
</div>

