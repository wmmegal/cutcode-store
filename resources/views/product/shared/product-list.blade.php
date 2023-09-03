<!-- Product card -->
<div class="product-card flex flex-col md:flex-row rounded-3xl bg-card">
    <a href="{{ route('product', $item->slug ) }}"
       class="product-card-photo overflow-hidden shrink-0 md:w-[260px] xl:w-[320px] h-[320px] md:h-full rounded-3xl">
        <img src="{{ $item->thumbnail }}" class="object-cover w-full h-full" alt="{{ $item->title }}">
    </a>
    <div class="grow flex flex-col py-8 px-6 md:px-8">
        <h3 class="text-sm lg:text-md font-black"><a href="{{ route('product', $item->slug ) }}"
                                                     class="inline-block text-white hover:text-pink">{{ $item->title }}</a>
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
                <!-- <div class="text-body text-sm xl:text-md font-semibold line-through">59 300 ₽</div> -->
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <a href="#" class="w-[56px] !h-[56px] !px-0 btn btn-pink">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 52 52">
                        <path
                            d="M39.385 38.663a6.047 6.047 0 1 0 6.041 6.053v-.006a6.053 6.053 0 0 0-6.041-6.047ZM50.11 9.706a2.329 2.329 0 0 0-.439-.042H12.852l-.583-3.902a5.248 5.248 0 0 0-5.196-4.519h-4.74a2.332 2.332 0 1 0 0 4.665h4.746a.583.583 0 0 1 .583.513l3.592 24.62a6.45 6.45 0 0 0 6.35 5.447H41.87a6.414 6.414 0 0 0 6.292-5.126l3.796-18.923a2.333 2.333 0 0 0-1.847-2.733ZM24.571 44.45a6.047 6.047 0 0 0-6.062-5.782 6.047 6.047 0 0 0 .14 12.089h.146a6.047 6.047 0 0 0 5.776-6.306Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div><!-- /.product-card -->
