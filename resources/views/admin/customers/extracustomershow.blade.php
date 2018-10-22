@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			{{ $extracustomer->name }}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('admin.customers.index') }}">Extra Customers</a></li>
			<li class="active">{{ $extracustomer->name }}</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
            <div class="col-xs-12">
				
            	@if(session('status'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('status') }}
                </div>
                @endif
                @if(session('error'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('error') }}
                </div>
                @endif
				<div class="box">
			        <div class="box-header">
			          	<h3 class="box-title">Thông tin khách hàng</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body">
	       				<div class="row">
	       					<div class="table-responsive col-sm-12">
		       					<table class="table table-hover">
		          					<tr>
										<th>#Id</th>
										<th>Tên khách hàng</th>
										<th>Email</th>
										<th>Số điện thoại</th>
										<th>Số lượng đơn hàng</th>
										<th>Ngày đăng</th>
				                    </tr>
				                    <tr>
				                    	@if(isset($extracustomer))
											<td>{{ $extracustomer->id }}</td>
											<td>{{ $extracustomer->name }}</td>
											<td>{{ $extracustomer->email }}</td>
											<td>{{ $extracustomer->phonenumber }}</td>
											<td>{{ count($extracustomer->orders) }} đơn hàng</td>
											<td>{{ date("F jS, Y", strtotime($extracustomer->created_at)) }}</td>
										@else
											<td colspan="6" style="text-align:center">Không có kết quả tìm kiếm</td>
				                    	@endif
				                    </tr>
				                </table>
		       				</div>
	       				</div>
		            </div>
		        </div>
		        
		        <div class="box">
		        	<div class="box-header">
			          	<h3 class="box-title">Danh sách đơn hàng</h3>
			        </div><!-- /.box-header -->
		        	<div class="box-body">
	       				<div class="row">
	       					{!! Form::open(['method'=>'POST', 'action'=>'AdminOrdersController@searchOrder']) !!}
								<div class="col-sm-4">
									<label for="search_query">Nhập mã đơn hàng</label>
									<input type="hidden" value="{{ $extracustomer->id }}" name="extra_customer_id">
									<div class="input-group">
					                    <input type="text" class="form-control" name="search_query" placeholder="01062017155541">
					                    <div class="input-group-btn">
					                      	<button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
					                    </div><!-- /btn-group -->
					                </div><!-- /input-group -->
								</div>
		       				{!! Form::close()!!}
		       					<div class="col-sm-6">
		       						<label for="search_query">Tất cả trạng thái đơn hàng</label><br>
		       						@foreach($order_statuses as $status)
		       							@switch($status->id)
											@case(1)
												<a href="" class="order_status" id="{{ $status->id }}"><span class="label label-lg label-primary">{{ $status->name }}</span></a>
												@break
											@case(2)
												<a href="" class="order_status" id="{{ $status->id }}"><span class="label label-lg label-success">{{ $status->name }}</span></a>
												@break
											@case(3)
												<a href="" class="order_status" id="{{ $status->id }}"><span class="label label-lg label-info">{{ $status->name }}</span></a>
												@break
											@default
												<span class="label label-lg label-danger">Hủy</span>
												@break
										@endswitch
		       						@endforeach
		       					</div>
	       				</div>
	       				<div class="row">
	       					<div class="table-responsive col-sm-12">
		       					<table class="table table-hover order_table">
		          					<tr>
										<th>#Id</th>
										<th>Mã đơn hàng</th>
										<th>Số lượng</th>
										<th>Tổng tiền</th>
										<th>Trạng thái</th>
										<th>Ngày đăng</th>
										<th>Action</th>
				                    </tr>
				                    @php
										$i = 1
			                    	@endphp
			                    	@if(isset($extracustomer) && isset($extracustomer->orders))
										@foreach($orders as $order)
											<tr>
												<td>{{ $i }}</td>
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
												<td>{{ date("F jS, Y", strtotime($order->created_at)) }}</td>
												<td>
													<a href="{{ route('admin.order',[$order->orderCode]) }}" class="btn btn-info btn-sm">Xem</a>
												</td>
											</tr>
											@php
							            		$i++;
											@endphp
										@endforeach
									@else
										<tr>
											<td colspan="7" style="text-align:center">Khách hàng này chưa có đơn hàng nào</td>
										</tr>
									@endif
				                </table>
		       				</div>
	       				</div>
			        </div>
		        </div>
            </div>
		</div>
	</section>
@endsection

@section('extendscripts')
	<script>
		$('.order_status').click(function(e) {
			e.preventDefault();
			var $this = $(this);
			var status = $this.attr("id");
			var token = $("input[name='_token']").val();
			var extra_customer_id = $("input[name='extra_customer_id']").val();
			$.ajax({
                url: "{{ route('admin.extracustomer.orders.status') }}",
                method:'POST',
                dataType:'json',
                data: {status:status, extra_customer_id:extra_customer_id, _token:token},
                success: function(data) {
                    $('.order_table').html('');
                    $('.order_table').html(data.option);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.status);
                   console.log(xhr.responseText);
                   console.log(thrownError);
               }
            });
		});

		$("input[name='search_query']").on('keyup', function() {
			$value = $(this).val();
			var token = $("input[name='_token']").val();
			var extra_customer_id = $("input[name='extra_customer_id']").val();
			$.ajax({
				url: "{{ route('admin.extracustomer.order.search') }}",
				method: 'GET',
				dataType:'json',
				data: {search_query:$value,extra_customer_id:extra_customer_id,_token:token},
				success: function(data) {
                    $('.order_table').html('');
                    $('.order_table').html(data.option);
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