@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Danh sách khách hàng
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Customers</li>
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
                @if(session('error'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('error') }}
                </div>
                @endif
				<div class="box">
			        <div class="box-header">
			          	<h3 class="box-title">Khách hàng đăng ký</h3>
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
										<th>Ngày tạo</th>
										<th>Action</th>
				                    </tr>
				                    <tr>
				                    	@if(isset($customers) && $customers->isNotEmpty())
											@foreach($customers as $customer)
												<tr>
													<td>{{ $i }}</td>
													<td><a href="{{ route('admin.customer.show', [$customer->id]) }}">{{ $customer->name }}</a></td>
													<td>{{ $customer->email }}</td>
													<td>{{ $customer->phonenumber }}</td>
													<td>{{ count($customer->orders) }} đơn hàng</td>
													<td>{{ date("F jS, Y", strtotime($customer->created_at)) }}</td>
													<td>
														<a href="{{ route('admin.customer.show', [$customer->id]) }}" class="btn btn-info btn-sm">Xem</a>
													</td>
												</tr>
												@php
								            		$i++;
												@endphp
											@endforeach
										@else
											<td colspan="7" style="text-align:center">Không có kết quả tìm kiếm</td>
				                    	@endif
				                    </tr>
				                </table>
		       				</div>
	       				</div>
	       				
	          			
		                <div class="text-center">
		                	{!! $customers->links()!!}
		                </div>
		            </div>
		        </div>
		        <div class="box">
			        <div class="box-header">
			          	<h3 class="box-title">Khách hàng không đăng ký</h3>
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
										<th>Action</th>
				                    </tr>
				                    <tr>
				                    	@if(isset($extraCustomers) && $extraCustomers->isNotEmpty())
											@foreach($extraCustomers as $extraCustomer)
												<tr>
													<td>{{ $i }}</td>
													<td><a href="{{ route('admin.extracustomer.show', [$extraCustomer->id]) }}">{{ $extraCustomer->name }}</a></td>
													<td>{{ $extraCustomer->email }}</td>
													<td>{{ $extraCustomer->phonenumber }}</td>
													<td>{{ count($extraCustomer->orders) }} đơn hàng</td>
													<td>{{ date("F jS, Y", strtotime($extraCustomer->created_at)) }}</td>
													<td>
														<a href="{{ route('admin.extracustomer.show', [$extraCustomer->id]) }}" class="btn btn-info btn-sm">Xem</a>
													</td>
												</tr>
												@php
								            		$i++;
												@endphp
											@endforeach
										@else
											<td colspan="7" style="text-align:center">Không có kết quả tìm kiếm</td>
				                    	@endif
				                    </tr>
				                </table>
		       				</div>
	       				</div>
	       				
	          			
		                <div class="text-center">
		                	{!! $extraCustomers->links()!!}
		                </div>
		            </div>
		        </div>
            </div>
		</div>
	</section>
@endsection
