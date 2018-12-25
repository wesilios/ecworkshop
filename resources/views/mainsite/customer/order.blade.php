@extends('layouts.headerfooter')

@section('meta')
    <title>Lịch sử mua hàng chi tiết | EC Distribution</title>

    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Lịch sử mua hàng chi tiết | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('customer.order',[$order->orderCode]) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Lịch sử mua hàng chi tiết | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />



@endsection

@section('content')
    <section class="section-account">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        <div><a href="{{ route('customer.account') }}">{{ Auth::user()->name }}</a></div>
                        <div><a href="{{ route('customer.orders') }}">Lịch sử mua hàng</a></div>
                        <div><a href="{{ route('customer.order',[$order->orderCode]) }}" class="active">{{ $order->orderCode }}</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <ul class="acount-link-setting">
                        <li><a href="{{ route('customer.account') }}" >Thông tin tài khoản</a></li>
                        <li><a href="{{ route('customer.orders') }}" class="active">Lịch sử mua hàng</a></li>
                        <li>
                            <a href="{{ route('customer.logout') }}"
                             onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>

                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    @if(session('status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="account-content">
                        <h3>Chi tiết đơn hàng</h3>
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th style="text-align:center">Số lượng</th>
                                        <th style="text-align:right">Tổng tiền</th>
                                    </tr>
                                </thead>
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
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Tổng tiền</th>
                                        <th style="text-align:right">{{ number_format( $order->totalPrice , 0, ",",".") }} đ</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="account-title">Thông tin giao hàng</div>
                        <div class="table-responsive">
                            <table class="table table-order">
                                <tbody>
                                    <tr>
                                        <td>Địa chỉ</td>
                                        <td>{{ $order->address .', '. $order->district .', '. $order->city }}</td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại</td>
                                        <td>{{ $order->customer->phonenumber }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('#select_city').change(function(event) {
            var $this = $(this);
            var city_id = $this.val();
            var token = $("input[name='_token']").val();
            $.post("{{ route('districts.list') }}", {city_id:city_id, _token:token}, function(data){
                $('#select_district').html('');
                $('#select_district').html(data);
            });
            /*$.ajax({
                url: "{{ route('districts.list') }}",
                data: {city_id:city_id, _token:token},
                success: function(data) {
                    $('#select_district').html('');
                    $('#select_district').html(data.option);
                }
            });*/
        });
    </script>
@endsection