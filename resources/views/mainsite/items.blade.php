@extends('layouts.headerfooter')

@section('meta')

    @if(isset($pageSub))
    
    <title>{{ $pageSub->name }} | EC Distribution</title>
    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $pageSub->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="{{ $pageSub->name }} | EC Distribution">
    <meta itemprop="description" content="{{ $pageSub->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('items.cat.sub.index',[$item_cat,$item_sub_cat]) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="{{ $pageSub->name }} | EC Distribution" />
    <meta property="og:description" content="{{ $pageSub->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    @else

    <title>{{ $page->name }} | EC Distribution</title>
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $page->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="{{ $page->name }} | EC Distribution">
    <meta itemprop="description" content="{{ $page->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('items.cat.index',[$item_cat]) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="{{ $page->name }} | EC Distribution" />
    <meta property="og:description" content="{{ $page->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    @endif

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
                        @if(isset($pageSub))
                        <div><a href="{{ route('items.cat.index',[$item_cat]) }}">{{ $page->name }}</a></div>
                        <div><a href="{{ route('items.cat.sub.index',[$item_cat,$item_sub_cat]) }}" class="active">{{ $pageSub->name }}</a></div>
                        @else
                        <div><a href="{{ route('items.cat.index',[$item_cat]) }}" class="active">{{ $page->name }}</a></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                @if(count($items))
                    @foreach($items as $item)
                        @if($item->medias()->where('media_id', $item->item->index_img)->get()->isNotEmpty())
                            @if(isset($item->item->itemCategory->itemCategory))
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item->item->itemCategory->itemCategory->slug }}/{{ $item->item->itemCategory->slug }}/{{ $item->item->id }}/{{ $item->item->slug }}">
                                            <img class="img-responsive" 
                                            src="
                                            @foreach($item->medias()->where('media_id', $item->item->index_img)->get() as $img)
                                            {{ asset($img->url) }}
                                            @endforeach
                                            " alt="">
                                            <div class="item-name">{{ $item->brand->name . ' ' . $item->item->name }}</div>
                                            <div class="item-price">{{ number_format($item->item->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div> 
                                </div>
                            @else
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item->item->itemCategory->slug }}/{{ $item->item->id }}/{{ $item->item->slug }}">
                                            <img class="img-responsive" 
                                            src="
                                            @foreach($item->medias()->where('media_id', $item->item->index_img)->get() as $img)
                                            {{ asset($img->url) }}
                                            @endforeach
                                            " alt="">
                                            <div class="item-name">{{ $item->brand->name . ' ' . $item->item->name }}</div>
                                            <div class="item-price">{{ number_format($item->item->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div> 
                                </div>
                            @endif
                        @else
                            @if(isset($item->item->itemCategory->itemCategory))
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item->item->itemCategory->itemCategory->slug }}/{{ $item->item->itemCategory->slug }}/{{ $item->item->id }}/{{ $item->item->slug }}">
                                            @if($item->medias()->first() == null)
                                            <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                            @else
                                            <img class="img-responsive" 
                                            src="
                                            {{ asset($item->medias()->first()->url) }}
                                            " alt="">
                                            @endif
                                            <div class="item-name">{{ $item->brand->name . ' ' . $item->item->name }}</div>
                                            <div class="item-price">{{ number_format($item->item->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item->item->itemCategory->slug }}/{{ $item->item->id }}/{{ $item->item->slug }}">
                                            @if($item->medias()->first() == null)
                                            <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                            @else
                                            <img class="img-responsive" 
                                            src="
                                            {{ asset($item->medias()->first()->url) }}
                                            " alt="">
                                            @endif
                                            <div class="item-name">{{ $item->brand->name . ' ' . $item->item->name }}</div>
                                            <div class="item-price">{{ number_format($item->item->price,0, ",",".") }} VNĐ</div>
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
                            Chưa có sản phẩm trong danh mục này
                        </p>
                    </div>
                @endif
                       
            </div>
        </div>
    </section>
	
@endsection