<!-- Product card -->
<div class="product-card flex flex-col md:flex-row rounded-3xl bg-card">
    <a href="{{ route('product', $item->slug ) }}"
       class="product-card-photo overflow-hidden shrink-0 md:w-[260px] xl:w-[320px] h-[320px] md:h-full rounded-3xl">
        <img src="{{ asset('storage/' . $item->thumbnail) }}" class="object-cover w-full h-full" alt="{{ $item->title }}">
    </a>
    <div class="grow flex flex-col py-8 px-6 md:px-8">
        <h3 class="text-sm lg:text-md font-black">
            <a href="{{ route('product', $item->slug ) }}" class="inline-block text-white hover:text-pink">{{ $item->title }}</a>
        </h3>
        @if($item->json_properties)
            <ul class="space-y-1 mt-4 text-xxs">
                @foreach($item->json_properties as $property => $value)
                    <li class="flex justify-between text-body"><strong>{{ $property }}:</strong> {{ $value }}</li>
                @endforeach
            </ul>
        @endif
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6 mt-6">
            <div class="flex items-baseline gap-4">
                <div class="text-pink text-md xl:text-lg font-black">{{ $item->price }}</div>
            </div>
        </div>
    </div>
</div><!-- /.product-card -->
