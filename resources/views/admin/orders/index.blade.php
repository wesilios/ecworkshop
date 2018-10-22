@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Tất cả đơn hàng
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active"><a href="{{ route('admin.orders.index') }}">Tất cả đơn hàng</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
            <div class="col-xs-12">
				@php
            		$i = 1;
				@endphp
            	@if(session('status'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('status') }}
                </div>
                @endif
                @if(session('delete'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('delete') }}
                </div>
                @endif
				<div class="box">
			        <div class="box-header">
			          	<h3 class="box-title">Danh sách đơn hàng</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body">
	       				<div class="row">
	       					{!! Form::open(['method'=>'POST', 'action'=>'AdminOrdersController@searchOrder']) !!}
								<div class="col-sm-2">
									<div class="form-group">
										<label for="search_type">Search options</label>
										<select name="search_type" id="search_type" class="form-control ">
											<option value="ma_don_hang">Mã đơn hàng</option>
											<option value="so_dien_thoai">Số điện thoại khách hàng</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<label for="search_query">Nhập mã đơn hàng hoặc số điện thoại</label>
									<div class="input-group">
					                    <input type="text" class="form-control" name="search_query" placeholder="01062017155541 or 0909362514" id="search_query">
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
												<a href="{{ route('admin.orders.status',[$status->id]) }}"><span class="label label-lg label-primary">{{ $status->name }}</span></a>
												@break
											@case(2)
												<a href="{{ route('admin.orders.status',[$status->id]) }}"><span class="label label-lg label-success">{{ $status->name }}</span></a>
												@break
											@case(3)
												<a href="{{ route('admin.orders.status',[$status->id]) }}"><span class="label label-lg label-info">{{ $status->name }}</span></a>
												@break
											@case(4)
												<a href="{{ route('admin.orders.status',[$status->id]) }}"><span class="label label-lg label-danger">{{ $status->name }}</span></a>
												@break
											@default
												<span class="label label-danger">Tài khoản chưa có role</span>
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
										<th>Ngày đặt</th>
										<th>Action</th>
				                    </tr>
				                    <tr>
				                    	@if(isset($orders) && $orders->isNotEmpty())
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
															@case(4)
																<a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-danger">{{ $order->status->name }}</span></a>
																@break
															@default
																<span class="label label-danger">Hủy</span>
																@break
														@endswitch
														
													</td>
													<td>{{ date("F jS, Y", strtotime($order->created_at)) }}</td>
													<td>
														<a href="{{ route('admin.order',[$order->orderCode]) }}" class="btn btn-info btn-sm"><i class="fa fa-eye "></i> Xem</a>
														<a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm">
															<i class="fa fa-trash "></i> Xóa
														</a>
													</td>
												</tr>
												@php
								            		$i++;
												@endphp
											@endforeach
										@else
											@if(isset($customer_orders) && $customer_orders->isNotEmpty())
												@foreach($customer_orders as $order)
													<tr>
														<td>{{ $i }}</td>
														<td>{{ $order->orderCode }}</td>
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
																@case(4)
																		<a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-danger">{{ $order->status->name }}</span></a>
																		@break
																@default
																	<span class="label label-danger">Tài khoản chưa có role</span>
																	@break
															@endswitch
															
														</td>
														<td>{{ date("F jS, Y", strtotime($order->created_at)) }}</td>
														<td>
															<a href="{{ route('admin.order',[$order->orderCode]) }}" class="btn btn-info btn-sm"><i class="fa fa-eye "></i> Xem</a>
															<a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm">
																<i class="fa fa-trash "></i> Xóa
															</a>
														</td>
													</tr>
													@php
									            		$i++;
													@endphp
												@endforeach
											@else
												@if(isset($extraCustomer_orders) && $extraCustomer_orders->isNotEmpty())
													@foreach($extraCustomer_orders as $order)
														<tr>
															<td>{{ $i }}</td>
															<td>{{ $order->orderCode }}</td>
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
																	@case(4)
																		<a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-danger">{{ $order->status->name }}</span></a>
																		@break
																	@default
																		<span class="label label-danger">Tài khoản chưa có role</span>
																		@break
																@endswitch
																
															</td>
															<td>{{ date("F jS, Y", strtotime($order->created_at)) }}</td>
															<td>
																<a href="{{ route('admin.order',[$order->orderCode]) }}" class="btn btn-info btn-sm"><i class="fa fa-eye "></i> Xem</a>
																<a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm">
																	<i class="fa fa-trash "></i> Xóa
																</a>
															</td>
														</tr>
														@php
										            		$i++;
														@endphp
													@endforeach
												@else
												<td colspan="7" style="text-align:center">Không có kết quả tìm kiếm</td>
						                    	@endif
					                    	@endif
				                    	@endif
				                    </tr>
				                </table>
		       				</div>
	       				</div>
	       				
	          			
		                <div class="text-center">
		                	{!! $orders->links()!!}
		                </div>
		            </div>
		        </div>
            </div>
		</div>
	</section>
	@if($orders->count() > 0)
		@foreach($orders as $order)
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
		@endforeach
	@endif
@endsection

@section('extendscripts')
	<script type="text/javascript">
		$('#search_query').on('keyup', function() {
			var _token = $("input[name='_token']").val();
			var search_query = $(this).val();
			var search_type = $("#search_type").val();
			$.ajax({
				url: "{{route('admin.orders.ajaxSearch')}}",
				method: 'GET',
				dataType:'json',
				data: {search_query:search_query,search_type:search_type,_token:_token},
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