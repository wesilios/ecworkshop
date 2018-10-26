@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Tất cả phụ kiện
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Tất cả phụ kiện</li>
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
			          	<h3 class="box-title">Danh sách phụ kiện</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Phụ kiện</th>
								<th>Loại phụ kiện</th>
								<th>Giá</th>
								<th>Giá giảm</th>
								<th>Ngày đăng</th>
								<th>Đăng bởi</th>
								<th></th>
		                    </tr>
		                    <tr>
		                    	@if($accessories->count() > 0)
									@foreach($accessories as $accessory)
										<tr>
											<td>{{ $accessory->id }}</td>
											<td>{{ $accessory->item->name }}</td>
											<td>{{ $accessory->item->itemCategory['name'] }}</td>
											<td>{{ number_format($accessory->item->price,0, ",",".") }} đ</td>
											<td>{{ $accessory->item->price_off }}</td>
											<td>{{ date("F jS, Y", strtotime($accessory->created_at)) }}</td>
											<td>{{ $accessory->item->admin->name }}</th>
											<td>
												<a href="{{ route('accessories.edit',[$accessory->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit "></i> Sửa</a>
												<a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm">
													<i class="fa fa-trash "></i> Xóa
												</a>
											</td>
										</tr>
									@endforeach
								@else
								<td colspan="9" style="text-align:center">Chưa có phụ kiện nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $accessories->links()!!}
		                </div>
		            </div>
		        </div>
		        <a href="{{ route('accessories.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> Phụ kiện mới</a>
            </div>
		</div>
	</section>
	@if($accessories->count() > 0)
		@foreach($accessories as $accessory)
			<div class="example-modal">
			  	<div class="modal fade item_modal" id="delete" role="dialog">
			    	<div class="modal-dialog delete-dialog" style="">
			      		<div class="modal-content">
			        		<div class="modal-body">
			         			<h5>Xóa sản phẩm này?</h5>
			        		</div>
			        		<div class="modal-footer">
			        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminAccessoriesController@destroy', $accessory->id], 'class'=>'form-horizontal']) !!}
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
