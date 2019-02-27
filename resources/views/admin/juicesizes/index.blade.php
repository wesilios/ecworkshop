@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Dung tích tinh dầu
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Juices Sizes</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
			<div class="col-md-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tạo dung tích mới</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							{!! Form::open(['method'=>'POST', 'action'=>"AdminSizesController@store", 'class'=>'form-horizontal']) !!}
								<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
		                			{!! Form::label('name', 'Dung tích mới:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name', null, ['class'=>'form-control']) !!}
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
						<h3 class="box-title">Tất cả dung tích</h3>
					</div>
					<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Dung tích</th>
								<th>Ngày tạo</th>
								<th>Ngày cập nhật</th>
								<th>Action</th>tích
		                    </tr>
		                    <tr>
		                    	@if($juice_sizes->count() > 0)
									@foreach($juice_sizes as $juice_size)
										<tr>
											<td>{{ $juice_size->id }}</td>
											<td>{{ $juice_size->name }}</td>
											<td>{{ $juice_size->created_at->diffForHumans() }}</td>
											<td>{{ $juice_size->updated_at->diffForHumans() }}</td>
											<td>
												<a href="#" data-toggle="modal" data-target="#edit{{ $juice_size->id }}">
						                            <div class="btn btn-info btn-sm">
						                              	<i class="fa fa-edit"></i>
						                            </div>
						                        </a>
						                        <a href="#" data-toggle="modal" data-target="#delete{{ $juice_size->id }}">
						                            <div class="btn btn-danger btn-sm">
						                              	<i class="fa fa-trash "></i>
						                            </div>
						                        </a>
											</td>
										</tr>
									@endforeach
								@else
								<td colspan="5" style="text-align:center">Chưa có dung tích nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $juice_sizes->links()!!}
		                </div>
		            </div>
				</div>
			</div>
       	</div>
    </section>
    @foreach($juice_sizes as $juice_size)
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="delete{{ $juice_size->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		        		<div class="modal-body">
		         			<h5>Xóa dung tích này?</h5>
		        		</div>
		        		<div class="modal-footer">
		        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminSizesController@destroy', $juice_size->id], 'class'=>'form-horizontal']) !!}
		        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
	            			{!! Form::close() !!}
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="edit{{ $juice_size->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		      			<div class="modal-header">
		      				Sửa dung tích
		      				<div class="pull-right">
	                			<button type="button" class="btn-custom btn-default" data-dismiss="modal">
	                				<i class="fa fa-close"></i>
	                			</button>
	              			</div>
		      			</div>
		        		<div class="modal-body">
		        			<div class="col-md-12">
		        				{!! Form::open(['method'=>'PUT', 'action'=>['AdminSizesController@update', $juice_size->id], 'class'=>'form-horizontal']) !!}
			        				<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
			                			{!! Form::label('name', 'Tên dung tích mới:', ['class' => 'control-label'] ) !!}
										{!! Form::text('name', $juice_size->name, ['class'=>'form-control']) !!}
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