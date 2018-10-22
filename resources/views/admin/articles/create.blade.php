@extends('layouts.adminapp')

@section('tinymce')
	@include('include.tinymce')
@endsection

@section('content')
	<section class="content-header">
		<h1>
			Bài viết mới
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('articles.index') }}">Tất cả bài viết</a></li>
			<li class="active">Bài viết mới</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
        	{!! Form::open(['method'=>'POST', 'action'=>"AdminArticleController@store", 'class'=>'form-horizontal', 'files'=>true]) !!}
				<div class="col-md-9">
					<!-- Horizontal Form -->
					<div class="box">
		                <!-- form start -->
	                	<div class="box-body">
	                		<div class="col-md-12">
	                			<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
	                    			{!! Form::label('title', 'Tiêu đề bài viết:', ['class' => 'control-label'] ) !!}
									{!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Insert name']) !!}
		                      		@if ($errors->has('title'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('title') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
	                    			{!! Form::label('summary', 'Miêu tả ngắn:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('summary', null, ['class'=>'form-control', 'rows'=>'3']) !!}
		                      		@if ($errors->has('summary'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('summary') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
	                    			{!! Form::label('content', 'Nội dung bài viết:', ['class' => 'control-label'] ) !!}
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
									{!! Form::submit('Đăng', ['class'=>'btn btn-success pull-right']) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-body">
							<div class="col-md-12">
								<div class="form-group">
									<label>Danh mục bài viết</label>
									{!! Form::select(
										'category_id',
										$categories,
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
									<a href="{{ route('categories.index') }}" class="col-md-12 btn btn-info">Danh mục mới</a>
								</div>
							</div>
							
							<div class="col-md-12">
								<div class="form-group">
									<label>Thẻ nhãn</label>
									{!! Form::select(
										'tag_id[]',
										$tags,
										null,
										['class'=>'form-control select2-multi', 'multiple'=>'multiple']
										);
									!!}
								</div>
								<div class="form-group">
									<a href="{{ route('tags.index') }}" class="col-md-12 btn btn-info">Thẻ nhãn mới</a>
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