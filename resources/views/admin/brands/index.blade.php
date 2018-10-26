@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Hãng của sản phẩm
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Brand</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
			<div class="col-md-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tạo hãng sản phẩm mới</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							{!! Form::open(['method'=>'POST', 'action'=>"AdminBrandsController@store", 'class'=>'form-horizontal']) !!}
								<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
		                			{!! Form::label('name', 'Tên hãng mới:', ['class' => 'control-label'] ) !!}
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
				@if(session('status'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('status') }}
                </div>
                @endif
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tất cả hãng sản phẩm</h3>
					</div>
					<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Tên hãng</th>
								<th>Ngày tạo</th>
								<th>Ngày cập nhật</th>
								<th>Action</th>
		                    </tr>
		                    <tr>
		                    	@if($brands->count() > 0)
									@foreach($brands as $brand)
										<tr>
											<td>{{ $brand->id }}</td>
											<td>{{ $brand->name }}</td>
											<td>{{ $brand->created_at->diffForHumans() }}</td>
											<td>{{ $brand->updated_at->diffForHumans() }}</td>
											<td>
												<a href="#" data-toggle="modal" data-target="#edit{{ $brand->id }}">
						                            <div class="btn btn-info btn-sm">
						                              	<i class="fa fa-edit"></i>
						                            </div>
						                        </a>
						                        <a href="#" data-toggle="modal" data-target="#delete{{ $brand->id }}">
						                            <div class="btn btn-danger btn-sm">
						                              	<i class="fa fa-trash "></i>
						                            </div>
						                        </a>
											</td>
										</tr>
									@endforeach
								@else
								<td colspan="4" style="text-align:center">Chưa có hãng sản phẩm nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $brands->links()!!}
		                </div>
		            </div>
				</div>
			</div>
       	</div>
    </section>
    @foreach($brands as $brand)
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="delete{{ $brand->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		        		<div class="modal-body">
		         			<h5>Xóa hãng này?</h5>
		        		</div>
		        		<div class="modal-footer">
		        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminBrandsController@destroy', $brand->id], 'class'=>'form-horizontal']) !!}
		        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
	            			{!! Form::close() !!}
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="edit{{ $brand->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		      			<div class="modal-header">
		      				Sửa tên hãng
		      				<div class="pull-right">
	                			<button type="button" class="btn-custom btn-default" data-dismiss="modal">
	                				<i class="fa fa-close"></i>
	                			</button>
	              			</div>
		      			</div>
		        		<div class="modal-body">
		        			<div class="col-md-12">
		        				{!! Form::open(['method'=>'PUT', 'action'=>['AdminBrandsController@update', $brand->id], 'class'=>'form-horizontal']) !!}
			        				<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
			                			{!! Form::label('name', 'Tên hãng mới:', ['class' => 'control-label'] ) !!}
										{!! Form::text('name', $brand->name, ['class'=>'form-control']) !!}
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