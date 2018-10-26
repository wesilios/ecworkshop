@extends('layouts.adminapp')
@section('content')
	<section class="content-header">
		<h1>
			Website settings
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>Settings</li>
			<li class="active">Edit</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
            <div class="col-md-12">
            	@if(session('settings'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('settings') }}
                </div>
                @endif
            	{!! Form::open(['method'=>'PUT', 'action'=>['AdminSettingsController@update', $settings->id], 'class'=>'form-horizontal']) !!}
            		<div class="nav-tabs-custom">

		                <ul class="nav nav-tabs">
		                  	<li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
		                  	<li><a href="#tab_2" data-toggle="tab">Social media</a></li>
		                  	<li><a href="#tab_3" data-toggle="tab">Google Id and webmaster</a></li>
		                  	<li class="pull-right"></li>
		                </ul>
		                <div class="tab-content">
		                  	<div class="tab-pane active" id="tab_1">
		                    	{!! Form::label('address', 'Địa chỉ:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('address') ? ' has-error' : '' }}">
	                    			{!! Form::text('address', $settings->address, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-home"></i></span>
		                      		@if ($errors->has('address'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('address') }}</strong>
						                </span>
						            @endif
	                  			</div>
	                  			{!! Form::label('phone', 'Điện thoại:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('phone') ? ' has-error' : '' }}">
	                    			{!! Form::text('phone', $settings->phone, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
		                      		@if ($errors->has('phone'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('phone') }}</strong>
						                </span>
						            @endif
	                  			</div>
	                  			{!! Form::label('work_hour', 'Giờ làm việc:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('work_hour') ? ' has-error' : '' }}">
	                    			{!! Form::text('work_hour', $settings->work_hour, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
		                      		@if ($errors->has('work_hour'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('work_hour') }}</strong>
						                </span>
						            @endif
	                  			</div>
	                  			{!! Form::label('email', 'Email:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('email') ? ' has-error' : '' }}">
	                    			{!! Form::text('email', $settings->email, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
		                      		@if ($errors->has('email'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('email') }}</strong>
						                </span>
						            @endif
	                  			</div>
		                  	</div><!-- /.tab-pane -->
		                  	<div class="tab-pane" id="tab_2">
			                    {!! Form::label('facebook', 'Facebook:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('facebook') ? ' has-error' : '' }}">
	                    			{!! Form::text('facebook', $settings->facebook, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-facebook-square"></i></span>
		                      		@if ($errors->has('facebook'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('facebook') }}</strong>
						                </span>
						            @endif
	                  			</div>
	                  			{!! Form::label('youtube', 'Youtube:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('youtube') ? ' has-error' : '' }}">
	                    			{!! Form::text('youtube', $settings->youtube, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-youtube"></i></span>
		                      		@if ($errors->has('youtube'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('youtube') }}</strong>
						                </span>
						            @endif
	                  			</div>
	                  			{!! Form::label('instagram', 'Instagram:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('instagram') ? ' has-error' : '' }}">
	                    			{!! Form::text('instagram', $settings->instagram, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-instagram"></i></span>
		                      		@if ($errors->has('instagram'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('instagram') }}</strong>
						                </span>
						            @endif
	                  			</div>
		                  	</div><!-- /.tab-pane -->
		                  	<div class="tab-pane" id="tab_3">
		                  		{!! Form::label('keywords', 'Seo Keyword:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('keywords') ? ' has-error' : '' }}">
	                    			{!! Form::text('keywords', $settings->keywords, ['class'=>'form-control', 'data-role'=>'tagsinput']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-chrome"></i></span>
		                      		@if ($errors->has('keywords'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('keywords') }}</strong>
						                </span>
						            @endif
	                  			</div>
	                  			<code>Hit Enter or "," to seperate keywords</code><br>
			                    {!! Form::label('google_id', 'Google ID:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('google_id') ? ' has-error' : '' }}">
	                    			{!! Form::text('google_id', $settings->google_id, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-google"></i></span>
		                      		@if ($errors->has('google_id'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('google_id') }}</strong>
						                </span>
						            @endif
	                  			</div>
	                  			{!! Form::label('webmaster', 'Webmaster:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('webmaster') ? ' has-error' : '' }}">
	                    			{!! Form::text('webmaster', $settings->webmaster, ['class'=>'form-control']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-odnoklassniki-square"></i></span>
		                      		@if ($errors->has('webmaster'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('webmaster') }}</strong>
						                </span>
						            @endif
	                  			</div>
	                  			{!! Form::label('description', 'Meta Description:', ['class' => 'control-label'] ) !!}
			                	<div class="input-group {{ $errors->has('description') ? ' has-error' : '' }}">
	                    			{!! Form::textarea('description', $settings->description, ['class'=>'form-control', 'data-role'=>'tagsinput', 'rows'=>'5']) !!}
	                    			<span class="input-group-addon"><i class="fa fa-globe"></i></span>
		                      		@if ($errors->has('description'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('description') }}</strong>
						                </span>
						            @endif
	                  			</div>
		                  	</div><!-- /.tab-pane -->

		                </div><!-- /.tab-content -->
		            </div><!-- nav-tabs-custom -->
		            {!! Form::submit('Lưu thay đổi', ['class'=>'btn btn-info text-muted']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@endsection

@section('extendscripts')

@endsection