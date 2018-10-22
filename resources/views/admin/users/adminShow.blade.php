@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			{{ $admin->name }}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">{{ $admin->name }}</li>
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
        	</div>
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box">
	                <div class="box-header with-border">
	                  	<h3 class="box-title">Thông tin tài khoản</h3>
	                </div><!-- /.box-header -->
	                <div class="box-body">
						<div class="col-md-2">
							<img src="{{ asset($admin->photo->path) }}" class="img-responsive profile-avatar">
						</div>
						<div class="col-md-10 table-responsive no-padding">
							<table class="table table-hover">
	          					<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									<th>Created</th>
									<th>Updated</th>
			                    </tr>
			                    <tr>
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
			                    	<td>{{ $admin->updated_at->diffForHumans()}}</td>
			                    </tr>
			                    <tr>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									<th>Created</th>
									<th>Updated</th>
			                    </tr>
			                </table>
			                <a href="{{ route('admin.me.edit', [$admin->id]) }}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-edit"></i> Chỉnh sửa</a>
						</div>
	                </div>
	                <div class="box-footer">
						
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6">
	        	<div class="box box-solid">
	                <div class="box-header with-border">
	                	<i class="fa fa-file-text"></i>
	                  	<h3 class="box-title">Bài viết <small>đăng bởi {{ $admin->name }}</small></h3>
	                </div><!-- /.box-header -->
	                <div class="box-body">
						<div class="col-sm-12 table-responsive no-padding">
							<table class="table table-hover">
	          					<tr>
									<th>Tiêu đề</th>
									<th>Danh mục bài viết</th>
									<th>Thẻ bài viết</th>
									<th>Ngày đăng</th>
			                    </tr>
			                    @if($articles->count() > 0)
									@foreach($articles as $article)
					                    <tr>
					                    	<td>{{ $article->title }}</td>
					                    	<td>{{ $article->category->name }}</td>
					                    	<td>
												@foreach($article->tags as $tag)
													<span class="label label-info">{{ $tag->name }}</span>
												@endforeach
											</td>
											<td>{{ date("F jS, Y", strtotime($article->created_at)) }}</td>
					                    </tr>
					                @endforeach
					            @else
									<td colspan="4" style="text-align:center">Chưa có bài viết nào được tạo từ tài khoản này!</td>
					            @endif
			                </table>
						</div>
	                </div>
	                <div class="box-footer">
	                	
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6">
	        	<div class="box box-solid">
	                <div class="box-header with-border">
	                	<i class="fa fa-bookmark"></i>
	                  	<h3 class="box-title">Sản phẩm <small>tạo bởi {{ $admin->name }}</small></h3>
	                </div><!-- /.box-header -->
	                <div class="box-body">
						<div class="col-sm-12 table-responsive no-padding">
							<table class="table table-hover">
	          					<tr>
									<th>Tên sản phẩm</th>
									<th>Ngày tạo</th>
									<th>Giá</th>
			                    </tr>
			                    @if($items->count() > 0)
									@foreach($items as $item)
					                    <tr>
					                    	<td>{{ $item->name }}</td>
					                    	<td>{{ $item->created_at->diffForHumans() }}</td>
					                    	<td>{{ number_format($item->price,0, ",",".") }} đ</td>
					                    </tr>
					                @endforeach
					            @else
									<td colspan="3" style="text-align:center">Chưa có sản phẩm nào được tạo từ tài khoản này!</td>
					            @endif
			                </table>
						</div>
	                </div>
	                <div class="box-footer">
	                	
	                </div>
	            </div>
	        </div>
        </div>
    </section>
@endsection