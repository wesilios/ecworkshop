@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Danh mục bài viết
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('articles.index') }}">Tất cả bài viết</a></li>
			<li class="active">Danh mục bài viết</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
			<div class="col-md-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tạo danh mục mới</h3>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							{!! Form::open(['method'=>'POST', 'action'=>"AdminCategoriesController@store", 'class'=>'form-horizontal']) !!}
								<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
		                			{!! Form::label('name', 'Tên danh mục bài viết:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name', null, ['class'=>'form-control']) !!}
		                      		@if ($errors->has('name'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('name') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group">
			                    	{!! Form::submit('Lưu', ['class'=>'col-md-12 btn btn-primary']) !!}
			                    </div>
			                {!! Form::close()!!}
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				@if(session('status'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('status') }}
                </div>
                @endif
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tất cả danh mục đang có</h3>
					</div>
					<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Tên danh mục</th>
								<th>Ngày tạo</th>
								<th>Ngày cập nhật</th>
		                    </tr>
		                    <tr>
		                    	@if($categories->count() > 0)
									@foreach($categories as $category)
										<tr>
											<td>{{ $category->id }}</td>
											<td>{{ $category->name }}</td>
											<td>{{ $category->created_at->diffForHumans() }}</td>
											<td>{{ $category->updated_at->diffForHumans() }}</td>
										</tr>
									@endforeach
								@else
								<td colspan="4" style="text-align:center">Chưa có danh mục nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $categories->links()!!}
		                </div>
		            </div>
				</div>
			</div>
       	</div>
    </section>
@endsection