@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			{{ $slider->name }}
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ route('admin.sliders.index') }}">All Sliders</a></li>
			<li class="active">{{ $slider->name }}</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
        	<div class="col-md-12">
        		<div class="box box-solid">
	                <div class="box-body">
	                	@if($slider->sliderDetails->isNotEmpty())
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			                    <ol class="carousel-indicators">
			                    	@for($i = 0; $i<count($slider->sliderDetails);$i++)
			                      	<li data-target="#carousel-example-generic" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : ''}}"></li>
			                      	@endfor
			                    </ol>
			                    <div class="carousel-inner">
			                    	@php 
										$i = 0
			                    	@endphp
			                    	@foreach($slider->sliderDetails as $sliderDetail)
				                      	<div class="item {{ $i == 0 ? 'active' : ''}}">
				                        	<img src="{{ asset($sliderDetail->media->url) }}" alt="{{ asset($sliderDetail->media->file_name) }}">
				                      	</div>
			                      	@php 
										$i++
			                    	@endphp
			                      	@endforeach
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
	                        		<img src="http://placehold.it/1400x500/39CCCC/ffffff&text=I+Love+Bootstrap" alt="First slide">
	                       			<div class="carousel-caption">
	                          			First Slide
	                        		</div>
	                      		</div>
		                      	<div class="item">
			                        <img src="http://placehold.it/1400x500/3c8dbc/ffffff&text=I+Love+Bootstrap" alt="Second slide">
			                        <div class="carousel-caption">
			                          	Second Slide
			                        </div>
		                      	</div>
	                      		<div class="item">
			                        <img src="http://placehold.it/1400x500/f39c12/ffffff&text=I+Love+Bootstrap" alt="Third slide">
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
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
        	</div>
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
				<div class="box box-hidden">
					<div class="box-body">
						<div class="form-hidden">
		    				{!! Form::open(['method'=>'POST', 'action'=>["AdminSlidersController@upload", $slider->id] ,'files'=>true]) !!}
								{!! Form::file('medias[]', array('multiple'=>true,'id'=>'form-file-hidden')) !!}
								<div class="form-group">
									<button class="btn btn-default selectFile">Chọn từ máy tính</button>
									{!! Form::submit('Upload', ['class'=>'btn btn-info']) !!}
									<a href="#" data-toggle="modal" data-target="#gallery_modal" >
			                            <div class="btn btn-default">
			                              	Chọn từ thư viện
			                            </div>
			                        </a>
								</div>
			    			{!! Form::close() !!}
		    			</div>
		    			<div id="preview-image">

		    			</div>
					</div>
				</div>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-12">
        		<div class="box box-solid">
        			<div class="box-header">
        				<h3 class="box-title">Chi tiết slider</h3>
        			</div>
        			<div class="box-body">
        				<div class="displayImages">
		        			@foreach($slider->sliderDetails as $sliderDetail)
							<div class="col-sm-2">
								<div class="thumbnails_img" style="background-image:url('{{ asset($sliderDetail->media->url) }}')">
									<div class="caption">
										<div class="caption-content">
											<a href="#" data-toggle="modal" data-target="#link{{ $sliderDetail->id }}">
					                            <div class="btn btn-info">
					                              	<i class="fa fa-eye"></i>
					                            </div>
					                        </a>
					                        <a href="#" data-toggle="modal" data-target="#delete_modal{{ $sliderDetail->id }}">
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
	</section>
	@foreach($slider->sliderDetails as $sliderDetail)
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="delete_modal{{ $sliderDetail->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		        		<div class="modal-body">
		         			<h5>Xóa slide ảnh này?</h5>
		        		</div>
		        		<div class="modal-footer">
		        			{!! Form::open(['method'=>'DELETE', 'action'=>['AdminSlidersController@destroyImage', $slider->id, $sliderDetail->id], 'class'=>'form-horizontal']) !!}
		        				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								{!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
	            			{!! Form::close() !!}
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
		<div class="example-modal">
		  	<div class="modal fade item_modal" id="link{{ $sliderDetail->id }}" role="dialog">
		    	<div class="modal-dialog delete-dialog" style="">
		      		<div class="modal-content">
		      			<div class="modal-header">
		      				Thêm link vào slide ảnh
		      				<div class="pull-right">
	                			<button type="button" class="btn-custom btn-default" data-dismiss="modal">
	                				<i class="fa fa-close"></i>
	                			</button>
	              			</div>
		      			</div>
		        		<div class="modal-body">
		        			<div class="col-md-12">
		        				{!! Form::open(['method'=>'PUT', 'action'=>['AdminSlidersController@updateLink', $slider->id, $sliderDetail->id], 'class'=>'form-horizontal']) !!}
			        				<div class="form-group {{ $errors->has('titletitle') ? ' has-error' : '' }}">
			                			{!! Form::label('name', 'Chèn link:', ['class' => 'control-label'] ) !!}
										{!! Form::text('link', $sliderDetail->link, ['class'=>'form-control']) !!}
				                    </div>
				                    <div class="form-group">
				                    	{!! Form::submit('Lưu chỉnh sửa', ['class'=>'col-md-12 btn btn-primary']) !!}
				                    </div>
		            			{!! Form::close() !!}
		        			</div>
		        		</div>
		        		<div class="modal-footer">
		        			
		        		</div>
		      		</div>
		    	</div>
		 	</div>
		</div>
	@endforeach
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
	                			<div class="box">
				        			<div class="box-body" >
										{!! Form::open(['method'=>'POST', 'action'=>["AdminSlidersController@selectImage",$slider->id] ,'files'=>true]) !!}
											<div class="form-group">
					                      		<select multiple class="form-control" name="media_id[]" id="selForm">
													@foreach($medias as $media)
						                        		<option value="{{ $media->id }}">{{ $media->file_name }}</option>
						                        	@endforeach
						                      	</select>
						                    </div>
											<div class="form-group">
												{!! Form::submit('Lưu vào slider', ['class'=>'btn btn-info pull-right','id'=>'selectImgbtn'.$media->id]) !!}
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
								                              	<i class="fa fa-save"></i>
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
	      		</div><!-- /.modal-content -->
	    	</div><!-- /.modal -->
	  	</div> 
	</div><!-- /.example-modal -->
@endsection

@section('extendscripts')
	
@endsection