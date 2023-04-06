@extends('layout.app')

@section('content')


    <div id="tt-pageContent">
        <div class="container-indent nomargin">
            <div class="container-fluid">
                <div class="row">
                    <div class="slider-revolution revolution-default">
                        <div class="tp-banner-container">
                            <div class="tp-banner revolution">
                                <ul>
                                    <li data-thumb="{{ asset('assets/img/slider/slide-1.png') }}" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off"  data-title="Slide">
                                        <img src="{{ asset('assets/img/slider/slide-1.png') }}"  alt="slide1"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" >
                                     <!--   <div class="tp-caption tp-caption1 lft stb"
                                             data-x="center"
                                             data-y="center"
                                             data-hoffset="0"
                                             data-voffset="0"
                                             data-speed="600"
                                             data-start="900"
                                             data-easing="Power4.easeOut"
                                             data-endeasing="Power4.easeIn">
                                            <div class="tp-caption1-wd-1 tt-base-color">Oberlo</div>
                                            <div class="tp-caption1-wd-2 tt-white-color">Find Products for<br>Shop Store</div>
                                            <div class="tp-caption1-wd-3 tt-white-color">Oberlo allows you to easily import dropshipped products directly into your ecommerce store</div>
                                            <div class="tp-caption1-wd-4"><a href="listing-left-column.html" class="btn btn-xl" data-text="SHOP NOW!">SHOP NOW!</a></div>
                                        </div> -->
                                    </li>
                                    <li data-thumb="{{ asset('assets/img/slider/slide.png') }}" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off"  data-title="Slide">
                                        <img src="{{ asset('assets/img/slider/slide.png') }}"  alt="slide1"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" >
                                      <!--  <div class="tp-caption tp-caption1 lft stb"
                                             data-x="center"
                                             data-y="center"
                                             data-hoffset="0"
                                             data-voffset="0"
                                             data-speed="600"
                                             data-start="900"
                                             data-easing="Power4.easeOut"
                                             data-endeasing="Power4.easeIn">
                                            <div class="tp-caption1-wd-1 tt-white-color">Ready To</div>
                                            <div class="tp-caption1-wd-2 tt-white-color">Ready To<br>Demos</div>
                                            <div class="tp-caption1-wd-3 tt-white-color">Optimized for speed, website that sells</div>
                                            <div class="tp-caption1-wd-4"><a href="listing-left-column.html" class="btn btn-xl" data-text="SHOP NOW!">SHOP NOW!</a></div>
                                        </div> -->
                                    </li>
                                    <li data-thumb="{{ asset('assets/img/slider/jewelery1.jpg') }}" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off"  data-title="Slide">
                                        <img src="{{ asset('assets/img/slider/jewelery1.jpg') }}"  alt="slide1"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" >
                                        <!--  <div class="tp-caption tp-caption1 lft stb"
                                               data-x="center"
                                               data-y="center"
                                               data-hoffset="0"
                                               data-voffset="0"
                                               data-speed="600"
                                               data-start="900"
                                               data-easing="Power4.easeOut"
                                               data-endeasing="Power4.easeIn">
                                              <div class="tp-caption1-wd-1 tt-white-color">Ready To</div>
                                              <div class="tp-caption1-wd-2 tt-white-color">Ready To<br>Demos</div>
                                              <div class="tp-caption1-wd-3 tt-white-color">Optimized for speed, website that sells</div>
                                              <div class="tp-caption1-wd-4"><a href="listing-left-column.html" class="btn btn-xl" data-text="SHOP NOW!">SHOP NOW!</a></div>
                                          </div> -->
                                    </li>
                                    <li data-thumb="{{ asset('assets/img/slider/jewelery2.jpg') }}" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off"  data-title="Slide">
                                        <img src="{{ asset('assets/img/slider/jewelery2.jpg') }}"  alt="slide1"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" >
                                        <!--  <div class="tp-caption tp-caption1 lft stb"
                                               data-x="center"
                                               data-y="center"
                                               data-hoffset="0"
                                               data-voffset="0"
                                               data-speed="600"
                                               data-start="900"
                                               data-easing="Power4.easeOut"
                                               data-endeasing="Power4.easeIn">
                                              <div class="tp-caption1-wd-1 tt-white-color">Ready To</div>
                                              <div class="tp-caption1-wd-2 tt-white-color">Ready To<br>Demos</div>
                                              <div class="tp-caption1-wd-3 tt-white-color">Optimized for speed, website that sells</div>
                                              <div class="tp-caption1-wd-4"><a href="listing-left-column.html" class="btn btn-xl" data-text="SHOP NOW!">SHOP NOW!</a></div>
                                          </div> -->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-indent nomargin">
        <div class="container-fluid-custom">
            <div class="row">
                <div class="col-sm-6">
                    <a href="listing-left-column.html" class="tt-promo-box tt-one-child">
                        <img src="{{ asset('assets/img/loader.svg') }}" data-src="{{ asset('assets/img/template-images/index10-promo-img-01.jpg') }}" alt="">
                        <div class="tt-description">
                            <div class="tt-description-wrapper">
                                <div class="tt-background"></div>
                                <div class="tt-title-small">WOMEN</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a href="listing-left-column.html" class="tt-promo-box tt-one-child">
                        <img src="{{ asset('assets/img/loader.svg') }}" data-src="{{ asset('assets/img/template-images/index10-promo-img-02.jpg') }}" alt="">
                        <div class="tt-description">
                            <div class="tt-description-wrapper">
                                <div class="tt-background"></div>
                                <div class="tt-title-small">MENS</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a href="listing-left-column.html" class="tt-promo-box tt-one-child">
                        <img src="{{ asset('assets/img/loader.svg') }}" data-src="{{ asset('assets/img/template-images/index10-promo-img-03.jpg') }}" alt="">
                        <div class="tt-description">
                            <div class="tt-description-wrapper">
                                <div class="tt-background"></div>
                                <div class="tt-title-small">SHOES</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a href="listing-left-column.html" class="tt-promo-box tt-one-child">
                        <img src="{{ asset('assets/img/loader.svg') }}" data-src="{{ asset('assets/img/template-images/index10-promo-img-04.jpg') }}" alt="">
                        <div class="tt-description">
                            <div class="tt-description-wrapper">
                                <div class="tt-background"></div>
                                <div class="tt-title-small">ACCESSORIES</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
