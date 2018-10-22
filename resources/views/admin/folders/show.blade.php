@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Media
			<button class="btn bg-maroon btn-xs media-addnew">Add new</button>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Media</li>
		</ol>
	</section>
	<section class="content">
        <div class="row">
        	<div class="col-md-12">
        		<div class="uploadZone">
        			<div class="fileSelectZone">
	        			<a class="closeZone pull-right"><i class="fa fa-close fa-2x"></i></a>
	        			<div class="upload-ui">
	        				<h2>Drop files anywhere to upload</h2>
							<p>or</p>
							<button class="btn btn-default selectFile">Select Files</button>
	        			</div>
	        		</div>
        		</div>
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
		    				{!! Form::open(['method'=>'POST', 'action'=>"AdminMediaController@create" ,'files'=>true]) !!}
								{!! Form::file('medias[]', array('multiple'=>true,'id'=>'form-file-hidden')) !!}
								<div class="form-group">
									<button class="btn btn-default selectFile">Select files</button>
									{!! Form::submit('Upload', ['class'=>'btn btn-info']) !!}
									<div class="pull-right">
					    				<a href="#" data-toggle="modal" data-target="#newFolder">
				                            <div class="btn btn-success">Folder mới</div>
				                        </a>
					    			</div>
								</div>
			    			{!! Form::close() !!}
		    			</div>
		    			
					</div>
				</div>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-12">
        		<div class="box box-solid">
        			<div class="box-header">
        				<h3 class="box-title folder-link">
        					@foreach($folder_string as $folder_list)
								{{ $folder_list['folder_name'] . ' / '}}
        					@endforeach
        				</h3>
        			</div>
        			<div class="box-body">
        				<div id="folder-section">
							<div class="row">
								
							</div>
		    			</div>
        				<div id="preview-image">

		    			</div>
        				<div class="displayImages">
		        			
		        		</div>
        			</div>
        			<div class="box-footer">
        				<div class="text-center">
		                	
		                </div>
        			</div>
        		</div>
        	</div>

       	</div>
	</section>

		<div class="example-modal">
		  	<div class="modal fade" id="newFolder" role="dialog">
		    	<div class="modal-dialog" style="">
		      		<div class="modal-content">
		      			<div class="modal-header">
		      				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    		<h4 class="modal-title">Tạo folder mới</h4>
		      			</div>
		        		<div class="modal-body">
		         			{!! Form::open(['method'=>'POST', 'action'=>'AdminFolderController@create']) !!}
		         				<div class="form-group">
		         					{!! Form::label('title', 'Tên folder:', ['class' => 'control-label'] ) !!}
									{!! Form::text('name', null, ['class'=>'form-control']) !!}
									<input type="hidden" name="folder_id" value="{{ $folder->id }}"/>
		         				</div>
								<div class="form-group">
									{!! Form::submit('Tạo', ['class'=>'btn btn-primary']) !!}
								</div>
		         			{!! Form::close()!!}
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
			if(folder_name == '') {
				alert('Trống tên');
			} else {
				$.ajax({
	                url: "{{ route('admin.folder.create') }}",
	                method:'POST',
	                dataType:'json',
	                data: {folder_name:folder_name, _token:token},
	                success: function(data) {
	                    $('.order_table').html('');
	                    $('.order_table').html(data.option);
	                },
	                error: function (xhr, ajaxOptions, thrownError) {
	                   console.log(xhr.status);
	                   console.log(xhr.responseText);
	                   console.log(thrownError);
	               }
	            });
			}
		});
	</script>
@endsection