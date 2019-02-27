@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			{{ $menu->name }}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('admin.menus.index') }}"> All menus</a></li>
			<li> {{ $menu->name }}</li>
			<li class="active">Menus</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
			<div class="col-md-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Thêm trang vào menu</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							{!! Form::open(['method'=>'POST', 'action'=>["AdminMenusController@addPage", $menu->id], 'class'=>'form-horizontal']) !!}
								<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
		                			{!! Form::label('name', 'Thêm trang vào menu:', ['class' => 'control-label'] ) !!}
									{!! Form::select(
										'page_id',
										$pages,
										null,
										['class'=>'form-control']
										);
									!!}
									@if ($errors->has('category_id'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('category_id') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group">
			                    	{!! Form::submit('Thêm vào menu', ['class'=>'col-md-12 btn btn-primary']) !!}
			                    </div>
			                {!! Form::close()!!}
						</div>
						<div class="col-md-12">
							<form action="{{ route('admin.menus.addpage',['id'=>$menu->id]) }}" method="post" class="form-horizontal">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="">Thêm loại sản phẩm vào menu</label>
									<select name="item_cat_id" id="" class="form-control">
										<option value=""></option>
										@if($item_parent->isNotEmpty())
											@foreach($item_parent as $key => $val)
												@if($val->id == $val->item_category_id)
												<option value="{{ $val->id }}">{{ $val->name }}</option>
												@endif
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group">
									<input type="submit" value="Thêm vào menu" class="col-md-12 btn btn-primary">
								</div>
							</form>
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
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Danh sách trang</h3>
					</div>
					<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>Tên menu</th>
								<th style="width:35%">Danh sách trang con</th>
								<th style="width:15%">Thứ tự</th>
								<th>Action</th>
								<th>Ngày cập nhật</th>
		                    </tr>
		                    <tr>
		                    	@if($menu->menu_details->count() > 0)
									@foreach($menu->menu_details()->orderBy('order_no')->get() as $page)
										@if($page->type == 'page')
											<tr>
												{!! Form::open(['method'=>'PUT', 'action'=>['AdminMenusController@savePageOrder', $menu->id, $page->id], 'class'=>'form-horizontal']) !!}
												<td>{{ $page->getPage->name }}</td>
												<td>
													<select class="form-control" name='order_id'>
														@if($page->getPage->pageChildren->isNotEmpty())
															@foreach($page->getPage->pageChildren as $pageChild)
																<option value="{{ $pageChild->id }}">{{ $pageChild->name }}</option>
															@endforeach
														@else
															<option value="0">-- Không có trang con --</option>
														@endif
													</select>
												</td>
												<td>
													<input type="number" class="form-control" value="{{ $page->order_no }}" name="pageOrder" min="1" max="{{ $page->count()}}">
												</td>
												<td>
													<button class="btn btn-info btn-sm" type="submit"><i class="fa fa-save"></i></button>
													<a href="#" data-toggle="modal" data-target="#delete{{ $page->id }}">
														<div class="btn btn-danger btn-sm">
															<i class="fa fa-trash "></i>
														</div>
													</a>
												</td>
												<td>{{ $page->updated_at->diffForHumans() }}</td>
												{!! Form::close() !!}
											</tr>
										@else
											<tr>
												{!! Form::open(['method'=>'PUT', 'action'=>['AdminMenusController@savePageOrder', $menu->id, $page->id], 'class'=>'form-horizontal']) !!}
												<td>{{ $page->getItemCat->name }}</td>
												<td>
													<select class="form-control" name='order_id'>
														@if($page->getItemCat->itemCategories->isNotEmpty() && $page->getItemCat->itemCategories->count()>1)
															@foreach($page->getItemCat->itemCategories as $pageChild)
                                                                @if($pageChild->id != $pageChild->item_category_id)
																<option value="{{ $pageChild->id }}">{{ $pageChild->name }}</option>
                                                                @endif
															@endforeach
														@else
															<option value="0">-- Không có trang con --</option>
														@endif
													</select>
												</td>
												<td>
													<input type="number" class="form-control" value="{{ $page->order_no }}" name="pageOrder" min="1" max="{{$page->count()}}">
												</td>
												<td>
													<button class="btn btn-info btn-sm" type="submite"><i class="fa fa-save"></i></button>

													<a href="#" data-toggle="modal" data-target="#delete{{ $page->id }}">
														<div class="btn btn-danger btn-sm">
															<i class="fa fa-trash "></i>
														</div>
													</a>
												</td>
												<td>{{ $page->updated_at->diffForHumans() }}</td>
												{!! Form::close() !!}
											</tr>
										@endif
									@endforeach
								@else
								<td colspan="5" style="text-align:center">Chưa có trang nào trong menu này</td>
		                    	@endif
		                    </tr>
		                </table>
		            </div>
				</div>
			</div>
       	</div>
    </section>
	@if($menu->menu_details->count() > 0)
		@foreach($menu->menu_details()->orderBy('order_no')->get() as $page)
			<div class="example-modal">
				<div class="modal fade item_modal" id="delete{{ $page->id }}" role="dialog">
					<div class="modal-dialog delete-dialog" style="">
						<div class="modal-content">
							<div class="modal-body">
								<h5>Xóa menu này?</h5>
							</div>
							<div class="modal-footer">
								{!! Form::open(['method'=>'DELETE', 'action'=>['AdminMenusController@destroyPage', $menu->id, $page->id], 'class'=>'form-horizontal']) !!}
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
	<script>
		$('.select2-multi').select2();
	</script>
@endsection