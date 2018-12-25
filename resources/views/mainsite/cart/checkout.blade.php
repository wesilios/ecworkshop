@extends('layouts.headerfooter')

@section('meta')
    <title>Thanh toán | EC Distribution</title>


    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Thanh toán | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('cart.check') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Thanh toán | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />


@endsection

@section('content')
    <section class="section-cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        <div><a href="{{route('cart.index')}}" class="active">Thanh toán</a></div>
                    </div>
                </div>
            </div>
            {!! Form::open(['method'=>'PUT','action'=>'CartController@pushCart']) !!}
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 info-order">
                    @if(Auth::guard('customer')->check())
                    <h4>Thông tin giao hàng</h4>
                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Họ tên người nhận" aria-describedby="sizing-addon2" name="name" value="{{ Auth::guard('customer')->user()->name }}" }} readonly>
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-phone"></i></span>
                            <input type="text" class="form-control" placeholder="Điện thoại người nhận" aria-describedby="sizing-addon2" name="phonenumber" value="{{ Auth::guard('customer')->user()->phonenumber }}" readonly>
                        </div>
                        @if ($errors->has('phonenumber'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phonenumber') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" placeholder="Email người nhận" aria-describedby="sizing-addon2" name="email" value="{{ Auth::guard('customer')->user()->email }}" readonly>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-6" style="margin-bottom:20px">
                        @if(Auth::guard('customer')->user()->customerInfo->city_id == 0)
                            {!! Form::select(
                                'city_id',
                                $cities,
                                null,
                                ['class'=>'form-control','placeholder'=>'-- Tỉnh/Thành phố --','id'=>'select_city']
                                );
                            !!}
                        @else
                            {!! Form::select(
                                'city_id',
                                $cities,
                                Auth::guard('customer')->user()->customerInfo->city_id,
                                ['class'=>'form-control','id'=>'select_city']
                                );
                            !!}
                        @endif
                        @if ($errors->has('city_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-6" style="margin-bottom:20px">
                        @if(Auth::guard('customer')->user()->customerInfo->district_id == 0)
                            <select name="district_id" id="select_district" class="form-control">
                                <option value="">-- Quận/Huyện --</option>
                            </select>
                        @else
                            {!! Form::select(
                                'district_id',
                                $districts,
                                Auth::guard('customer')->user()->customerInfo->district_id,
                                ['class'=>'form-control','id'=>'select_district']
                                );
                            !!}
                        @endif
                        @if ($errors->has('district_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('district_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12">
                        @if(Auth::guard('customer')->user()->customerInfo == null)
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-home"></i></span>
                                <input type="text" class="form-control" placeholder="Địa chỉ người nhận" aria-describedby="sizing-addon2" name="address" value="">
                            </div>
                        @else
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-home"></i></span>
                                <input type="text" class="form-control" placeholder="Địa chỉ người nhận" aria-describedby="sizing-addon2" name="address" value="{{ Auth::guard('customer')->user()->customerInfo->address }}">
                            </div>
                        @endif

                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-list"></i></span>
                            <textarea type="text" class="form-control" placeholder="Ghi chú thêm của khách hàng" aria-describedby="sizing-addon2" name="note"></textarea>
                        </div>
                    </div>
                    @else
                    <div class="account">Bạn đã có tài khoản? <a href="{{ route('customer.login') }}">Đăng nhập</a></div>
                    <h4>Thông tin giao hàng</h4>
                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Họ tên người nhận" aria-describedby="sizing-addon2" name="name">
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-phone"></i></span>
                            <input type="text" class="form-control" placeholder="Điện thoại người nhận" aria-describedby="sizing-addon2" name="phonenumber">
                        </div>
                        @if ($errors->has('phonenumber'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phonenumber') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" placeholder="Email người nhận" aria-describedby="sizing-addon2" name="email">
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-6" style="margin-bottom:20px">
                        {!! Form::select(
                            'city_id',
                            $cities,
                            null,
                            ['class'=>'form-control','placeholder'=>'-- Tỉnh/Thành phố --','id'=>'select_city']
                            );
                        !!}
                        @if ($errors->has('city_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-6" style="margin-bottom:20px">
                        <select name="district_id" id="select_district" class="form-control">
                            <option value="">-- Quận/Huyện --</option>
                        </select>
                        @if ($errors->has('district_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('district_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-home"></i></span>
                            <input type="text" class="form-control" placeholder="Địa chỉ người nhận" aria-describedby="sizing-addon2" name="address">
                        </div>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-list"></i></span>
                            <textarea type="text" class="form-control" placeholder="Ghi chú thêm của khách hàng" aria-describedby="sizing-addon2" name="note"></textarea>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-sm-6 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1 order-info">
                    <div class="row">
                        <div class="col-lg-12">
                            <i class="fa fa-3x fa-shopping-cart"></i> <span class="cart-order">Đơn hàng của bạn</span>
                            <div class="table-responsive">
                                <table class="table table-order">
                                    <thead>
                                        <tr>
                                            <th style="width:60%">Sản phẩm</th>
                                            <th style="text-align:center">Số lượng</th>
                                            <th style="text-align:right">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Session::get('cart')->items as $item)
                                            <tr>
                                                <td>{{ $item['item']->brand['name'] .' '.  $item['item']->item['name']}}</td>
                                                <td style="text-align:center">{{ $item['quantity'] }}</td>
                                                <td style="text-align:right">{{ number_format( $item['price'] , 0, ",",".") }}đ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-xs-6 col-sm-6 col-md-4 col-md-offset-4 custom-no-padding">Tổng cộng:</div>
                            <div class="col-xs-6 col-sm-6 col-md-4 text-right custom-no-padding">{{ number_format( Session::get('cart')->totalPrice , 0, ",",".") }} VND</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-xs-6 col-sm-6 col-md-4 col-md-offset-4 custom-no-padding">Phí vận chuyển:</div>
                            <div class="col-xs-6 col-sm-6 col-md-4 text-right custom-no-padding fee">
                                @if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->customerInfo->city_id != 0)
                                    {{ number_format( Auth::guard('customer')->user()->customerInfo->city->fee , 0, ",",".") }} VND
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-xs-6 col-sm-6 col-md-4 col-md-offset-4 order-totalPrice custom-no-padding">Tổng thanh toán</div>
                            <div class="col-xs-6 col-sm-6 col-md-4 text-right custom-no-padding order-totalPrice-price">
                                @if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->customerInfo->city_id != 0)
                                    {{ number_format( Auth::guard('customer')->user()->customerInfo->city->fee + Session::get('cart')->totalPrice , 0, ",",".") }} VND
                                @else
                                    {{ number_format( Session::get('cart')->totalPrice , 0, ",",".")}} VND
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 cart-link-2">
                            <div class="col-xs-6 custom-no-padding">
                                <a href="{{ route('cart.index') }}"><< Quay lại giỏ hàng</a>
                            </div>
                            <div class="col-xs-6 custom-no-padding">
                                <button type="submit" class="">Hoàn tất đơn hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#select_city').change(function(event) {
            var $this = $(this);
            var city_id = $this.val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('order.price') }}",
                method:'POST',
                dataType:'json',
                data: {city_id:city_id, _token:token},
                success: function(data) {
                    $('#select_district').html('');
                    $('#select_district').html(data.option);
                    var fee = data.fee == 0 ? 'Theo giá cước bưu điện' : data.fee + ' VND';
                    $('.fee').html(fee);
                    $('.order-totalPrice-price').html(data.totalPrice+' VND');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.status);
                   console.log(xhr.responseText);
                   console.log(thrownError);
               }
            });
        });
    </script>
@endsection