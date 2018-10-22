@extends('layouts.headerfooter')

@section('meta')
    <title>Tìm kiếm | EC Distribution</title>

     <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Tìm kiếm | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Tìm kiếm | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    {{ $settings->google_id }}
    {{ $settings->webmaster }}

@endsection

@section('content')
    <section class="section-items">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        <div><a href="" class="active">Tìm kiếm</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(!empty($itemSearch->items))
                    @foreach($itemSearch->items as $item)
                        @if($item['itemSub']->medias()->where('media_id', $item['itemSub']->item->index_img)->get()->isNotEmpty())
                            @if(isset($item['item']->itemCategory->itemCategory))
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item['item']->itemCategory->itemCategory->slug }}/{{ $item['item']->itemCategory->slug }}/{{ $item['item']->id }}/{{ $item['item']->slug }}">
                                            <img class="img-responsive" 
                                            src="
                                            @foreach($item['itemSub']->medias()->where('media_id', $iitem['item']->index_img)->get() as $img)
                                            {{ asset($img->url) }}
                                            @endforeach
                                            " alt="">
                                            <div class="item-name">{{ $item['itemSub']->brand->name . ' ' . $item['item']->name }}</div>
                                            <div class="item-price">{{ number_format($item['item']->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div> 
                                </div>
                            @else
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item['item']->itemCategory->slug }}/{{ $item['item']->id }}/{{ $item['item']->slug }}">
                                            <img class="img-responsive" 
                                            src="
                                            @foreach($item['itemSub']->medias()->where('media_id', $item['item']->index_img)->get() as $img)
                                            {{ asset($img->url) }}
                                            @endforeach
                                            " alt="">
                                            <div class="item-name">{{ $item['itemSub']->brand->name . ' ' . $item['item']->name }}</div>
                                            <div class="item-price">{{ number_format($item['item']->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div> 
                                </div>
                            @endif
                        @else
                            @if(isset($item['item']->itemCategory->itemCategory))
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item['item']->itemCategory->itemCategory->slug }}/{{ $item['item']->itemCategory->slug }}/{{ $item['item']->id }}/{{ $item['item']->slug }}">
                                            <img class="img-responsive" 
                                            src="
                                            {{ asset($item['itemSub']->medias()->first()->url) }}
                                            " alt="">
                                            <div class="item-name">{{ $item['itemSub']->brand->name . ' ' . $item['item']->name }}</div>
                                            <div class="item-price">{{ number_format($item['item']->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item['item']->itemCategory->slug }}/{{ $item['item']->id }}/{{ $item['item']->slug }}">
                                            <img class="img-responsive" 
                                            src="
                                            {{ asset($item['itemSub']->medias()->first()->url) }}
                                            " alt="">
                                            <div class="item-name">{{ $item['itemSub']->brand->name . ' ' . $item['item']->name }}</div>
                                            <div class="item-price">{{ number_format($item['item']->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @else
                    <div style="height:100%" class="col-lg-12 empty-item">
                        <p>
                            Không tìm được sản phẩm bạn tìm kiếm
                        </p>
                    </div>
                @endif
                       
            </div>
        </div>
    </section>
	
@endsection