@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Loại sản phẩm
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Items Categories</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
			<div class="col-md-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tạo loại sản phẩm mới</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							{!! Form::open(['method'=>'POST', 'action'=>"AdminItemCategoriesController@store", 'class'=>'form-horizontal']) !!}
								<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
		                			{!! Form::label('name', 'Tên loại sản phẩm mới:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name', null, ['class'=>'form-control']) !!}
			                    </div>
								<div class="form-group">
									<label for="">Màu sắc</label>
									<select name="feature[color]" class="form-control">
										<option value=""></option>
										<option value="single">Single</option>
										<option value="multiple">Multiple</option>
									</select>
								</div>
								<div class="form-group">
									<label for="">Dung tích</label>
									<select name="feature[size]" class="form-control">
										<option value=""></option>
										<option value="single">Single</option>
										<option value="multiple">Multiple</option>
									</select>
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
                @if(session('error'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('error') }}
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
						<h3 class="box-title">Tất cả loại sản phẩm</h3>
					</div>
					<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Tên loại sản phẩm</th>
								<th>Loại sản phẩm cha</th>
								<th>Ngày tạo</th>
								<th>Ngày cập nhật</th>
								<th>Action</th>
		                    </tr>
		                    <tr>
		                    	@if($item_cats->count() > 0)
									@foreach($item_cats as $item_cat)
										<tr>
											{!! Form::open(['method'=>'PUT', 'action'=>['AdminItemCategoriesController@updateItemCatsParent', $item_cat->id], 'class'=>'form-horizontal']) !!}
											<td>{{ $item_cat->id }}</td>
											<td>{{ $item_cat->name }}</td>
											<td>
												<select name="item_category_id" id="item_category_id" class="form-control">
													@if($item_cat->id == $item_cat->item_category_id)
														<option value="" selected>-- Không có loại sản phẩm cha --</option>
													@endif
													@foreach($item_cats_parent as $key => $it_cat_parent)
														@if($key != $item_cat->id)
															<option value="{{ $key }}" {{ $key == $item_cat->item_category_id ? 'selected' : '' }}>{{ $it_cat_parent }}</option>
														@endif
													@endforeach
												</select>
											</td>
											<td>{{ $item_cat->created_at->diffForHumans() }}</td>
											<td>{{ $item_cat->updated_at->diffForHumans() }}</td>
											<td>
												<button class="btn btn-info btn-sm" type="submite"><i class="fa fa-save"></i></button>
												<a href="#" data-toggle="modal" data-target="#edit{{ $item_cat->id }}">
						                            <div class="btn btn-default btn-sm">
						                              	<i class="fa fa-edit"></i>
						                            </div>
						                        </a>
						                        <a href="#" data-toggle="modal" data-target="#delete{{ $item_cat->id }}">
						                            <div class="btn btn-danger btn-sm">
						                              	<i class="fa fa-trash "></i>
						                            </div>
						                        </a>
											</td>
											{!! Form::close() !!}
										</tr>
									@endforeach
								@else
								<td colspan="5" style="text-align:center">Chưa có loại sản phẩm nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $item_cats->links()!!}
		                </div>
		            </div>
				</div>
			</div>
       	</div>
    </section>
    @foreach($item_cats as $item_cat)
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="delete{{ $item_cat->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		        		<div class="modal-body">
		         			<h5>Xóa loại sản phẩm này?</h5>
		        		</div>
		        		<div class="modal-footer">
		        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminItemCategoriesController@destroy', $item_cat->id], 'class'=>'form-horizontal']) !!}
		        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
	            			{!! Form::close() !!}
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="edit{{ $item_cat->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		      			<div class="modal-header">
		      				Sửa tên loại sản phẩm
		      				<div class="pull-right">
	                			<button type="button" class="btn-custom btn-default" data-dismiss="modal">
	                				<i class="fa fa-close"></i>
	                			</button>
	              			</div>
		      			</div>
		        		<div class="modal-body">
		        			<div class="col-md-12">
		        				{!! Form::open(['method'=>'PUT', 'action'=>['AdminItemCategoriesController@update', $item_cat->id], 'class'=>'form-horizontal']) !!}
			        				<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
			                			{!! Form::label('name', 'Tên loại sản phẩm mới:', ['class' => 'control-label'] ) !!}
										{!! Form::text('name', $item_cat->name, ['class'=>'form-control']) !!}
				                    </div>
									@php $features = json_decode($item_cat->item_cat_features,true) @endphp
									<div class="form-group">
										<label for="">Màu sắc</label>
										<select name="feature[color]" class="form-control">
											<option value=""></option>
											<option value="single" {{ $features['color'] == 'single' ? 'selected' : '' }}>Single</option>
											<option value="multiple" {{ $features['color'] == 'multiple' ? 'selected' : '' }}>Multiple</option>
										</select>
									</div>
									<div class="form-group">
										<label for="">Dung tích</label>
										<select name="feature[size]" class="form-control">
											<option value=""></option>
											<option value="single" {{ $features['size'] == 'single' ? 'selected' : '' }}>Single</option>
											<option value="multiple" {{ $features['size'] == 'multiple' ? 'selected' : '' }}>Multiple</option>
										</select>
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