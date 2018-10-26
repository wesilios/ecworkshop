@extends('layouts.adminapp')

@section('tinymce')
	@include('include.tinymce')
@endsection

@section('content')
	<section class="content-header">
		<h1>
			{{ $juice->item->name }}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('juices.index') }}">Tất cả tinh dầu</a></li>
			<li class="active">Edit</li>
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
        	</div>
        	{!! Form::open(['method'=>'PUT', 'action'=>["AdminJuicesController@update", $juice->id], 'class'=>'form-horizontal', 'files'=>true]) !!}
				<div class="col-md-8">
					<!-- Horizontal Form -->
					<div class="box">
		                <!-- form start -->
	                	<div class="box-body">
	                		<div class="col-md-12">
	                			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
	                    			{!! Form::label('name', 'Tên sản phẩm:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name', $juice->item->name, ['class'=>'form-control', 'placeholder'=>'Insert name']) !!}
		                      		@if ($errors->has('name'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('name') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
	                    			{!! Form::label('price', 'Giá gốc:', ['class' => 'control-label'] ) !!}
									{!! Form::number('price', $juice->item->price, ['class'=>'form-control', 'placeholder'=>'Insert price']) !!}
		                      		@if ($errors->has('price'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('price') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('price_off') ? ' has-error' : '' }}">
	                    			{!! Form::label('price_off', 'Giá giảm:', ['class' => 'control-label'] ) !!}
									{!! Form::number('price_off', $juice->item->price_off, ['class'=>'form-control', 'placeholder'=>'']) !!}
		                      		@if ($errors->has('price_off'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('price_off') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
	                    			{!! Form::label('summary', 'Tóm tắt sản phẩm:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('summary', $juice->item->summary, ['class'=>'form-control', 'rows'=>'3']) !!}
		                      		@if ($errors->has('summary'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('summary') }}</strong>
						                </span>
						            @endif
			                    </div>
			                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
	                    			{!! Form::label('description', 'Miêu tả sản phẩm:', ['class' => 'control-label'] ) !!}
									{!! Form::textarea('description', $juice->item->description, ['class'=>'form-control textarea']) !!}
		                      		@if ($errors->has('description'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('description') }}</strong>
						                </span>
						            @endif
			                    </div>
	                		</div>
			            </div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box">
						<div class="box-body">
							<div><strong>Ngày đăng:</strong> {{ date("F jS, Y", strtotime($juice->item->created_at)) }}</div>
							<div><strong>Ngày cập nhật:</strong>  {{ date("F jS, Y", strtotime($juice->item->updated_at)) }}</div>
							<div><strong>Đăng bởi:</strong>  {{ $juice->item->admin->name }}</div>
						</div>
						<div class="box-footer">
							<div class="col-md-12">
								<div class="form-group">
									<a href="#" data-toggle="modal" data-target="#delete" >
			                            <div class="btn btn-danger pull-right"  style="margin-left:3px">
			                              	<i class="fa fa-trash "></i>
			                            </div>
			                        </a>
									{!! Form::submit('Lưu chỉnh sửa', ['class'=>'btn btn-success pull-right']) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-body">
							@if($juice->medias->isNotEmpty())
								<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				                    <ol class="carousel-indicators">
				                    	@for($i = 0; $i<count($juice->medias);$i++)
				                      	<li data-target="#carousel-example-generic" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : ''}}"></li>
				                      	@endfor
				                    </ol>
				                    <div class="carousel-inner">
				                    	@php
											$i = 0
				                    	@endphp
				                    	@if($index_img != null)
											<div class="item {{ $i == 0 ? 'active' : ''}}">
					                        	<img src="{{ asset($index_img->url) }}" alt="{{ asset($index_img->file_name) }}">
					                      	</div>
					                      	@foreach($media_remain as $media)
												<div class="item">
						                        	<img src="{{ asset($media->url) }}" alt="{{ asset($media->file_name) }}">
						                      	</div>
						                      	@php
												$i++
					                    	@endphp
					                      	@endforeach
				                    	@else
					                    	@foreach($juice->medias as $media)
						                      	<div class="item {{ $i == 0 ? 'active' : ''}}">
						                        	<img src="{{ asset($media->url) }}" alt="{{ asset($media->file_name) }}">
						                      	</div>
					                      	@php
												$i++
					                    	@endphp
					                      	@endforeach
					                    @endif
				                    </div>
				                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
				                      <span class="fa fa-angle-left"></span>
				                    </a>
				                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
				                      <span class="fa fa-angle-right"></span>
				                    </a>
				                </div>
							@else

							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			                    <ol class="carousel-indicators">
			                      	<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			                      	<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
			                      	<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
			                    </ol>
			                    <div class="carousel-inner">
			                      	<div class="item active">
			                        	<img src="http://placehold.it/900x500/39CCCC/ffffff&text=Item+image" alt="First slide">
			                        	<div class="carousel-caption">
			                          		First Slide
			                        	</div>
			                      	</div>
			                      	<div class="item">
			                        	<img src="http://placehold.it/900x500/3c8dbc/ffffff&text=Item+image" alt="Second slide">
			                        	<div class="carousel-caption">
			                          		Second Slide
			                        	</div>
			                      	</div>
			                      	<div class="item">
			                        	<img src="http://placehold.it/900x500/f39c12/ffffff&text=Item+image" alt="Third slide">
			                        	<div class="carousel-caption">
			                          		Third Slide
			                        	</div>
			                      	</div>
			                    </div>
			                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
			                      <span class="fa fa-angle-left"></span>
			                    </a>
			                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
			                      <span class="fa fa-angle-right"></span>
			                    </a>
			                </div>
							@endif
						</div>
						<div class="box-footer">
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
									<div class="checkbox">
					                    <label class="control-label">
					                      	<input type="checkbox" class="minimal" {{ $juice->homepage_active==1 ? 'checked' : '' }} name="homepage_active">
					                      	Hiển thị trang chủ
					                    </label>

									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>Hãng sản phẩm</label>
									{!! Form::select(
										'brand_id',
										$brands,
										$juice->brand_id,
										['class'=>'form-control select2-single']
										);
									!!}
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>Loại tinh dầu</label>
									{!! Form::select(
										'juice_category_id',
										$juice_cats,
										$juice->item->itemCategory['id'],
										['class'=>'form-control select2-multi']
										);
									!!}
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>Dung tích</label>
									{!! Form::select(
										'size_id',
										$juice_sizes,
										$juice->size_id,
										['class'=>'form-control select2-multi']
										);
									!!}
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>Tình trạng</label>
									{!! Form::select(
										'item_status_id',
										$statuses,
										$juice->item_status_id,
										['class'=>'form-control select2-multi']
										);
									!!}
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<a href="" class="custom-link" data-label="Hãng mới" data-type="brn"><strong>+ Hãng mới</strong></a>
									<a href="" class="custom-link" data-label="Dung tích mới" data-type="sze"><strong>+ Dung tích mới</strong></a>
								</div>
								<div class="form-group">
									<div class="alert alert-info alert-dismissable" style="display:none">
					                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
					                    Thêm thành công
					                </div>
								</div>
								<div class="form-group target-form" style="display:none">
									<label class="tagert-label"></label>
									<input type="hidden" id="target-type"/>
									<input type="text" id="main-info" class="form-control"/>
								</div>
								<div class="form-group target-form" style="display:none">
									<button id="main-submit" class="btn btn-sm btn-info pull-right" value="" disabled> Thêm mới</button>
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
	         			<h5>Xóa sản phẩm này?</h5>
	        		</div>
	        		<div class="modal-footer">
	        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminJuicesController@destroy', $juice->id], 'class'=>'form-horizontal']) !!}
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
					                  	<li {{ $juice->medias->isNotEmpty() == 1 ? '' : 'class=active' }}><a href="#tab_2" data-toggle="tab">Media gallery</a></li>
					                  	<li {{ $juice->medias->isNotEmpty() == 1 ? 'class=active' : '' }}><a href="#tab_3" data-toggle="tab">Ảnh sản phẩm</a></li>
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
									    				{!! Form::open(['method'=>'PUT', 'action'=>["AdminJuicesController@uploadImage",$juice->id] ,'files'=>true]) !!}
															{!! Form::file('medias[]', array('multiple'=>true,'id'=>'form-file-hidden')) !!}
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
							        	<div class="tab-pane {{ $juice->medias->isNotEmpty() == 1 ? '' : 'active' }}" id="tab_2">
							        		<div class="box">
							        			<div class="box-body" >
													{!! Form::open(['method'=>'PUT', 'action'=>["AdminJuicesController@selectImage",$juice->id] ,'files'=>true]) !!}
														<div class="form-group">
								                      		<select multiple class="form-control" name="media_id[]" id="selForm">
																@foreach($medias as $media)
									                        		<option value="{{ $media->id }}">{{ $media->file_name }}</option>
									                        	@endforeach
									                      	</select>
									                    </div>
														<div class="form-group">
															{!! Form::submit('Lưu vào sản phẩm', ['class'=>'btn btn-info pull-right','id'=>'selectImgbtn'.$media->id]) !!}
														</div>
													{!! Form::close() !!}
			            						</div>
							        		</div>
		            						<div>
		            							<div class="modalDisplayImages">
								        			@foreach($medias as $media)
													<div class="col-sm-2">
														<div class="thumbnails_img" style="background-image:url('{{ asset($media->url) }}')" id="thumbnails_img{{ $media->id }}">
															<div class="caption">
																<div class="caption-content">
																	<a href="#" id="{{ $media->id }}" class="selectMultImgA">
											                            <div class="btn btn-info">
											                              	<i class="fa fa-check"></i>
											                            </div>
											                        </a>
																</div>
															</div>
														</div>
													</div>
													@endforeach
								        		</div>
		            						</div>
							        	</div>
							        	<div class="tab-pane {{ $juice->medias->isNotEmpty() == 1 ? 'active' : '' }}" id="tab_3">
							        		<div class="box">
							        			<div class="box-body" >
													{!! Form::open(['method'=>'PUT', 'action'=>["AdminJuicesController@set_image_index",$juice->id]]) !!}
														<div class="form-group">
								                      		<select class="form-control" name="media_id" id="selIndexImgForm" style="display:none">
																@foreach($juice->medias as $media)
									                        		<option value="{{ $media->id }}">{{ $media->file_name }}</option>
									                        	@endforeach
									                      	</select>
									                    </div>
														<div class="form-group">
															{!! Form::submit('Chọn ảnh đầu tiên', ['class'=>'btn btn-info pull-right','id'=>'selectImgIndexbtn'.$media->id]) !!}
														</div>
													{!! Form::close() !!}
			            						</div>
							        		</div>
											<div class="box box-solid">
												<div class="box-body">
													<div class="modalItemImages">
														@foreach($juice->medias as $media)
														<div class="col-sm-2">
															<div class="thumbnails_img" style="background-image:url('{{ asset($media->url) }}')" id="thumbnails_index_img{{ $media->id }}">
																<div class="caption">
																	<div class="caption-content">
																		<a href="#" id="{{ $media->id }}" class="selectImgIndex">
												                            <div class="btn btn-info">
												                              	<i class="fa fa-check-square"></i>
												                            </div>
												                        </a>
												                        <a href="#" class="delete" data-toggle="modal" data-target="#delete{{ $media->id }}">
												                            <div class="btn btn-danger">
												                              	<i class="fa fa-trash"></i>
												                            </div>
												                        </a>
																	</div>
																</div>
															</div>
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
	        		</div>
	      		</div><!-- /.modal-content -->
	    	</div><!-- /.modal -->
	  	</div>
	</div><!-- /.example-modal -->
	@foreach($juice->medias as $media)
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="delete{{ $media->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		        		<div class="modal-body">
		         			<h5>Xóa hình này?</h5>
		        		</div>
		        		<div class="modal-footer">
		        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminJuicesController@delete_image', $juice->id], 'class'=>'form-horizontal']) !!}
		        				<input type="hidden" name="media_id" value="{{ $media->id }}"/>
		        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
	            			{!! Form::close() !!}
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
	@endforeach
@endsection

@section('extendscripts')
	<script>
		$('.select2-multi').select2();
		$('.select2-single').select2();
	</script>
	@component('components.ajax_post')

    @endcomponent
@endsection