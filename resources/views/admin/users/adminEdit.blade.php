@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			{{ $admin->name }}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('admin.me', [$admin->id]) }}">{{ $admin->name }}</a></li>
			<li class="active">Chỉnh sửa</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
	                <div class="box-header with-border">
	                  	<h3 class="box-title">Chỉnh sửa thông tin</h3>
	                </div><!-- /.box-header -->
	                <!-- form start -->
	                {!! Form::open(['method'=>'PUT', 'action'=>['AdminController@adminUpdate', $admin->id], 'class'=>'form-horizontal', 'files'=>true]) !!}
                		<div class="box-body">
                			<div class="col-md-3">
                				<div class="input-group">
								   <span class="input-group-btn">
								     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
								       <i class="fa fa-picture-o"></i> Choose
								     </a>
								   </span>
								   <input id="thumbnail" class="form-control" type="text" name="filepath">
								 </div>
								 <img id="holder" src="{{ asset($admin->photo->path)}}" style="margin-top:15px;max-height:250px;">
                			</div>
                			<div class="col-md-9">
                				<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
	                    			{!! Form::label('name', 'Name:', ['class' => 'col-sm-2 control-label'] ) !!}
			                      	<div class="col-sm-10">
										{!! Form::text('name', $admin->name, ['class'=>'form-control']) !!}
			                      		@if ($errors->has('name'))
							                <span class="help-block">
							                    <strong>{{ $errors->first('name') }}</strong>
							                </span>
							            @endif
			                      	</div>
			                    </div>
			                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
	                    			{!! Form::label('email', 'Email:', ['class' => 'col-sm-2 control-label'] ) !!}
			                      	<div class="col-sm-10">
										{!! Form::text('email', $admin->email, ['class'=>'form-control']) !!}
										@if ($errors->has('email'))
							                <span class="help-block">
							                    <strong>{{ $errors->first('email') }}</strong>
							                </span>
							            @endif
			                      	</div>
			                    </div>
			                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
	                    			{!! Form::label('password', 'Password:', ['class' => 'col-sm-2 control-label']) !!}
			                      	<div class="col-sm-10">
										{!! Form::password('password', ['class'=>'form-control']) !!}
										@if ($errors->has('password'))
							                <span class="help-block">
							                    <strong>{{ $errors->first('password') }}</strong>
							                </span>
							            @endif
			                      	</div>
			                    </div>
			                    <div class="form-group">
			                    	<div class="col-sm-10 col-sm-offset-2">
			                    		{!! Form::file('photo_id', null, ['class'=>'form-control'])!!}
			                    	</div>
			                    </div>
			                    <div class="form-group">
	                    			{!! Form::label('password_confirmation', 'Confirm Password:', ['class' => 'col-sm-2 control-label']) !!}
			                      	<div class="col-sm-10">
										{!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
			                      	</div>
			                    </div>
			                    <div class="form-group">
			                    	<div class="col-sm-12">
			                    		{!! Form::submit('Lưu thay đổi', ['class'=>'btn btn-primary pull-right']) !!}
			                    	</div>
			                    </div>
                			</div>
                  		</div><!-- /.box-body -->
                  		<div class="box-footer">
		                    
                  		</div><!-- /.box-footer -->
                	{!! Form::close() !!}
              	</div><!-- /.box -->
    		</div>
    	</div>
    </section>
@endsection

@section('extendscripts')
	<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
	<script>
		$('#lfm').filemanager('image');
	</script>
	 

@endsection