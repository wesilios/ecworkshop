@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Tất cả tài khoản quản trị
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Tất cả tài khoản</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
         <div class="row">
            <div class="col-xs-12">
            	@php
            		$i = 1;
				@endphp
            	@if(session('status'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('status') }}
                </div>
                @endif
				<div class="box">
			        <div class="box-header">
			          	<h3 class="box-title">Danh sách quản trị viên</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Created</th>
								<th>Updated</th>
								<th>Action</th>
		                    </tr>
	                    	@if($admins)
	                    		@foreach($admins as $admin)
			                    	<tr>
	                  					<td>{{ $i }}</td>
										<td>{{ $admin->name }}</td>
										<td>{{ $admin->email }}</td>
										<td>
											@switch($admin->role_id)
												@case(1)
													<span class="label label-primary">{{ $admin->role->name }}</span>
													@break
												@case(2)
													<span class="label label-success">{{ $admin->role->name }}</span>
													@break
												@case(3)
													<span class="label label-info">{{ $admin->role->name }}</span>
													@break
												@default
													<span class="label label-danger">Tài khoản chưa có role</span>
													@break
											@endswitch
										</td>
										<td>{{ $admin->created_at->diffForHumans() }}</td>
										<td>{{ $admin->updated_at->diffForHumans() }}</td>
										<td>
											<div class="show_item">
												<a class="btn btn-info btn-sm" href="{{ route('users.show', [$admin->id]) }}">
												  <i class="fa fa-eye"></i> Show profile
												</a>
											</div>
										</td>
			                    	</tr>
			                    	@php 
										$i++
			                    	@endphp
	                    		@endforeach
	                    	@endif
	                    	<tr>
	                    		<th>#Id</th>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Created</th>
								<th>Updated</th>
								<th>Action</th>
	                    	</tr>
		                </table>
	        		</div><!-- /.box-body -->
	      		</div><!-- /.box -->
	      		<a href="{{ route('users.create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Tài khoản mới</a>
	      		<!--<div class="box">
	                <div class="box-header">
	                  	<h3 class="box-title">Data Table With Full Features</h3>
	                </div>
	                <div class="box-body">
	                  	<table id="example1" class="table table-bordered table-striped">
	                    	<thead>
	                      		<tr>
			                        <th>#Id</th>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									<th>Created</th>
									<th>Updated</th>
	                      		</tr>
	                    	</thead>
	                    	<tbody>
	                      		<tr>
								@if($admins)
		                    		@foreach($admins as $admin)
				                    	<tr>
		                  					<td>{{ $admin->id }}</td>
											<td>{{ $admin->name }}</td>
											<td>{{ $admin->email }}</td>
											<td>
												@if($admin->role_id == 1)
												<span class="label label-success">{{ $admin->role->name }}</span>
												@else
												<span class="label label-info">{{ $admin->role->name }}</span>
												@endif
											</td>
											<td>{{ $admin->created_at->diffForHumans() }}</td>
											<td>{{ $admin->updated_at->diffForHumans() }}</td>
				                    	</tr>
		                    		@endforeach
		                    	@endif
	                      		</tr>
	                    	</tbody>
							<tfoot>
								<tr>
			                        <th>#Id</th>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									<th>Created</th>
									<th>Updated</th>
	                      		</tr>
							</tfoot>
						</table>
					</div>
				</div>-->
	    	</div><!-- /.col -->
	  	</div><!-- /.row -->
	</section><!-- /.content -->
@endsection

@section('extendscripts')
	<script>
		
		$("#example1").DataTable();
		
    </script>

@endsection