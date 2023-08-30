<div class="tt-mobile-product-slider arrow-location-center slick-animated-show-js ">
    @if(is_array($product_images) == true)
        @foreach($product_images as $image)
            <div><img src="{{ $image }}" alt=""></div>
        @endforeach
    @else
        <div><img src="{{ $product_images }}" alt="" ></div>
    @endif
</div>
