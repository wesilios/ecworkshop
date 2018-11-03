@extends('layouts.adminapp')

@section('tinymce')
	@include('include.tinymce')
@endsection

@section('content')
	<section class="content-header">
		<h1>
			{{ $article->title }}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('articles.index') }}">Tất cả bài viết</a></li>
			<li class="active">Bài viết mới</li>
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
        	{!! Form::open(['method'=>'PUT', 'action'=>['AdminArticleController@update', $article->id], 'class'=>'form-horizontal', 'files'=>true]) !!}
				<div class="col-md-9">
					<!-- Horizontal Form -->
					<div class="box">
		                <!-- form start -->
	                	<div class="box-body">
	                		<div class="col-md-12">
	                			<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
	                    			{!! Form::label('title', 'Tiêu đề bài viết:', ['class' => 'control-label'] ) !!}
									{!! Form::text('title', $article->title, ['class'=>'form-control', 'placeholder'=>'Insert name']) !!}
		                      		@if ($errors->has('title'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('title') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group">
			                    	{!! Form::label('slug', 'Link bài viết:', ['class' => 'control-label'] ) !!}
			                    	<div class="input-group">
					                    <span class="input-group-addon">{{ route('article.index') }}/</span>
					                    <input type="text" class="form-control" value='{{ $article->slug }}' readonly>
					                </div>
			                    </div>
			                    <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
	                    			{!! Form::label('summary', 'Miêu tả ngắn:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('summary', $article->summary, ['class'=>'form-control','rows'=>'3']) !!}
		                      		@if ($errors->has('summary'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('summary') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('content_ar') ? ' has-error' : '' }}">
	                    			{!! Form::label('content_ar', 'Nội dung bài viết:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('content_ar', $article->content, ['class'=>'form-control textarea']) !!}
		                      		@if ($errors->has('content_ar'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('content_ar') }}</strong>
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
							<div><strong>Ngày đăng:</strong>  {{ date("F jS, Y", strtotime($article->created_at)) }}</div>
							<div><strong>Ngày cập nhật:</strong>  {{ date("F jS, Y", strtotime($article->updated_at)) }}</div>
							<div><strong>Đăng bởi:</strong>  {{ $article->admin->name }}</div>
						</div>
						<div class="box-footer">
							<div class="col-md-12">
								<div class="form-group">
									<a href="#" data-toggle="modal" data-target="#delete" >
			                            <div class="btn btn-danger pull-right"  style="margin-left:3px">
			                              	<i class="fa fa-trash "></i>
			                            </div>
			                        </a>
									{!! Form::submit('Cập nhật', ['class'=>'btn btn-success pull-right']) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-body">
							@if($article->media->isNotEmpty())
								@foreach($article->media as $media)
									<img src="{{ asset($media->url) }}" class="image-responsive">
								@endforeach
							@else
								<img src="http://placehold.it/1200x600/39CCCC/ffffff" class="image-responsive profile-avatar">
							@endif
							<a href="#" data-toggle="modal" data-target="#gallery_modal" >
	                            <div class="btn btn-primary btn-block">
	                              	Set feature image
	                            </div>
	                        </a>
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
										$article->category_id,
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
									<a href="{{ route('categories.index') }}" class="col-md-12 btn btn-info">Thẻ nhãn mới</a>
								</div>
							</div>

						</div>
					</div>
				</div>
			{!! Form::close()!!}

		</div>
	</section>
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
	</div><!-- /delete.example-modal -->
	@include('admin.articles.include.media')
@endsection

@section('extendscripts')
	<script>
		$('.select2-multi').select2();
		$('.select2-multi').select2().val({!! json_encode($tag_value) !!}).trigger('change');
        $('#new_folder').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var token = $("input[name='_token']").val();
            var folder_name = $("input[name='folder_name']").val();
            var folder_id = $("input[name='folder_id']").val();
            if(folder_name == '') {
                alert('Trống tên');
            } else {
                $.ajax({
                    url: "{{ route('admin.folder.create') }}",
                    method:'POST',
                    dataType:'json',
                    data: {folder_name:folder_name, _token:token, folder_id:folder_id},
                    success: function(data) {
                        if(data.error) {
                            $('#newFolder .error').html(data.mess);
                        } else {
                            $('#folder-section').html('');
                            $('#folder-section').html(data.option);
                            $('#newFolder').modal('hide');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(xhr.responseText);
                        console.log(thrownError);
                    }
                });
            }
        });

        $('.folder-link').click(function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            if($(this).attr('data-active') == 1) {
                $(this).attr('data-active',0);
            } else {
                $(this).attr('data-active',1);
            }
        });

		function getFolderByAjax(folder_slug, folder_id, token, article_id) {
            $.ajax({
                url: "{{ route('admin.folder.ajax.show') }}",
                method: 'POST',
                dataType: 'json',
                data: {folder_slug:folder_slug, folder_id:folder_id, _token:token, article_id:article_id},
                success: function (data) {
                    if(data.error) {
                        alert(data.mess);
                    } else {
                        console.log(data.option);
                        $('#modal-medias').html(data.option);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(xhr.responseText);
                    console.log(thrownError);
                }
            });
		};

        $('.folder-link').dblclick(function(e){
            var href = $(this).attr('href');
            var article_id = '{{ $article->id }}';
            var token = $("input[name='_token']").val();
            alert(token);
            var folder_slug = $(this).attr('data-folder-slug');
            var folder_id = $(this).attr('data-folder-id');
            if(folder_id == null || folder_slug == null) {
                alert('Cant get this folder');
            } else {
				getFolderByAjax(folder_slug, folder_id, token, article_id);
            }
        });

	</script>
@endsection