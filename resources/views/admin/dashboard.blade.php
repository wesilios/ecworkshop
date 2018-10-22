@extends('layouts.adminapp')
@section('content')

	<section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @if(Auth::user()->role_id < 3)  
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $allOrdersCount }}</h3>
                            <p>Tất cả đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $allItemsCount }}</h3>
                            <p>Tất cả sản phẩm</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('fullkits.index') }}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $allCustomersCount }}</h3>
                            <p>Khách hàng đăng ký</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.customers.index') }}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $allExtraCustomerCount }}</h3>
                            <p>Khách hàng không đăng ký</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('admin.customers.index') }}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->

            @php
                $i = 1;
            @endphp
            <div class="row">
                <div class="col-md-7">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Đơn hàng mới</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày đặt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sevenOrders as $order)
                                            <tr>
                                                <td><a href="{{ route('admin.order',[$order->orderCode]) }}">{{ $order->orderCode }}</a></td>
                                                <td>{{ $order->totalQty }}</td>
                                                <td>{{ number_format($order->totalPrice,0, ",",".") }} đ</td>
                                                <td>
                                                    @switch($order->order_status_id)
                                                        @case(1)
                                                            <a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-primary">{{ $order->status->name }}</span></a>
                                                            @break
                                                        @case(2)
                                                            <a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-success">{{ $order->status->name }}</span></a>
                                                            @break
                                                        @case(3)
                                                            <a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-info">{{ $order->status->name }}</span></a>
                                                            @break
                                                        @default
                                                            <span class="label label-danger">Hủy</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                          </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                          <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-info btn-flat pull-right">Xem tất cả</a>
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div>
                <div class="col-md-5">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Khách hàng đăng ký mới</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>#Id</th>
                                            <th>Tên khách hàng</th>
                                            <th>Số điện thoại</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sevenCustomer as $customer)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td><a href="{{ route('admin.customer.show', [$customer->id]) }}">{{ $customer->name }}</a></td>
                                                <td>{{ $customer->phonenumber }}</td>
                                                <td>{{ $customer->created_at->diffForHumans() }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                          </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                          <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-info btn-flat pull-right">Xem tất cả</a>
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div>
            </div>

            @php
                $i = 1;
            @endphp
            <div class="row">
                <div class="col-md-7">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Bài viết mới</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th style="width:30%">Tiêu đề</th>
                                            <th>Danh mục</th>
                                            <th>Thẻ bài viết</th>
                                            <th>Ngày tạo</th>
                                            <th>Đăng bởi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($sevenArticle->count() > 0)
                                            @foreach($sevenArticle as $article)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('articles.edit',[$article->id]) }}">
                                                            {{ $article->title }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $article->category->name }}</td>
                                                    <td>
                                                        @foreach($article->tags as $tag)
                                                            <span class="label label-info">{{ $tag->name }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $article->created_at->diffForHumans() }}</td>
                                                    <td>{{ $article->admin->name }}</th>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @else
                                        <td colspan="9" style="text-align:center">Chưa có bài viết nào</td>
                                        @endif
                                    </tbody>
                                </table>
                          </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                          <a href="{{ route('articles.index') }}" class="btn btn-sm btn-info btn-flat pull-right">Xem tất cả</a>
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div>
                @php
                    $i = 1;
                @endphp
                <div class="col-md-5">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Khách hàng không đăng ký</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>#Id</th>
                                            <th>Tên khách hàng</th>
                                            <th>Số điện thoại</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sevenExtraCustomer as $customer)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td><a href="{{ route('admin.customer.show', [$customer->id]) }}">{{ $customer->name }}</a></td>
                                                <td>{{ $customer->phonenumber }}</td>
                                                <td>{{ $customer->created_at->diffForHumans() }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                          </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                          <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-info btn-flat pull-right">Xem tất cả</a>
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $allOrdersCount }}</h3>
                            <p>Tất cả đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $allItemsCount }}</h3>
                            <p>Tất cả sản phẩm</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $allCustomersCount }}</h3>
                            <p>Khách hàng đăng ký</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $allExtraCustomerCount }}</h3>
                            <p>Khách hàng không đăng ký</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->

            @php
                $i = 1;
            @endphp
            <div class="row">
                <div class="col-md-7">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Đơn hàng mới</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày đặt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sevenOrders as $order)
                                            <tr>
                                                <td><a href="">{{ $order->orderCode }}</a></td>
                                                <td>{{ $order->totalQty }}</td>
                                                <td>{{ number_format($order->totalPrice,0, ",",".") }} đ</td>
                                                <td>
                                                    @switch($order->order_status_id)
                                                        @case(1)
                                                            <a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-primary">{{ $order->status->name }}</span></a>
                                                            @break
                                                        @case(2)
                                                            <a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-success">{{ $order->status->name }}</span></a>
                                                            @break
                                                        @case(3)
                                                            <a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-info">{{ $order->status->name }}</span></a>
                                                            @break
                                                        @default
                                                            <span class="label label-danger">Tài khoản chưa có role</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                          </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div>
                <div class="col-md-5">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Khách hàng đăng ký mới</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>#Id</th>
                                            <th>Tên khách hàng</th>
                                            <th>Số điện thoại</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sevenCustomer as $customer)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td><a href="">{{ $customer->name }}</a></td>
                                                <td>{{ $customer->phonenumber }}</td>
                                                <td>{{ $customer->created_at->diffForHumans() }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                          </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div>
            </div>

            @php
                $i = 1;
            @endphp
            <div class="row">
                <div class="col-md-7">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Bài viết mới</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th style="width:30%">Tiêu đề</th>
                                            <th>Danh mục</th>
                                            <th>Thẻ bài viết</th>
                                            <th>Ngày tạo</th>
                                            <th>Đăng bởi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($sevenArticle->count() > 0)
                                            @foreach($sevenArticle as $article)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('articles.edit',[$article->id]) }}">
                                                            {{ $article->title }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $article->category->name }}</td>
                                                    <td>
                                                        @foreach($article->tags as $tag)
                                                            <span class="label label-info">{{ $tag->name }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $article->created_at->diffForHumans() }}</td>
                                                    <td>{{ $article->admin->name }}</th>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @else
                                        <td colspan="9" style="text-align:center">Chưa có bài viết nào</td>
                                        @endif
                                    </tbody>
                                </table>
                          </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                          <a href="{{ route('articles.index') }}" class="btn btn-sm btn-info btn-flat pull-right">Xem tất cả</a>
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div>
                @php
                    $i = 1;
                @endphp
                <div class="col-md-5">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Khách hàng không đăng ký</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>#Id</th>
                                            <th>Tên khách hàng</th>
                                            <th>Số điện thoại</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sevenExtraCustomer as $customer)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td><a href="">{{ $customer->name }}</a></td>
                                                <td>{{ $customer->phonenumber }}</td>
                                                <td>{{ $customer->created_at->diffForHumans() }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                          </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div>
            </div>
        @endif
    </section><!-- /.content -->

@endsection