@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Tất cả bài viết
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Tất cả bài viết</li>
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
                @if(session('delete'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('delete') }}
                </div>
                @endif
				<div class="box">
			        <div class="box-header">
			          	<h3 class="box-title">Danh sách bài viết</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Tiêu đề</th>
								<th>Nội dung</th>
								<th>Danh mục bài viết</th>
								<th>Thẻ bài viết</th>
								<th>Ngày tạo</th>
								<th>Đăng bởi</th>
								<th></th>
		                    </tr>
		                    <tr>
		                    	@if($articles->count() > 0)
									@foreach($articles as $article)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $article->title }}</td>
											<td>{!! str_limit(strip_tags($article->content), 30) !!}</td>
											<td>{{ $article->category->name }}</td>
											<td>
												@foreach($article->tags as $tag)
													<span class="label label-info">{{ $tag->name }}</span>
												@endforeach
											</td>
											<td>{{ date("F jS, Y", strtotime($article->created_at)) }}</td>
											<td>{{ $article->admin->name }}</th>
											<td>
												<a href="{{ route('articles.edit',[$article->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit "></i> Sửa</a>
												<a href="#" data-toggle="modal" data-target="#delete" >
						                            <div class="btn btn-danger btn-sm">
						                              	<i class="fa fa-trash "></i> Xóa
						                            </div>
						                        </a>
											</td>
										</tr>
										@php
						            		$i++;
										@endphp
									@endforeach
								@else
								<td colspan="9" style="text-align:center">Chưa có bài viết nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $articles->links()!!}
		                </div>
		            </div>
		        </div>
		        <a href="{{ route('articles.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> Bài viết mới</a>
            </div>
		</div>
	</section>
	@if($articles->count() > 0)
		@foreach($articles as $article)
			<div class="example-modal">
			  	<div class="modal fade item_modal" id="delete" role="dialog">
			    	<div class="modal-dialog delete-dialog" style="">
			      		<div class="modal-content">
			        		<div class="modal-body">
			         			<h5>Xóa bài viết này?</h5>
			        		</div>
			        		<div class="modal-footer">
			        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminArticleController@destroy', $article->id], 'class'=>'form-horizontal']) !!}
			        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
									{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
		            			{!! Form::close() !!}
			        		</div>
			      		</div>
			    	</div>
			 	</div>
			</div>
		@endforeach
	@endif
@endsection
