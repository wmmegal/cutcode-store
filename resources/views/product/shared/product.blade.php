<!-- Product card -->
<div class="product-card flex flex-col rounded-3xl bg-card" style="position: relative">
    <a href="{{ route('product', $item->slug) }}" class="product-card-photo overflow-hidden h-[320px] rounded-3xl">
        <img src="{{ $item->thumbnail }}" class="object-cover w-full h-full" alt="{{ $item->title }}">
    </a>
    <div class="grow flex flex-col py-8 px-6">
        <h3 class="text-sm lg:text-md font-black">
            <a href="{{ route('product', $item->slug) }}"
               class="inline-block text-white hover:text-pink">{{ $item->title }}</a>
        </h3>
        <div class="mt-auto pt-6">
            <div class="mb-3 text-sm font-semibold">{{ $item->price }}</div>
        </div>
    </div>
</div><!-- /.product-card -->
