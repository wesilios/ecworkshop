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
			                    <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
	                    			{!! Form::label('content', 'Nội dung bài viết:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('content', $article->content, ['class'=>'form-control textarea']) !!}
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
	</div>
	<div class="example-modal">
	  	<div class="modal fade item_modal" id="gallery_modal" role="dialog">
	    	<div class="modal-dialog modal-dialog-95" style="border-top:5px solid #0097bc; border-radius:4px">
	      		<div class="modal-content">
	          		<div class="modal-header">
	            		<div>
	            			<span>Media Gallery</span>
	              			<div class="pull-right">
	                			<button type="button" class="btn-custom btn-default" data-dismiss="modal">
	                				<i class="fa fa-close"></i>
	                			</button>
	              			</div>
	            		</div>
	          		</div>
	          		<div class="modal-body">
	            		<div class="row">
	            			<div style="min-height:600px; width:100%">
	                			<div class="nav-tabs-custom" style="height:100%">
					                <ul class="nav nav-tabs">
					                  	<li><a href="#tab_1" data-toggle="tab">Upload</a></li>
					                  	<li class="active"><a href="#tab_2" data-toggle="tab">Media gallery</a></li>
					                  	<li class="pull-right"></li>
					                </ul>
					                <div class="tab-content">
					                  	<div class="tab-pane" id="tab_1">
				                			<div class="uploadZone">
							        			<div class="fileSelectZone">
								        			<div class="upload-ui">
								        				<h2>Drop files anywhere to upload</h2>
														<p>or</p>
														<button class="btn btn-default selectFile">Select Files</button>
								        			</div>
								        		</div>
							        		</div>
							        		<div class="box box-hidden">
												<div class="box-body">
													<div class="form-hidden">
									    				{!! Form::open(['method'=>'PUT', 'action'=>["AdminArticleController@uploadImage",$article->id] ,'files'=>true]) !!}
															{!! Form::file('medias', ['id'=>'form-file-hidden']) !!}
															<div class="form-group">
																<button class="btn btn-default selectFile">Select files</button>
																{!! Form::submit('Upload', ['class'=>'btn btn-info']) !!}
															</div>
										    			{!! Form::close() !!}
									    			</div>
									    			<div id="preview-image">

									    			</div>
												</div>
											</div>
							        	</div>
							        	<div class="tab-pane active" id="tab_2" style="overflow:scroll;">
							        		<div class="col-sm-12" >
		                						<div class="modalDisplayImages">
								        			@foreach($medias as $media)
													<div class="col-sm-2">
														<div class="thumbnails_img" style="background-image:url('{{ asset($media->url) }}')">
															<div class="caption">
																<div class="caption-content">
																	<a href="#" id="{{ $media->id }}" class="selectImgA">
											                            <div class="btn btn-info">
											                              	<i class="fa fa-save"></i>
											                            </div>
											                        </a>
																</div>
															</div>
														</div>
													</div>
													<div class="form-hidden-article">
									    				{!! Form::open(['method'=>'PUT', 'action'=>["AdminArticleController@selectImage",$article->id] ,'files'=>true]) !!}
															{!! Form::text('media_id', $media->id ,['id'=>'form-file-hidden']) !!}
															<div class="form-group">
																{!! Form::submit('Select', ['class'=>'btn btn-info','id'=>'selectImgbtn'.$media->id]) !!}
															</div>
										    			{!! Form::close() !!}
									    			</div>
													@endforeach
								        		</div>
		            						</div>
							        	</div>
							        </div>
							    </div>
	              			</div>
	        			</div>
	        		</div>
	      		</div><!-- /.modal-content -->
	    	</div><!-- /.modal -->
	  	</div>
	</div><!-- /.example-modal -->
@endsection

@section('extendscripts')
	<script>
		$('.select2-multi').select2();
		$('.select2-multi').select2().val({!! json_encode($tag_value) !!}).trigger('change');
	</script>
@endsection