@extends('layouts.headerfooter')

@section('meta')
    <title>Giỏ hàng | EC Distribution</title>
    

    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Giỏ hàng | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('cart.index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Giỏ hàng | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    {{ $settings->google_id }}
    {{ $settings->webmaster }}

@endsection

@section('content')
    <section class="section-cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        <div><a href="{{route('cart.index')}}" class="active">Giỏ hàng</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(session('status'))
                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-shopping-cart"></i> {{ session('status') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-shopping-cart"></i> {{ session('error') }}
                    </div>
                @endif
                <div class="col-lg-12">
                    <i class="fa fa-3x fa-shopping-cart"></i> <span class="cart-summary">Giỏ hàng của bạn có {{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }} sản phẩm</span> 
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        {!! Form::open(['method'=>'POST', 'action'=>'AjaxController@cartUpdate'])!!}
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th style="width:10%"></th>
                                    <th style="width:45%">Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th style="width:12%">Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(Session::get('cart') == null)
                                    <tr>
                                        <td colspan="5">Chưa có sản phẩm trong giỏ hàng</td>
                                    </tr>
                                @else
                                @php $i = 1 @endphp
                                @foreach(Session::get('cart')->items as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td><img class="img-responsive img-item img-hover" 
                                        src="{{ asset($item['item']->medias()->first()->url) }}" 
                                        alt=""/>
                                    </td>
                                    <td>
                                        {{ $item['item']->brand['name'] .' '. $item['item']->item['name'] }}<br>
                                        @if(isset($item['item']->size))
                                        Phân loại: {{ $item['item']->size['name'] }}
                                        @endif
                                        @if(isset($item['colors'][0]))
                                        @else
                                        Màu sắc: 
                                            @foreach($item['colors'] as $color)
                                                {{ $color['quantity'] .'-'. $color['color']->name }}
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                    @if(isset($item['colors'][0]))
                                        <div class="newform col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <input type='button' value='-' class='qtyminus btn btn-secondary' field='quantity{{ $item['item']->item['id'] }}' />
                                                </span>
                                                    <input type='text' name='quantity{{ $item['item']->item['id'] }}' value='{{ $item['quantity'] }}' class='qty form-control' id="quantity{{ $item['item']->item['id'] }}"/>
                                                <span class="input-group-btn">
                                                    <input type='button' value='+' class='qtyplus btn btn-secondary' field='quantity{{ $item['item']->item['id'] }}' />
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                    @foreach($item['colors'] as $color)
                                        <div class="detailform form-horizontal">
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">{{ $color['color']->name }}</label>
                                                <div class="col-sm-4">
                                                    <input type='number' name='quantity{{ $item['item']->item['id'].'_'.$color['color']->id }}' value='{{ $color['quantity'] }}' class='form-control' id="quantity{{ $item['item']->item['id'].'_'.$color['color']->id }}" min="1" step="1"/>
                                                </div>
                                            </div>   
                                        </div> 
                                    @endforeach
                                    @endif
                                    <td>{{ number_format( $item['price'] , 0, ",",".") }} đ</td>
                                    <td><a href="{{ route('cart.delete', [$item['item']->item['id']]) }}" class="cart-delete"><i class="fa fa-2x fa-times-circle-o"></i></a></td>
                                </tr>
                                @php $i++ @endphp
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align:right">
                                        Tổng tiền: <span class="totalPrice">{{ Session::has('cart') ? number_format( Session::get('cart')->totalPrice , 0, ",",".") : '' }}đ</span>
                                    </td>
                                    <td><button type="submit" class="btn-update"><i class="fa fa-refresh" aria-hidden="true"></i></button></td>
                                </tr>
                            </tfoot>
                        </table>
                        {!! Form::close()!!}
                    </div>
                </div>
            </div>
            <div class="row cart-link">
                <div class="col-lg-8">
                    <a href="{{ route('index') }}"><< Tiếp tục mua hàng</a>
                </div>
                <div class="col-lg-4">
                    <a href="{{ route('cart.check') }}" class="cart-link-proceed" {{ Session::has('cart') ? Session::get('cart')->totalQty : 'disable' }}>Tiến hành thanh toán</a>
                </div>
            </div>
        </div>
    </section>
@endsection