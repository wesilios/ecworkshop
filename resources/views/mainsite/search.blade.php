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
                @if(!empty($itemSearch) && $itemSearch->isNotEmpty())
                    @foreach($itemSearch as $item)
                        @if($item->medias->isNotEmpty())
                            @if(!empty($item->index_img))
                                @php
                                    if($item->item_category_id != $item->item_category_parent_id){
                                        $slug = $item->itemCategoryParent->slug . '/' .$item->itemCategoryMain->slug . '/' .$item->id.'/'.$item->slug;
                                    } else {
                                        $slug = $item->itemCategoryParent->slug . '/' .$item->id.'/'.$item->slug;
                                    }
                                @endphp
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $slug }}">
                                            <img class="img-responsive"
                                                 src="{{ asset($item->medias()->first()->url) }}" alt="">
                                            <div class="item-name">{{ $item->brand->name . ' ' . $item->name }}</div>
                                            <div class="item-price">{{ number_format($item->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                @php
                                    if($item->item_category_id != $item->item_category_parent_id){
                                        $slug = $item->itemCategoryParent->slug . '/' .$item->itemCategoryMain->slug . '/' .$item->id.'/'.$item->slug;
                                    } else {
                                        $slug = $item->itemCategoryParent->slug . '/' .$item->id.'/'.$item->slug;
                                    }
                                @endphp
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $slug }}">
                                            <img class="img-responsive"
                                                 src="{{ asset($item->medias()->first()->url) }}" alt="">
                                            <div class="item-name">{{ $item->brand->name . ' ' . $item->name }}</div>
                                            <div class="item-price">{{ number_format($item->price,0, ",",".") }} VNĐ</div>
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