@extends('layouts.headerfooter')

@section('meta')
    <title>Kiểm tra đơn hàng | EC Distribution</title>
    
    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Kiểm tra đơn hàng | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Kiểm tra đơn hàng | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    {{ $settings->google_id }}
    {{ $settings->webmaster }}

@endsection

@section('content')
    <section class="section-account">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        @if(isset($order))
                        <div><a href="{{ route('orders.check') }}" >Kiểm tra đơn hàng</a></div>
                        <div><a href="" class="active">{{ $order->orderCode }}</a></div>
                        @else
                        <div><a href="{{ route('orders.check') }}" class="active">Kiểm tra đơn hàng</a></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    {!! Form::open(['method'=>'POST', 'action'=>'PagesController@searchOrder']) !!}
                        @if(isset($order))
                            <div class="form-group">
                                <label for="orderCode">Nhập mã đơn hàng</label>
                                <input type="text" name="orderCode" class="form-control" id="orderCode" value="{{ $orderCode }}">
                            </div>
                        @else
                            @if(isset($orderCode))
                            <div class="form-group">
                                <label for="orderCode">Nhập mã đơn hàng</label>
                                <input type="text" name="orderCode" class="form-control" id="orderCode" value="{{ $orderCode }}">
                            </div>
                            @else
                            <div class="form-group">
                                <label for="orderCode">Mã đơn hàng</label>
                                <input type="text" name="orderCode" class="form-control" id="orderCode">
                            </div>
                            @endif
                        @endif
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" id="btn-search" value="Tìm kiếm">
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    @if(session('status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="account-content">
                        <h3>Thông tin đơn hàng</h3>
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th style="text-align:center">Số lượng</th>
                                        <th style="text-align:right">Tổng tiền</th>
                                    </tr>
                                </thead>
                                @if(isset($order))
                                    @php
                                        $orderFee = 0
                                    @endphp
                                    <tbody>
                                        @foreach($order->orderDetail as $item)
                                            @if($item->feature === null || $item->feature === '')
                                                <tr>
                                                    <td>{{ $item->item_name }}</td>
                                                    <td style="text-align:center">{{ $item->quantity }}</td>
                                                    <td style="text-align:right">{{ number_format( $item->price , 0, ",",".") }} đ</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td><strong>{{ $item->item_name }}</strong>  <br>
                                                        <span style="font-size:12px">--- Điểm đặc trưng: {{ $item->feature }}</span>
                                                    </td>
                                                    <td style="text-align:center">{{ $item->quantity }}</td>
                                                    <td style="text-align:right">{{ number_format( $item->price , 0, ",",".") }} đ</td>
                                                </tr>
                                            @endif
                                            @php
                                                $orderFee += $item->price 
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Phí giao hàng</th>
                                            <th style="text-align:right">{{ number_format( $order->totalPrice - $orderFee , 0, ",",".") }} đ</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Tổng tiền</th>
                                            <th style="text-align:right">{{ number_format( $order->totalPrice , 0, ",",".") }} đ</th>
                                        </tr>
                                    </tfoot>
                                @else
                                    @if(isset($orderCode))
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="text-align:center">Không có đơn hàng khớp với mã đơn hàng <span style="color:#3097D1">#{{ $orderCode }}</span><br>
                                                    Vui lòng kiểm tra lại mã đơn hàng
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="text-align:center">Không có đơn hàng này</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                @endif
                            </table>
                        </div>
                        @if(isset($order))
                            <div class="account-title">Thông tin giao hàng</div>
                            <div class="table-responsive">
                                <table class="table table-order">
                                    <tbody>
                                        <tr>
                                            <td>Địa chỉ</td>
                                            <td>{{ $order->address .', '. $order->district .', '. $order->city }}</td>
                                        </tr>
                                        @if($order->customer_id > 0 && $order->extra_customer_id == 0)
                                        <tr>
                                            <td>Số điện thoại</td>
                                            <td>{{ $order->customer->phonenumber }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td>Số điện thoại</td>
                                            <td>{{ $order->extraCustomer->phonenumber }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Trạng thái đơn hàng</td>
                                            <td>{{ $order->status->name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>   
                </div>
            </div>
        </div>
    </section>

@endsection
