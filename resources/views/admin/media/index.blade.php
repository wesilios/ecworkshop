@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Media
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Media</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
        	<div class="col-md-12">
        		@if(session('error'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('error') }}
                </div>
                @endif
                @if(session('delete'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('delete') }}
                </div>
                @endif
                @if(session('status'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('status') }}
                </div>
                @endif
                @if ($errors->has('medias'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('medias') }}</strong>
	                </span>
	            @endif
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-12">
        		<div class="box box-solid">
        			<div class="box-header folder-link-tree">
						@if(isset($folder_string))
							@foreach($folder_string as $fd_string)
								@if($fd_string['folder_slug'] == 'root')
									@if($fd_string['folder_id']  == $folder->id)
										<div class="btn-group btn-group-sm">
											<button type="button" class="btn btn-info custom">{{ $fd_string['folder_name'] }}</button>
											<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" class="selectFile">Upload files</a></li>
												<li class="divider"></li>
												<li><a href="#" data-toggle="modal" data-target="#newFolder">New folder</a></li>
											</ul>
										</div>
									@else
										<a href="{{ route('admin.media.index')}}" class="btn btn-default btn-sm custom">{{ $fd_string['folder_name'] }}</a>
										<span class="custom"><i class="fa fa-angle-right"></i></span>
									@endif
								@else
									@if($fd_string['folder_id'] == $folder->id)
										<div class="btn-group btn-group-sm">
											<button type="button" class="btn btn-info custom">{{ $fd_string['folder_name'] }}</button>
											<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" class="selectFile">Upload files</a></li>
												<li class="divider"></li>
												<li><a href="#" data-toggle="modal" data-target="#newFolder">New folder</a></li>
											</ul>
										</div>
									@else
										<a href="{{ route('admin.folder.show',$fd_string['folder_slug'])}}" class="btn btn-default btn-sm custom">{{ $fd_string['folder_name'] }}</a>
										<span class="custom"><i class="fa fa-angle-right"></i></span>
									@endif
								@endif
							@endforeach
						@endif
        			</div>
        			<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-hidden">
									{!! Form::open(['method'=>'POST', 'action'=>"AdminMediaController@create" ,'files'=>true]) !!}
										{!! Form::file('medias[]', array('multiple'=>true,'id'=>'form-file-hidden')) !!}
										<input type="hidden" name="folder_id" value="{{ $folder->id }}"/>
										<div id="preview-image">
											<h5 id="h5-pre"><strong>Preview</strong> <input type="submit" id="uploadBtn" class="btn btn-info btn-sm" value="Upload" style="display: none"></h5>
											<div class="row"></div>
										</div>
										<div class="form-group">

										</div>
									{!! Form::close() !!}
								</div>
							</div>
							<div class="col-md-12">
								<div class="uploadZone">
									<div class="fileSelectZone">
										<div class="upload-ui">
											<h2>Drop files anywhere to upload</h2>
											<p>or</p>
											<button class="btn btn-default selectFile">Select Files</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if($medias->isNotEmpty() || $folder_list->isNotEmpty())
							@if(count($folder_list) >= 1)
								<div id="folder-section">
									<h5><strong>Folders</strong></h5>
									<div class="row">
										@foreach($folder_list as $fd)
											@if($folder->id != $fd->id)
												<a href="{{ route('admin.folder.show',$fd->slug) }}" data-folder-id="{{ $fd->id }}" data-folder-slug="{{ $fd->slug }}" class="folder-link" data-active="1">
													<div class="col-md-2">
														<div class="folder">
															<i class="fa fa-folder"></i> <span>{{ $fd->name }}</span>
														</div>
													</div>
												</a>
											@endif
										@endforeach
									</div>
				    			</div>
								<hr>
							@else
								<div id="folder-section"></div>
			    			@endif
			    			@if($medias->isNotEmpty())
								<div class="displayImages">
									<h5><strong>Files</strong></h5>
									<div class="row">
										@foreach($medias as $media)
										<div class="col-sm-2">
											<div class="thumbnails_img" style="background-image:url('{{ asset($media->url) }}')">
												<div class="caption">
													<div class="caption-content">
														<a href="#" data-toggle="modal" data-target="#new_modal{{ $media->id }}">
															<div class="btn btn-info">
																<i class="fa fa-eye"></i>
															</div>
														</a>
													</div>
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
								<hr>
							@else
								<div class="displayImages"></div>
							@endif
        				@else
							<div id="folder-section"></div>
							<div class="displayImages"></div>
							<div id="nothing">
								<div class="row">
									<div class="col-md-8 col-md-offset-2">
										<span><i class="fa fa-file-code-o"></i></span>
										<h4>Folder is empty</h4>
									</div>
								</div>
							</div>
        				@endif
        			</div>
        			<div class="box-footer">
        				<div class="text-center">
		                	{!! $medias->links()!!}
		                </div>
        			</div>
        		</div>
        	</div>

       	</div>
	</section>
	@foreach($medias as $media)
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="new_modal{{ $media->id }}" role="dialog">
		    	<div class="modal-dialog modal-dialog-95" style="border-top:5px solid #0097bc; border-radius:4px">
		      		<div class="modal-content">
		          		<div class="modal-header">
		            		<div>
		            			<span>Media Details</span>
		              			<div class="pull-right">
		                			<button type="button" class="btn-custom btn-default" data-dismiss="modal">
		                				<i class="fa fa-close"></i>
		                			</button>
		              			</div>
		            		</div>
		          		</div>
		          		<div class="modal-body">
		            		<div class="row">
		              			<div class="col-sm-8">
			                		<div style="min-height:600px; width:100%; padding-bottom:15px">
			                  			<img src="{{ asset($media->url) }}" alt="" class="img-responsive">
			              			</div>
			            		</div>
			            		<div class="col-sm-4 media-info">
			            			<div class="filename">
			            				<strong>File name: </strong> {{ $media->file_name }}
			            			</div>
			            			<div class="filetype">
			            				<strong>File type: </strong> {{ $media->type }}
			            			</div>
			            			<div class="created_at">
			            				<strong>Uploaded date: </strong> {{ $media->created_at->diffForHumans() }}
			            			</div>
			            			<div class="updated_at">
			            				<strong>Updated date: </strong> {{ $media->updated_at->diffForHumans() }}
			            			</div>
			            			<div class="uploaded by">
			            				<strong>Uploaded by: </strong> {{ $media->admin->name }}
			            			</div>
			            			<hr>
			            			{!! Form::open(['method'=>'PUT', 'action'=>['AdminMediaController@update', $media->id], 'class'=>'form-horizontal']) !!}
										<div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
			                    			{!! Form::label('url', 'Url:', ['class' => 'col-sm-4 control-label'] ) !!}
					                      	<div class="col-sm-8">
												{!! Form::text('url', asset($media->url), ['class'=>'form-control', 'readonly']) !!}
					                      		@if ($errors->has('url'))
									                <span class="help-block">
									                    <strong>{{ $errors->first('url') }}</strong>
									                </span>
									            @endif
					                      	</div>
					                    </div>
					                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
			                    			{!! Form::label('title', 'Title:', ['class' => 'col-sm-4 control-label'] ) !!}
					                      	<div class="col-sm-8">
												{!! Form::text('title', $media->title, ['class'=>'form-control']) !!}
					                      		@if ($errors->has('title'))
									                <span class="help-block">
									                    <strong>{{ $errors->first('title') }}</strong>
									                </span>
									            @endif
					                      	</div>
					                    </div>
					                    <div class="form-group {{ $errors->has('caption') ? ' has-error' : '' }}">
			                    			{!! Form::label('caption', 'Caption:', ['class' => 'col-sm-4 control-label'] ) !!}
					                      	<div class="col-sm-8">
												{!! Form::textarea('caption', $media->caption, ['class'=>'form-control', 'rows'=>'3']) !!}

					                      	</div>
					                    </div>
					                    <div class="form-group {{ $errors->has('alt_text') ? ' has-error' : '' }}">
			                    			{!! Form::label('alt_text', 'Alt text:', ['class' => 'col-sm-4 control-label'] ) !!}
					                      	<div class="col-sm-8">
												{!! Form::text('alt_text', $media->alt_text, ['class'=>'form-control']) !!}
					                      	</div>
					                    </div>
					                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
			                    			{!! Form::label('description', 'Description:', ['class' => 'col-sm-4 control-label'] ) !!}
					                      	<div class="col-sm-8">
												{!! Form::textarea('description', $media->description, ['class'=>'form-control', 'rows'=>'3']) !!}
					                      	</div>
					                    </div>
					                <hr>
					                <ul>
					                	<li>{!! Form::submit('Lưu thay đổi', ['class'=>'btn-nothing']) !!}</li>
					                	<li>
					                		<a href="#" data-toggle="modal" data-target="#delete{{ $media->id }}">
					                            <div class="btn-danger"> Delete media</div>
					                        </a>
					                    </li>
					                </ul>
			            			{!! Form::close() !!}
			            		</div>
		        			</div>
		        		</div>
		      		</div><!-- /.modal-content -->
		    	</div><!-- /.modal -->
		  	</div>
		</div><!-- /.example-modal -->
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="delete{{ $media->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		        		<div class="modal-body">
		         			<h5>Xóa hình này?</h5>
		        		</div>
		        		<div class="modal-footer">
		        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminMediaController@destroy', $media->id], 'class'=>'form-horizontal']) !!}
		        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								<input type="hidden" name="folder_id" value="{{ $folder->id }}">
								{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
	            			{!! Form::close() !!}
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
	@endforeach
	<div class="example-modal">
		<div class="modal fade" id="newFolder" role="dialog">
			<div class="modal-dialog" style="">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Tạo folder mới</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="folder_name">Tên folder</label>
							<input type="text" name="folder_name" class="form-control"/>
							<div class="error"></div>
							<input type="hidden" name="folder_id" value="{{ $folder->id }}" />
						</div>
						<div class="form-group">
							<button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default">Thoát</button>
							<button class="btn btn-primary" id="new_folder">Taọ mới</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('extendscripts')
	<script>
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

		$('.folder-link').dblclick(function(e){
			var href = $(this).attr('href');
			window.location = href;
		});
	</script>
@endsection