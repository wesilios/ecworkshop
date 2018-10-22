@extends('layouts.adminlogin')

@section('content')
	<div class="login-box">
      	<div class="login-logo">
        	<b>Admin</b> EC Workshop
      	</div><!-- /.login-logo -->
      	@if(session('logout'))
      	<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-info"></i> Alert!</h4>
			{{ session('logout') }}
		</div>
		@endif
      	<div class="login-box-body">
        	<p class="login-box-msg">Sign in to start your session</p>
        	<form action="{{ route('admin.login.submit') }}" method="post">
        		{{ csrf_field() }}

          		<div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            		<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
            		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	         	</div>

	          	<div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
	            	<input type="password" class="form-control" placeholder="Password" name="password" required>
	            	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	          	</div>

	          	<div class="row">
	            	<div class="col-xs-8">
	              		<div class="checkbox icheck">
		                	<label>
		                  		<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 
		                  		Remember Me
		                	</label>
	              		</div>
	            	</div><!-- /.col -->
		            <div class="col-xs-4">
		              	<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
		            </div><!-- /.col -->
	          	</div>
	        </form>

	        <a href="#">I forgot my password</a><br>

      	</div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

@endsection