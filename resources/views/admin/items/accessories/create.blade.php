@extends('layouts.adminapp')

@section('tinymce')
	@include('include.tinymce')
@endsection

@section('content')
	<section class="content-header">
		<h1>
			Phụ kiện mới
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('accessories.index') }}">Tất cả phụ kiện</a></li>
			<li class="active">Phụ kiện mới</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
        	{!! Form::open(['method'=>'POST', 'action'=>"AdminAccessoriesController@store", 'class'=>'form-horizontal', 'files'=>true]) !!}
				<div class="col-md-9">
					<!-- Horizontal Form -->
					<div class="box">
		                <!-- form start -->
	                	<div class="box-body">
	                		<div class="col-md-12">
	                			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
	                    			{!! Form::label('name', 'Tên sản phẩm:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Insert name']) !!}
		                      		@if ($errors->has('name'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('name') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
	                    			{!! Form::label('price', 'Giá gốc:', ['class' => 'control-label'] ) !!}
									{!! Form::number('price', null, ['class'=>'form-control', 'placeholder'=>'Insert price']) !!}
		                      		@if ($errors->has('price'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('price') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('price_off') ? ' has-error' : '' }}">
	                    			{!! Form::label('price_off', 'Giá giảm:', ['class' => 'control-label'] ) !!}
									{!! Form::number('price_off', null, ['class'=>'form-control', 'placeholder'=>'']) !!}
		                      		@if ($errors->has('price_off'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('price_off') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
	                    			{!! Form::label('summary', 'Tóm tắt sản phẩm:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('summary', null, ['class'=>'form-control', 'rows'=>'3']) !!}
		                      		@if ($errors->has('summary'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('summary') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
	                    			{!! Form::label('description', 'Miêu tả sản phẩm:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('description', null, ['class'=>'form-control textarea']) !!}
		                      		@if ($errors->has('description'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('description') }}</strong>
						                </span>
						            @endif
			                    </div>
	                		</div>
			            </div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="box">
						<div class="box-body">
							<div><strong>Ngày đăng:</strong>  N/A</div>
							<div><strong>Ngày cập nhật:</strong>  N/A</div>
							<div><strong>Đăng bởi:</strong>  {{ Auth::user()->name }}</div>
						</div>
						<div class="box-footer">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::submit('Đăng', ['class'=>'btn btn-success pull-right']) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-body">
							<div class="col-md-12">
								<div class="form-group">
									<div class="checkbox">
					                    <label class="control-label">
					                      	<input type="checkbox" class="minimal" checked name="homepage_active">
					                      	Hiển thị trang chủ
					                    </label>

									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>Hãng sản phẩm</label>
									{!! Form::select(
										'brand_id',
										$brands,
										null,
										['class'=>'form-control select2-single']
										);
									!!}
									@if ($errors->has('category_id'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('category_id') }}</strong>
						                </span>
						            @endif
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>Loại phụ kiện</label>
									{!! Form::select(
										'accessory_category_id',
										$accessory_cats,
										null,
										['class'=>'form-control select2-multi']
										);
									!!}
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>Tình trạng</label>
									{!! Form::select(
										'item_status_id',
										$statuses,
										null,
										['class'=>'form-control select2-multi']
										);
									!!}
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<a href="" class="custom-link" data-label="Hãng mới" data-type="brn"><strong>+ Hãng mới</strong></a>
								</div>
								<div class="form-group">
									<div class="alert alert-info alert-dismissable" style="display:none">
					                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
					                    Thêm thành công
					                </div>
								</div>
								<div class="form-group target-form" style="display:none">
									<label class="tagert-label"></label>
									<input type="hidden" id="target-type"/>
									<input type="text" id="main-info" class="form-control"/>
								</div>
								<div class="form-group target-form" style="display:none">
									<button id="main-submit" class="btn btn-sm btn-info pull-right" value="" disabled> Thêm mới</button>
								</div>
							</div>

						</div>
					</div>
				</div>
			{!! Form::close()!!}

		</div>
	</section>
@endsection

@section('extendscripts')
	<script>
		$('.select2-multi').select2();
		$('.select2-single').select2();
	</script>
	@component('components.ajax_post')

    @endcomponent
@endsection