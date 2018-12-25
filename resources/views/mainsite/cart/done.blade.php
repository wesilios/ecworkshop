@extends('layouts.headerfooter')

@section('meta')
    <title>Hoàn tất đơn hàng | EC Distribution</title>


    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Hoàn tất đơn hàng | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('cart.done', [$orderCode, $fee]) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Hoàn tất đơn hàng | EC Distribution" />
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
                        <div><a href="" class="active">Hoàn tất đơn hàng</a></div>
                    </div>
                </div>
            </div>
            {!! Form::open(['method'=>'PUT','action'=>'CartController@pushCart']) !!}
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 info-order">
                    <div>Bạn đã đặt hàng thành công</div>
                    <h4>Thông tin giao hàng</h4>
                    <p>Cám ơn bạn đã mua hàng tại EC Distribution. Chúng tôi sẽ liên hệ xác nhận đơn hàng của bạn trong vòng 02 giờ làm việc!</p>
                    <div style="margin: 0 0 11px;">Mã đơn hàng: <span style="color:#3097D1">#{{ $orderCode }}</span></div>
                    <p>Vui lòng liên hệ với chúng tôi qua Hotline: {{ $settings->phone }} nếu có thắc mắc hoặc thay đổi nội dung đơn hàng</p>
                    <div style="margin-top: 20px;">
                        @if($order->customer_id == 0 && $order->extra_customer_id != 0)
                            <strong>Thông tin nhận hàng:</strong>
                            <div>{{ $order->extraCustomer->name }}</div>
                            <div>{{ $order->extraCustomer->address }}</div>
                            <div>{{ $order->extraCustomer->email }}</div>
                            <div>{{ $order->extraCustomer->phonenumber }}</div>
                        @else
                            <strong>Thông tin nhận hàng:</strong>
                            <div>{{ $order->customer->name }}</div>
                            <div>{{ $order->address .', '. $order->district .', '. $order->city}}</div>
                            <div>{{ $order->customer->email }}</div>
                            <div>{{ $order->customer->phonenumber }}</div>
                        @endif
                    </div>
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
                                        @foreach($order->orderDetail as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td style="text-align:center">{{ $item->quantity }}</td>
                                                <td style="text-align:right">{{ number_format( $item->price , 0, ",",".") }}đ</td>
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
                            <div class="col-xs-6 col-sm-6 col-md-4 text-right custom-no-padding">{{ number_format( $order->totalPrice - $fee , 0, ",",".")}} VND</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-xs-6 col-sm-6 col-md-4 col-md-offset-4 custom-no-padding">Phí vận chuyển:</div>
                            <div class="col-xs-6 col-sm-6 col-md-4 text-right custom-no-padding fee">
                                {{ number_format( $fee , 0, ",",".") }} VND
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-xs-6 col-sm-6 col-md-4 col-md-offset-4 order-totalPrice custom-no-padding">Tổng thanh toán</div>
                            <div class="col-xs-6 col-sm-6 col-md-4 text-right custom-no-padding order-totalPrice-price">
                               {{ number_format( $order->totalPrice , 0, ",",".")}} VND
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
            /*$.post("{{ route('order.price') }}", {city_id:city_id, _token:token}, function(data){
                $('#select_district').html('');
                $('#select_district').html(data);
            });*/
            $.ajax({
                url: "{{ route('order.price') }}",
                method:'POST',
                dataType:'json',
                data: {city_id:city_id, _token:token},
                success: function(data) {
                    $('#select_district').html('');
                    $('#select_district').html(data.option);
                    $('.fee').html(data.fee+' VND');
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