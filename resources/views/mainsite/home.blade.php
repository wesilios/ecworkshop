@extends('layouts.headerfooter')

@section('meta')
    <title>EC Distribution</title>


    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Home | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Home | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />


@endsection

@section('slider')
	<div class="container container-carousel no-padding">
        <header id="main_slider" class="carousel slide">
            @if($main_slider->sliderDetails->isNotEmpty())
            <!-- Indicators -->
            <ol class="carousel-indicators">
            	@php
					$i = 0
	            @endphp
	            @foreach($main_slider->sliderDetails as $slider)
                	<li data-target="#main_slider" data-slide-to="{{ $i }}" class="{{ $i ==0 ? 'active' : '' }}"></li>
                @php
					$i++
	            @endphp
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
            	@php
					$i = 0
	            @endphp
	            @foreach($main_slider->sliderDetails as $slider)
                <div class="item {{ $i ==0 ? 'active' : '' }}">
                    <a href="{{ !empty($slider) ? $slider->link : '#'}}"><img class="img-responsive" src="{{ !empty($slider->media) ? asset($slider->media->url) : 'http://placehold.it/1900x1080' }}" alt="{{ !empty($slider->media) ? $slider->media->alt_text : ''}}"></a>
                </div>
                @php
					$i++
	            @endphp
                @endforeach
            </div>
                <a class="left carousel-control" href="#main_slider" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#main_slider" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                @else
                <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#main_slider" data-slide-to="1" class="active"></li>
                        <li data-target="#main_slider" data-slide-to="2" class=""></li>
                        <li data-target="#main_slider" data-slide-to="3" class=""></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <a href=""><img class="img-responsive" src="http://placehold.it/1900x862" alt=""></a>
                        </div>
                        <div class="item ">
                            <a href=""><img class="img-responsive" src="http://placehold.it/1900x862" alt=""></a>
                        </div>
                        <div class="item ">
                            <a href=""><img class="img-responsive" src="http://placehold.it/1900x862" alt=""></a>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#main_slider" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#main_slider" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
            @endif
        </header>
    </div>

@endsection

@section('content')
    @foreach ($item_parents as $key => $items)
        @if($items->isNotEmpty())
            <section class="item-div">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <div class="container">
                    <div class="col-lg-12 custom-no-padding">
                        <div class="items-title">
                            <div class="active">{{ $item_cats_parent[$key]->name }}</div>

                            <div class="item-hr"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 custom-no-padding">
                        <div class="items-carousel">
                            @foreach($items as $item)
                                @if($item->medias()->where('media_id', $item->index_img)->get()->isNotEmpty())
                                    <div>
                                        <div class="item">
                                            <a href="{{ $item->itemCategoryMain->slug }}/{{ $item->id }}/{{ $item->slug }}">
                                                <img class="img-responsive"
                                                     src="
                                             @foreach($item->medias()->where('media_id', $item->index_img)->get() as $img)
                                                     {{ asset($img->url) }}
                                                     @endforeach
                                                             " alt="">
                                                <div class="item-name">{{ $item->brand ? $item->brand->name : ''}} {{ $item->name }}</div>
                                                <div class="item-price">
                                                    @if($item->price_off > 0 || $item->price_off != null)
                                                        {{ number_format($item->price_off,0, ",",".") }} VNĐ
                                                        <span>{{ number_format($item->price,0, ",",".") }} VNĐ</span>

                                                    @else
                                                        {{ number_format($item->price,0, ",",".") }} VNĐ
                                                    @endif
                                                </div>

                                            </a>
                                            <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $item->id }}" value="{{ $item->id }}">
                                            <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $item->id }}" value="{{ $item->item_category_id }}">
                                            <div class="btn-cart" id="{{ $item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <div class="item">
                                            <a href="{{ $item->itemCategoryMain->slug }}/{{ $item->id }}/{{ $item->slug }}">
                                                @if($item->medias()->first() == null)
                                                    <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                                @else
                                                    <img class="img-responsive"
                                                         src="{{ asset($item->medias()->first()->url) }}" alt="">
                                                @endif
                                                <div class="item-name">{{ $item->brand ? $item->brand->name : ''}} {{ $item->name }}</div>
                                                <div class="item-price">
                                                    @if($item->price_off > 0 || $item->price_off != null)
                                                        {{ number_format($item->price_off,0, ",",".") }} VNĐ
                                                        <span>{{ number_format($item->price,0, ",",".") }} VNĐ</span>

                                                    @else
                                                        {{ number_format($item->price,0, ",",".") }} VNĐ
                                                    @endif
                                                </div>

                                            </a>
                                            <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $item->id }}" value="{{ $item->id }}">
                                            <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $item->id }}" value="{{ $item->item_category_id }}">
                                            <div class="btn-cart" id="{{ $item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    <div class="modal fade" role="dialog" id="item_check">
        <div class="modal-dialog modal_item_check">
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <img class="img-responsive img-item img-hover" src="" alt="" id="img-model">
                            </div>
                            <div class="col-lg-7">
                                <div class="col-lg-12 no-padding" id="ajax-location">

                                </div>
                                <div class="col-lg-8 no-padding">
                                    <div class="newform">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <input type='button' value='-' class='qtyminus btn btn-secondary' field='quantity' />
                                            </span>
                                                <input type='text' name='quantity' value='1' class='qty form-control' id="quantity"/>
                                            <span class="input-group-btn">
                                                <input type='button' value='+' class='qtyplus btn btn-secondary' field='quantity' />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="newform">
                                        <div class="input-group">
                                            <input type="hidden" id="item_id" value=""/>
                                            <input type="hidden" id="item_category_id" value=""/>
                                            <input type="button" name="add_cart_btn" value="+ Thêm vào giỏ hàng" class="btn-add-cart">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /modal-body -->
                </div><!-- /modal-content -->
        </div><!-- /modal-dialog -->
    </div><!-- /modal -->


@endsection

@section('section-blog')
	<section class="section-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-sec-title">Review & Blog</div>
                    <hr class="blog-hr">
                </div>
            </div>
            <div class="row">
                @foreach($articles as $article)
                <div class="col-md-5ths col-xs-12 col-sm-12 co-md-6">
                    <a href="/review-blog/{{ $article->slug }}">
                        @if(!empty($article->media->first()))
                            <img class="img-responsive" src="{{ asset($article->media->first()->url) }}" alt="">
                            @else
                            <img class="img-responsive" src="https://via.placeholder.com/204x92?text=No+image" alt="">
                        @endif
                    </a>
                    <h5 class="blog-title">{{ $article->title }}</h5>
                    <p>{{ str_limit($article->summary, 110) }}</p>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-seemore">
                        <a href="/review-blog">Xem Thêm</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
