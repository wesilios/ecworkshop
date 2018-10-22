@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Loại đầu đốt
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Tank Categories</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
			<div class="col-md-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tạo loại đầu đốt mới</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							{!! Form::open(['method'=>'POST', 'action'=>"AdminTankCategoriesController@store", 'class'=>'form-horizontal']) !!}
								<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
		                			{!! Form::label('name', 'Tên loại đầu đốt mới:', ['class' => 'control-label'] ) !!}
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
						<h3 class="box-title">Tất cả loại đầu đốt</h3>
					</div>
					<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Tên loại đầu đốt</th>
								<th>Ngày tạo</th>
								<th>Ngày cập nhật</th>
								<th>Action</th>
		                    </tr>
		                    <tr>
		                    	@if($tank_cats->count() > 0)
									@foreach($tank_cats as $tank_cat)
										<tr>
											<td>{{ $tank_cat->id }}</td>
											<td>{{ $tank_cat->name }}</td>
											<td>{{ $tank_cat->created_at->diffForHumans() }}</td>
											<td>{{ $tank_cat->updated_at->diffForHumans() }}</td>
											<td>
												<a href="#" data-toggle="modal" data-target="#edit{{ $tank_cat->id }}">
						                            <div class="btn btn-info btn-sm">
						                              	<i class="fa fa-edit"></i>
						                            </div>
						                        </a>
						                        <a href="#" data-toggle="modal" data-target="#delete{{ $tank_cat->id }}">
						                            <div class="btn btn-danger btn-sm">
						                              	<i class="fa fa-trash "></i>
						                            </div>
						                        </a>
											</td>
										</tr>
									@endforeach
								@else
								<td colspan="5" style="text-align:center">Chưa có loại đầu đốt nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $tank_cats->links()!!}
		                </div>
		            </div>
				</div>
			</div>
       	</div>
    </section>
    @foreach($tank_cats as $tank_cat)
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="delete{{ $tank_cat->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		        		<div class="modal-body">
		         			<h5>Xóa loại đầu đốt này?</h5>
		        		</div>
		        		<div class="modal-footer">
		        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminTankCategoriesController@destroy', $tank_cat->id], 'class'=>'form-horizontal']) !!}
		        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
	            			{!! Form::close() !!}
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="edit{{ $tank_cat->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		      			<div class="modal-header">
		      				Sửa tên loại đầu đốt
		      				<div class="pull-right">
	                			<button type="button" class="btn-custom btn-default" data-dismiss="modal">
	                				<i class="fa fa-close"></i>
	                			</button>
	              			</div>
		      			</div>
		        		<div class="modal-body">
		        			<div class="col-md-12">
		        				{!! Form::open(['method'=>'PUT', 'action'=>['AdminTankCategoriesController@update', $tank_cat->id], 'class'=>'form-horizontal']) !!}
			        				<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
			                			{!! Form::label('name', 'Tên loại đầu đốt mới:', ['class' => 'control-label'] ) !!}
										{!! Form::text('name', $tank_cat->name, ['class'=>'form-control']) !!}
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