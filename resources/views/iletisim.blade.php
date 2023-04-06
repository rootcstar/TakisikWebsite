@extends('layout.app')

@section('content')

    <div id="tt-pageContent">
        <div class="container-indent mt-0">
            <iframe id="my-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3008.1806490630825!2d28.824648115663244!3d41.06504372387814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa56512195c51%3A0xad1cec1bad495fd4!2zVEFLScWeSUs!5e0!3m2!1sde!2sus!4v1594110694583!5m2!1sde!2sus" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>
        <div class="container-indent">
            <div class="container container-fluid-custom-mobile-padding">
                <div class="tt-contact02-col-list">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 ml-sm-auto mr-sm-auto">
                            <div class="tt-contact-info">
                                <i class="tt-icon icon-f-93"></i>
                                <h6 class="tt-title">BIZI ARAYIN</h6>
                                <address>
                                    +777 2345 7885:<br>
                                    +777 2345 7886
                                </address>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="tt-contact-info">
                                <i class="tt-icon icon-f-24"></i>
                                <h6 class="tt-title">BIZI ZIYARET EDIN</h6>
                                <address>
                                    Mahmutbey, 6. Yol Sk. No:8, <br>
                                    Bağcılar/İstanbul, 34218<br>
                                    Türkiye
                                </address>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="tt-contact-info">
                                <i class="tt-icon icon-f-92"></i>
                                <h6 class="tt-title">ÇALIŞMA SAATERI</h6>
                                <address>
                                    PAZARTESI - CUMARTESI<br>
                                    8:00 - 19:00
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-indent">
            <div class="container container-fluid-custom-mobile-padding">
                <form id="contactform" class="contact-form form-default" method="post" novalidate="novalidate" action="#">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label></label>
                                <input type="text" name="name" class="form-control" id="inputName" placeholder="Isminiz (zorunlu)">
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Mail adresiniz (zorunlu)">
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" id="inputSubject" placeholder="Konu">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea  name="message" class="form-control" rows="7" placeholder="Mesajınız"  id="textareaMessage"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn">GONDER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
