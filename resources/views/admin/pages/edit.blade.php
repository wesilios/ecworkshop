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
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('pages.index') }}">All pages</a></li>
			<li><a href="#">{{ $page->name}}</a></li>
			<li class="active">Edit</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
        	<div class="col-md-12">
        		@if(session('status'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('status') }}
                </div>
                @endif
                @if(session('error'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('error') }}
                </div>
                @endif
        	</div>
        	{!! Form::open(['method'=>'PUT', 'action'=>['AdminPagesController@update', $page->id], 'class'=>'form-horizontal', 'files'=>true]) !!}
				<div class="col-md-9">
					<!-- Horizontal Form -->
					<div class="box">
		                <!-- form start -->
	                	<div class="box-body">
	                		<div class="col-md-12">
	                			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
	                    			{!! Form::label('name', 'Tên trang:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name',  $page->name, ['class'=>'form-control', 'placeholder'=>'Insert name']) !!}
		                      		@if ($errors->has('name'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('name') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
	                    			{!! Form::label('description', 'Trang description:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('description',  $page->description, ['class'=>'form-control', 'rows'=>'3']) !!}
		                      		@if ($errors->has('description'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('description') }}</strong>
						                </span>
						            @endif
			                    </div>

			                    <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
	                    			{!! Form::label('content', 'Nội dung chi tiết:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('content', $page->content, ['class'=>'form-control textarea']) !!}
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
							<div><strong>Ngày đăng:</strong>  {{ $page->created_at }}</div>
							<div><strong>Ngày cập nhật:</strong>  {{ $page->updated_at }}</div>
							<div><strong>Đăng bởi:</strong>  {{ Auth::user()->name }}</div>
						</div>
						<div class="box-footer">
							<div class="col-md-12">
								<div class="form-group">
									<label>Trang cha</label>
									{!! Form::select(
										'page_id',
										$pages,
										$page->page_id,
										['class'=>'form-control select2-multi', 'placeholder'=>'-- Chọn trang cha --']
										);
									!!}
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::submit('Lưu chỉnh sửa', ['class'=>'btn btn-success btn-block']) !!}
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