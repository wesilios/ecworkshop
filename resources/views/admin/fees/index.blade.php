@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Danh sách thành phố
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Shipping fees</li>
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
			          	<h3 class="box-title">Danh sách thành phố - quận huyện</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body table-responsive no-padding table-bordered">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Thành phố</th>
								<th>Quận - Huyện</th>
								<th>Phí giao hàng</th>
								<th></th>
		                    </tr>
		                    <tr>
		                    	@if($citys->count() > 0)
									@foreach($citys as $city)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $city->city }}</td>
											<td>
												@if($city->feeDistricts->count() > 0)

								                      	<select class="form-control">
								                      		@foreach($city->feeDistricts as $district)
								                        		<option>{{ $district->name }}</option>
								                        	@endforeach
								                      	</select>

												@else
													Chưa có quận nào!
												@endif
											</td>
											<td>{{ number_format($city->fee,0, ",",".") }} đ</td>
											<td>
												<a href="{{ route('admin.fee.edit',[$city->id]) }}" class="btn btn-info btn-sm">Sửa</a>
											</td>
										</tr>
										@php
						            		$i++;
										@endphp
									@endforeach
								@else
								<td colspan="9" style="text-align:center">Chưa có bài viết nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $citys->links()!!}
		                </div>
		            </div>
		        </div>
            </div>
		</div>
	</section>
@endsection
