@extends('layouts.adminapp')
@section('content')
	<section class="content-header">
		<h1>
			{{ $fee->city }}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('admin.fee.index') }}">Shipping fees</a></li>
			<li class="active">Edit</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
			<div class="col-md-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Chỉnh sửa chi phí</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							{!! Form::open(['method'=>'PUT', 'action'=>["AdminFeesController@update", $fee->id], 'class'=>'form-horizontal']) !!}
								<div class="form-group {{ $errors->has('fee') ? ' has-error' : '' }}">
		                			{!! Form::label('fee', 'Chi phí giao hàng:', ['class' => 'control-label'] ) !!}
									{!! Form::text('fee', $fee->fee, ['class'=>'form-control']) !!}
			                    </div>
			                    <div class="form-group">
			                    	{!! Form::submit('Lưu', ['class'=>'col-md-12 btn btn-info']) !!}
			                    </div>
			                {!! Form::close()!!}
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Thêm quận - huyện mới</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							{!! Form::open(['method'=>'POST', 'action'=>["AdminFeesController@store", $fee->id] , 'class'=>'form-horizontal']) !!}
								<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
		                			{!! Form::label('name', 'Tên quận huyện mới:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name', null, ['class'=>'form-control']) !!}
									@if ($errors->has('name'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('name') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group">
			                    	{!! Form::submit('Lưu', ['class'=>'col-md-12 btn btn-primary']) !!}
			                    </div>
			                {!! Form::close()!!}
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				@if(session('feesetting'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('feesetting') }}
                </div>
                @endif
                @if(session('district'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('district') }}
                </div>
                @endif
                @if(session('delete'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('delete') }}
                </div>
                @endif
                @if ($errors->has('name'))
	                <div class="alert alert-warning alert-dismissable">
	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
	                    {{ $errors->first('name') }}
	                </div>
	            @endif
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Danh sách quận huyện</h3>
					</div>
					<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Tên</th>
								<th>Ngày tạo</th>
								<th>Ngày cập nhật</th>
								<th>Action</th>
		                    </tr>
		                    <tr>
		                    	@if($fee->feeDistricts->count() > 0)
									@foreach($fee->feeDistricts as $district)
										<tr>
											<td>{{ $district->id }}</td>
											<td>{{ $district->name }}</td>
											<td>{{ $district->created_at->diffForHumans() }}</td>
											<td>{{ $district->updated_at->diffForHumans() }}</td>
											<td>
												<a href="#" data-toggle="modal" data-target="#edit{{ $district->id }}">
						                            <div class="btn btn-info btn-sm">
						                              	<i class="fa fa-edit"></i>
						                            </div>
						                        </a>
						                        <a href="#" data-toggle="modal" data-target="#delete{{ $district->id }}">
						                            <div class="btn btn-danger btn-sm">
						                              	<i class="fa fa-trash "></i>
						                            </div>
						                        </a>
											</td>
										</tr>
									@endforeach
								@else
								<td colspan="5" style="text-align:center">Chưa có loại tinh dầu nào</td>
		                    	@endif
		                    </tr>
		                </table>
		            </div>
				</div>
			</div>
       	</div>
    </section>
    @foreach($fee->feeDistricts as $district)
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="delete{{ $district->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		        		<div class="modal-body">
		         			<h5>Xóa quận huyện này?</h5>
		        		</div>
		        		<div class="modal-footer">
		        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminFeesController@destroy', $district->id], 'class'=>'form-horizontal']) !!}
		        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
	            			{!! Form::close() !!}
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="edit{{ $district->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		      			<div class="modal-header">
		      				Sửa quận huyện
		      				<div class="pull-right">
	                			<button type="button" class="btn-custom btn-default" data-dismiss="modal">
	                				<i class="fa fa-close"></i>
	                			</button>
	              			</div>
		      			</div>
		        		<div class="modal-body">
		        			<div class="col-md-12">
		        				{!! Form::open(['method'=>'PUT', 'action'=>['AdminFeesController@updateDistrict', $fee->id, $district->id], 'class'=>'form-horizontal']) !!}
			        				<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
			                			{!! Form::label('name', 'Quận huyện mới:', ['class' => 'control-label'] ) !!}
										{!! Form::text('name', $district->name, ['class'=>'form-control']) !!}
										@if ($errors->has('name'))
							                <span class="help-block">
							                    <strong>{{ $errors->first('name') }}</strong>
							                </span>
							            @endif
				                    </div>
				                    <div class="form-group">
				                    	{!! Form::submit('Lưu chỉnh sửa', ['class'=>'col-md-12 btn btn-primary']) !!}
				                    </div>
		            			{!! Form::close() !!}
		        			</div>
		        		</div>
		        		<div class="modal-footer">

		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
    @endforeach
@endsection