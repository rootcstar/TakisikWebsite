
    <div class="tt-product-vertical-layout">
        <div class="tt-product-single-img">
            <div>
                <button class="tt-btn-zomm tt-top-right"><i class="icon-f-86"></i></button>
                @if(is_array($product_images) == true)
                    @foreach($product_images as $image)
                        <img class="zoom-product" src="{{ $image }}" data-zoom-image="{{ $image }}" alt="" >
                    @endforeach
                @else
                    <img class="zoom-product" src="{{ $product_images }}" data-zoom-image="{{ $product_images }}" alt="" >
                @endif

            </div>
        </div>
        <div class="tt-product-single-carousel-vertical">
            <ul id="smallGallery" class="tt-slick-button-vertical slick-animated-show-js">
                        @if(is_array($product_images) == true)
                            @foreach($product_images as $image=>$index)
                                @if($index == 0)
                                    <li>
                                        <a class="zoomGalleryActive" href="#" data-image="{{ $image }}" data-zoom-image="{{ $image }}">
                                            <img src="{{ $image }}" alt="" >
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="#" data-image="{{ $image }}" data-zoom-image="{{ $image }}">
                                            <img src="{{ $image }}" alt="" >
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li>
                                <a class="zoomGalleryActive" href="#" data-image="{{ $product_images }}" data-zoom-image="{{ $product_images }}">
                                    <img src="{{ $product_images }}" alt="" >
                                </a>
                            </li>
                        @endif
            </ul>
        </div>
    </div>
