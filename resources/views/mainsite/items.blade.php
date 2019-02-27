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

@endsection

@section('content')
    <section class="section-items">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        @if(isset($pageSub))
                        <div><a href="{{ route('items.cat.index',[$item_cat]) }}">{{ str_replace('/',' -', $page->name) }}</a></div>
                        <div><a href="{{ route('items.cat.sub.index',[$item_cat,$item_sub_cat]) }}" class="active">{{ str_replace('/',' -',$pageSub->name) }}</a></div>
                        @else
                        <div><a href="{{ route('items.cat.index',[$item_cat]) }}" class="active">{{ str_replace('/',' -', $page->name) }}</a></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                @if(count($items))
                    @foreach($items as $item)
                        @if($item->medias()->where('media_id', $item->index_img)->get()->isNotEmpty())
                            @if($item->item_category_id != $item->item_category_parent_id)
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item->itemCategoryMain->itemCategory->slug }}/{{ $item->itemCategoryMain->slug }}/{{ $item->id }}/{{ $item->slug }}">
                                            <div style="width:100%; height:283px;">
                                                <img class="img-responsive" style="vertical-align: middle;margin: auto" src="{{ asset($item->medias()->where('media_id', $item->index_img)->first()->url) }}" alt="">
                                            </div>
                                            <div class="item-name">{{ $item->brand->name . ' ' . $item->name }}</div>
                                            <div class="item-price">{{ number_format($item->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item->itemCategoryMain->slug }}/{{ $item->id }}/{{ $item->slug }}">
                                            <div style="width:100%; height:283px;">
                                                <img class="img-responsive" style="vertical-align: middle;margin: auto" src="{{ asset($item->medias()->where('media_id', $item->index_img)->first()->url) }}" alt="">
                                            </div>
                                            <div class="item-name">{{ $item->brand->name . ' ' . $item->name }}</div>
                                            <div class="item-price">{{ number_format($item->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if($item->item_category_id != $item->item_category_parent_id)
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item->itemCategoryMain->itemCategory->slug }}/{{ $item->itemCategoryMain->slug }}/{{ $item->id }}/{{ $item->slug }}">
                                            <div style="width:100%; height:283px;">
                                                <img class="img-responsive" style="vertical-align: middle;margin: auto" src="{{ asset($item->medias()->first()->url) }}" alt="">
                                            </div>
                                            <div class="item-name">{{ !empty($item->brand->name) ? $item->brand->name : ''}} {{ ' ' . $item->name }}</div>
                                            <div class="item-price">{{ number_format($item->price,0, ",",".") }} VNĐ</div>
                                            <div class="btn-cart">Thêm vào giỏ hàng</div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="item">
                                        <a href="/{{ $item->itemCategoryMain->slug }}/{{ $item->id }}/{{ $item->slug }}">
                                            <div style="width:100%; height:283px;">
                                                <img class="img-responsive" style="vertical-align: middle;margin: auto" src="{{ asset($item->medias()->first()->url) }}" alt="">
                                            </div>
                                            <div class="item-name">{{ !empty($item->brand->name) ? $item->brand->name : ''}} {{ ' ' . $item->name }}</div>
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
                            Chưa có sản phẩm trong danh mục này
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </section>

@endsection