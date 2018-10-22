@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Tất cả buồng đốt
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Tất cả buồng đốt</li>
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
			          	<h3 class="box-title">Danh sách đầu đốt</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Buồng đốt</th>
								<th>Loại đầu đốt</th>
								<th>Giá</th>
								<th>Giá giảm</th>
								<th>Ngày đăng</th>
								<th>Đăng bởi</th>
								<th></th>
		                    </tr>
		                    <tr>
		                    	@if($tanks->count() > 0)
									@foreach($tanks as $tank)
										<tr>
											<td>{{ $tank->id }}</td>
											<td>{{ $tank->item->name }}</td>
											<td>{{ $tank->item->itemCategory['name'] }}</td>
											<td>{{ number_format($tank->item->price,0, ",",".") }} đ</td>
											<td>{{ $tank->item->price_off }}</td>
											<td>{{ date("F jS, Y", strtotime($tank->created_at)) }}</td>
											<td>{{ $tank->item->admin->name }}</th>
											<td>
												<a href="{{ route('tanks.edit',[$tank->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit "></i> Sửa</a>
												<a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm">
													<i class="fa fa-trash "></i> Xóa
												</a>
											</td>
										</tr>
									@endforeach
								@else
								<td colspan="9" style="text-align:center">Chưa có buồng đốt nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $tanks->links()!!}
		                </div>
		            </div>
		        </div>
		        <a href="{{ route('tanks.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> Buồng đốt mới</a>
            </div>
		</div>
	</section>
	@if($tanks->count() > 0)
		@foreach($tanks as $tank)
			<div class="example-modal">
			  	<div class="modal fade item_modal" id="delete" role="dialog">
			    	<div class="modal-dialog delete-dialog" style="">
			      		<div class="modal-content">
			        		<div class="modal-body">
			         			<h5>Xóa sản phẩm này?</h5>
			        		</div>
			        		<div class="modal-footer">
			        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminTanksController@destroy', $tank->id], 'class'=>'form-horizontal']) !!}
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
