@extends('layouts.adminapp')

@section('content')
  <section class="content-header">
		<h1>
			#{{ $order->orderCode }}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('admin.orders.index') }}">Tất cả đơn hàng</a></li>
      <li class="active">#{{ $order->orderCode }}</li>
		</ol>
	</section>

	<div class="pad margin no-print">
    @if(session('status'))
    <div class="callout callout-warning">
      <h4><i class="fa fa-info"></i> Note:</h4>
      {{ session('status') }}
    </div>
    @endif
    <div class="callout callout-info" style="margin-bottom: 0!important;">
      <h4><i class="fa fa-info"></i> Trạng thái đơn hàng:</h4>
      {{ $order->status->name}}
    </div>
  </div>

  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i>
          @if($order->customer_id > 0 && $order->extra_customer_id ==0)
            {{ $order->customer->name}}
            <a href="{{ route('admin.customer.show',[$order->customer_id]) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
          @else
            {{ $order->extracustomer->name}}
            <a href="{{ route('admin.extracustomer.show',[$order->extra_customer_id]) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
          @endif
          <small class="pull-right">Ngày đặt hàng: {{ date("j/n/Y", strtotime($order->created_at)) }}</small>
        </h2>
      </div><!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Khách hàng
        @if($order->customer_id > 0 && $order->extra_customer_id ==0)
          <address>
            <strong>{{ $order->customer->name}}.</strong><br>
            {{ $order->address}}<br>
            {{ $order->district }}, {{ $order->city}}<br>
            Phone: {{ $order->customer->phonenumber}}<br>
            Email: {{ $order->customer->email}}
          </address>
        @else
          <address>
            <strong>{{ $order->extracustomer->name}}.</strong><br>
            {{ $order->address}}<br>
            {{ $order->district }}, {{ $order->city}}<br>
            Phone: {{ $order->extracustomer->phonenumber}}<br>
            Email: {{ $order->extracustomer->email}}
          </address>
        @endif
        
      </div><!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Mã đơn hàng:</b> #{{ $order->orderCode }}<br>
        <b>Trạng thái đơn hàng:</b> <span class="label label-primary">{{ $order->status->name }}</span><br>
        <b>Ghi chú của đơn hàng:</b> {{ $order->note == null ? 'N/A' :  $order->note }}<br>
      </div><!-- /.col -->
      <div class="col-sm-4 invoice-col">
        
      </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Stt</th>
              <th>Danh sách sản phẩm</th>
              <th>Đặc trung sản phẩm</th>
              <th>Số lượng</th>
              <th>Giá</th>
            </tr>
          </thead>
          <tbody>
            @php
              $totalItemsPrice = 0;
              $i = 1
            @endphp
            @foreach($order->orderDetail as $item)
              <tr>
                <td>{{ $i }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->feature == null ? '--' : $item->feature}}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price ,0, ",", ".") }}đ</td>
              </tr>
              @php
                $totalItemsPrice += $item->price;
                $i++
              @endphp
            @endforeach
          </tbody>
        </table>
      </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        
      </div><!-- /.col -->
      <div class="col-xs-6">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Thành tiền:</th>
              <td>{{ number_format($totalItemsPrice ,0, ",", ".") }}đ</td>
            </tr>
            <tr>
              <th>Phí giao hàng:</th>
              <td>{{ number_format($order->totalPrice - $totalItemsPrice ,0, ",", ".") }}đ</td>
            </tr>
            <tr>
              <th>Tổng tiền:</th>
              <td>{{ number_format($order->totalPrice ,0, ",", ".") }}đ</td>
            </tr>
          </table>
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
      {!! Form::open(['method'=>'PUT','action'=>['AdminOrdersController@updateOrder', $order->id ]]) !!}
      <div class="col-xs-2 col-xs-offset-7">
        {!! Form::select(
              'order_status_id',
              $order_statuses,
              $order->order_status_id,
              ['class'=>'form-control']
              );
        !!}
      </div>
      <div class="col-xs-2">
        <button class="btn btn-success btn-block pull-right" type="sumit"><i class="fa fa-credit-card"></i> Lưu chỉnh sửa</button>
      </div>
      {!! Form::close() !!}
      <div class="col-xs-1">
        <a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-block">
          <i class="fa fa-trash "></i> Xóa
        </a>
      </div>
    </div>
  </section><!-- /.content -->
  <div class="clearfix"></div>
  <div class="example-modal">
    <div class="modal fade item_modal" id="delete" role="dialog">
      <div class="modal-dialog delete-dialog" style="">
          <div class="modal-content">
            <div class="modal-body">
              <h5>Xóa đơn hàng này?</h5>
            </div>
            <div class="modal-footer">
              {!! Form::open(['method'=>'DELETE', 'action'=>['AdminOrdersController@delete', $order->id], 'class'=>'form-horizontal']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            {!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
          </div>
      </div>
  </div>
</div>

@endsection