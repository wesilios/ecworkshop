@extends('layouts.headerfooter')

@section('meta')

    @if(isset($slug_child))

    <title>{{ $item->name }} | EC Distribution</title>
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $page->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="{{ $item->name }} | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('item.sub.index',[$item_cat,$item_sub_cat,$item->id,$item->name]) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="{{ $item->name }} | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    @else

    <title>{{ $item->name }} | EC Distribution</title>
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="{{ $item->name }} | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('item.index',[$item_cat,$item->id,$item->name]) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="{{ $item->name }} | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    @endif


@endsection

@section('content')
    <section class="section-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        @if(isset($pageSub))
                        <div><a href="{{ route('items.cat.index',[$item_cat]) }}">{{ str_replace('/',' -', $item->itemCategoryParent->name) }}</a></div>
                        <div><a href="{{ route('items.cat.sub.index',[$item_cat, $item_sub_cat]) }}">{{ str_replace('/',' -', $item->itemCategoryMain->name) }}</a></div>
                        <div><a href="" class="active">{{ $item->name }}</a></div>
                        @else
                        <div><a href="{{ route('items.cat.index',[$item_cat]) }}" >{{ str_replace('/',' -', $item->itemCategoryParent ) ? str_replace('/',' -', $item->itemCategoryParent->name ): '' }}</a></div>
                        <div><a href="" class="active">{{ $item->name }}</a></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                 @if($item->medias()->where('media_id', $item->index_img)->get()->isNotEmpty())
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div id="item_carousel" class="carousel slide">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="img-responsive" src="{{ asset($item->medias()->where('media_id', $item->index_img)->first()->url) }} " alt="">
                                </div>
                                @foreach($item->medias()->where('media_id', '!=' ,$item->index_img)->get() as $img)
                                <div class="item">
                                    <img class="img-responsive" src="{{ asset($img->url) }} " alt="">
                                </div>
                                @endforeach
                            </div>
                            <!-- Indicators -->
                            <ol class='img_indicators'>
                                <li data-target="#item_carousel" data-slide-to="0" class="active">
                                    <img
                                        src="
                                        {{ asset($item->medias()->where('media_id', $item->index_img)->first()->url) }}
                                        "
                                    alt="">
                                </li>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($item->medias()->where('media_id', '!=' ,$item->index_img)->get() as $img)
                                    <li data-target="#item_carousel" data-slide-to="{{ $i }}" class="">
                                        <img src="{{ asset($img->url) }}" alt="">
                                    </li>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </ol>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8">
                        <div class="item-info">
                            <div class="item-name">{{ ($item->brand ? $item->brand->name : '') . ' ' . $item->name }}</div>
                            <p>{{ $item->summary }}</p>
                            <hr>
                            @if($item->price_off > 0)
                            <div class="item-price">Giá: <strike>{{ number_format($item->price,0, ",",".") }} VND </strike>
                                <span class="saleoff">{{ number_format($item->price_off,0, ",",".") }} VND</span>
                            </div>
                            @else
                            <div class="item-price">
                                Giá: {{ number_format($item->price,0, ",",".") }} VND
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <tbody>
                                        <tr>
                                            <td>Tình trạng:</td>
                                            <td>{{ $item->itemStatus ? $item->itemStatus->name : ''  }}</td>
                                        </tr>
                                        @if(isset($item->size))
                                        <tr>
                                            <td>Phân loại hàng:</td>
                                            <td><span class="size">{{ $item->size->name }}</span></td>
                                        </tr>
                                        @endif
                                        @if($item->colors != null && $item->colors->isNotEmpty())
                                        <tr>
                                            <td>Lựa chọn màu:</td>
                                            <td>
                                                <select name="color" id="color">
                                                @foreach($item->colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Số lượng:</td>
                                            <td>
                                                <div class="newform">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <input type='button' value='-' class='qtyminus btn btn-secondary' field='quantity' />
                                                        </span>
                                                            <input type="hidden" name="id_than_may" value="" >
                                                            <input type='text' name='quantity' value='1' class='qty form-control' id="quantity"/>
                                                        <span class="input-group-btn">
                                                            <input type='button' value='+' class='qtyplus btn btn-secondary' field='quantity' />
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="item_id" value="{{ $item->id }}"/>
                                @if($item->itemCategoryParent == null)
                                    <input type="hidden" id="item_category_id" value="{{ $item->item_category_id }}"/>
                                @else
                                    <input type="hidden" id="item_category_id" value="{{ $item->itemCategoryParent->id }}"/>
                                @endif
                                <input type="button" name="add_cart_btn" value="+ Thêm vào giỏ hàng" class="btn btn-primary btn-add-cart">
                                <input type="button" name="add_buy_cart_btn" value="+ Mua ngay" class="btn btn-primary btn-add-buy-cart">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div id="item_carousel" class="carousel slide">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                @if($item->medias()->first() == null)
                                <div class="item active">
                                    <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                </div>
                                @else
                                @php
                                    $i = 0
                                @endphp
                                @foreach($item->medias()->get() as $img)
                                <div class="item {{ $i == 0 ? 'active' : '' }}">
                                    <img class="img-responsive" src="{{ asset($img->url) }} " alt="">
                                </div>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                                @endif
                            </div>
                            <!-- Indicators -->
                            <ol class='img_indicators'>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach($item->medias()->get() as $img)
                                    <li data-target="#item_carousel" data-slide-to="{{ $i }}" class="{{ $i ==0 ? 'active' : '' }}">
                                        <img src="{{ asset($img->url) }}" alt="">
                                    </li>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </ol>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8">
                        <div class="item-info">
                            <div class="item-name">{{ ($item->brand ? $item->brand->name : '') . ' ' . $item->name }}</div>
                            <p>{{ $item->summary }}</p>
                            <hr>
                            @if($item->price_off > 0)
                            <div class="item-price">Giá: <strike>{{ number_format($item->price,0, ",",".") }} VND </strike>
                                <span class="saleoff">{{ number_format($item->price_off,0, ",",".") }} VND</span>
                            </div>
                            @else
                            <div class="item-price">
                                Giá: {{ number_format($item->price,0, ",",".") }} VND
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <tbody>
                                        <tr>
                                            <td>Tình trạng:</td>
                                            <td>{{ $item->itemStatus ? $item->itemStatus->name : '' }}</td>
                                        </tr>
                                        @if(isset($item->size))
                                        <tr>
                                            <td>Phân loại hàng:</td>
                                            <td><span class="size">{{ $item->size->name }}</span></td>
                                        </tr>
                                        @endif
                                        @if($item->colors != null && $item->colors->isNotEmpty())
                                        <tr>
                                            <td>Lựa chọn màu:</td>
                                            <td>
                                                <select name="color" id="color">
                                                @foreach($item->colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Số lượng:</td>
                                            <td>
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
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="item_id" value="{{ $item->id }}"/>
                                @if($item->itemCategoryParent == null)
                                    <input type="hidden" id="item_category_id" value="{{ $item->item_category_id }}"/>
                                @else
                                    <input type="hidden" id="item_category_id" value="{{ $item->itemCategoryParent->id }}"/>
                                @endif
                                <input type="button" name="add_cart_btn" value="+ Thêm vào giỏ hàng" class="btn btn-primary btn-add-cart">
                                <input type="button" name="add_buy_cart_btn" value="+ Mua ngay" class="btn btn-primary btn-add-buy-cart">
                            </div>
                            <div class="btn-group">

                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#item_info" aria-controls="item_info" role="tab" data-toggle="tab">Thông tin sản phẩm</a></li>
                            <li role="presentation"><a href="#item_comment" aria-controls="item_comment" role="tab" data-toggle="tab">Bình luận / đánh giá</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="item_info">{!! $item->description !!}</div>
                            <div role="tabpanel" class="tab-pane" id="item_comment">...Chưa có bình luận nào.</div>
                        </div>
                    </div>
              </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="random_items_title">
                        <div>Sản phẩm liên quan</div>
                        <div class="item-hr"></div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    @if(!empty($random_items))
                        <div class="items-carousel">
                        @foreach($random_items as $random_item)
                            @if($random_item->medias()->where('media_id', $random_item->index_img)->get()->isNotEmpty())
                            <div>
                                <div class="item">
                                    <a href="../../{{ $random_item->itemCategoryMain->slug }}/{{ $random_item->id }}/{{ $random_item->slug }}">
                                        <img class="img-responsive"
                                        src="
                                        @foreach($random_item->medias()->where('media_id', $random_item->index_img)->get() as $img)
                                        {{ asset($img->url) }}
                                        @endforeach
                                        " alt="">
                                        <div class="item-name">{{ $random_item->brand ? $random_item->brand->name : '' . ' ' . $random_item->name }}</div>
                                        <div class="item-price">{{ number_format($random_item->price,0, ",",".") }} VNĐ</div>

                                    </a>
                                    <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $random_item->id }}" value="{{ $random_item->id }}">
                                    <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $random_item->id }}" value="{{ $random_item->item_category_id }}">
                                    <div class="btn-cart" id="{{ $random_item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                                </div>
                            </div>
                            @else
                            <div>
                                <div class="item">
                                    <a href="../../{{ $random_item->itemCategoryMain->slug }}/{{ $random_item->id }}/{{ $random_item->slug }}">
                                        @if($random_item->medias()->first() == null)
                                        <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                        @else
                                        <img class="img-responsive"
                                        src="
                                        {{ asset($random_item->medias()->first()->url) }}
                                        " alt="">
                                        @endif
                                        <div class="item-name">{{ $random_item->brand ? $random_item->brand->name : '' . ' ' . $random_item->name }}</div>
                                        <div class="item-price">{{ number_format($random_item->price,0, ",",".") }} VNĐ</div>

                                    </a>
                                    <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $random_item->id }}" value="{{ $random_item->id }}">
                                    <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $random_item->id }}" value="{{ $random_item->item_category_id }}">
                                    <div class="btn-cart" id="{{ $random_item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-center">Không có sản phẩm liên quan!</p>
                    @endif
                </div>
                </div>
            </div>
        </div>
    </section>
@endsection