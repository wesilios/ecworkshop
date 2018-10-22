@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Chỉnh sửa thông tin
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('users.index') }}"><i class="fa fa-dashboard"></i> Tất cả tài khoản</a></li>
			<li><a href="{{ route('users.show', [$admin->id]) }}">{{ $admin->name }}</a></li>
			<li class="active">Chỉnh sửa</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
        	<div class="col-md-12">
        		@if(session('edit'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('edit') }}
                </div>
                @endif
				<!-- Horizontal Form -->
				<div class="box box-info">
	                <div class="box-header with-border">
	                  	<h3 class="box-title"></h3>
	                </div><!-- /.box-header -->
	                <!-- form start -->
	                {!! Form::open(['method'=>'PUT', 'action'=>['AdminUsersController@update', $admin->id], 'class'=>'form-horizontal', 'files'=>true]) !!}
                		<div class="box-body">
                			<div class="col-md-3">
                				<img src="{{ asset($admin->photo->path)}}" class="image-responsive profile-avatar">
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
	                    			{!! Form::label('password_confirmation', 'Confirm Password:', ['class' => 'col-sm-2 control-label']) !!}
			                      	<div class="col-sm-10">
										{!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
			                      	</div>
			                    </div>
			                    <div class="form-group">
			                    	<div class="col-sm-10 col-sm-offset-2">
			                    		{!! Form::file('photo_id', null, ['class'=>'form-control'])!!}
			                    	</div>
			                    </div>
			                    <div class="form-group {{ $errors->has('role_id') ? ' has-error' : '' }}">
			                    	{!! Form::label('role_id', 'Role:', ['class' => 'col-sm-2 control-label']) !!}
			                    	<div class="col-sm-10">
										{!! Form::select(
											'role_id', 
											$roles, 
											$admin->role_id,
											['class'=>'form-control']
											); 
										!!}
										@if ($errors->has('role_id'))
							                <span class="help-block">
							                    <strong>{{ $errors->first('role_id') }}</strong>
							                </span>
							            @endif
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
	<script>
		//Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        	function (start, end) {
        		$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        	}
        );
	</script>
@endsection