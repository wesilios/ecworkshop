@extends('layouts.adminapp')

@section('tinymce')
	@include('include.tinymce')
@endsection

@section('content')
	<section class="content-header">
		<h1>
			Trang mới
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('pages.index') }}">All pages</a></li>
			<li class="active">New page</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
        	{!! Form::open(['method'=>'POST', 'action'=>"AdminPagesController@store", 'class'=>'form-horizontal', 'files'=>true]) !!}
				<div class="col-md-9">
					<!-- Horizontal Form -->
					<div class="box">
		                <!-- form start -->
	                	<div class="box-body">
	                		<div class="col-md-12">
	                			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
	                    			{!! Form::label('name', 'Tên trang:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Insert name']) !!}
		                      		@if ($errors->has('name'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('name') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
	                    			{!! Form::label('description', 'Trang description:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('description', null, ['class'=>'form-control', 'rows'=>'3']) !!}
		                      		@if ($errors->has('description'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('description') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
	                    			{!! Form::label('content', 'Nội dung chi tiết:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('content', null, ['class'=>'form-control textarea']) !!}
		                      		@if ($errors->has('content'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('content') }}</strong>
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
									<label>Trang cha</label>
									{!! Form::select(
										'page_id',
										$pages,
										null,
										['class'=>'form-control select2-multi', 'placeholder'=>'-- Chọn trang cha --']
										);
									!!}
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::submit('Đăng', ['class'=>'btn btn-success btn-block']) !!}
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
	</script>
@endsection