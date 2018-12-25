@extends('layouts.headerfooter')

@section('meta')
    <title>Lịch sử mua hàng | EC Distribution</title>

    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Lịch sử mua hàng | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('customer.orders') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Lịch sử mua hàng | EC Distribution" />
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
                        <div><a href="">{{ Auth::user()->name }}</a></div>
                        <div><a href="{{ route('customer.account') }}" class="active">Lịch sử mua hàng</a></div>
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
                        <h3>Lịch sử mua hàng</h3>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <input type="hidden" value="{{ Auth::guard('customer')->user()->id }}" name="customer_id">
                        <div class="input-group col-lg-6" style="margin-top:25px">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Mã đơn hàng:#</button>
                            </span>
                            <input type="text" class="form-control" placeholder="100324567879" name="search_query">
                        </div><!-- /input-group -->
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th style="text-align:center">Số lượng</th>
                                        <th style="text-align:center">Tổng tiền</th>
                                        <th style="text-align:right">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($orders->isNotEmpty())
                                        @foreach($orders as $order)
                                        <tr>
                                            <td><a href="{{ route('customer.order',[$order->orderCode]) }}">{{ $order->orderCode }}</a></td>
                                            <td style="text-align:center">{{ $order->totalQty }}</td>
                                            <td style="text-align:center">{{ number_format( $order->totalPrice , 0, ",",".") }} đ</td>
                                            <td style="text-align:right">{{ $order->status->name }}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">Bạn chưa có đơn hàng nào</td>
                                        </tr>
                                    @endif
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

        $("input[name='search_query']").on('keyup', function() {
            $value = $(this).val();
            var token = $("input[name='_token']").val();
            var customer_id = $("input[name='customer_id']").val();
            $.ajax({
                url: "{{ route('customer.orders.search') }}",
                method: 'GET',
                dataType:'json',
                data: {search_query:$value,customer_id:customer_id,_token:token},
                success: function(data) {
                    $('tbody').html('');
                    $('tbody').html(data.option);
                    //alert(data.option);
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