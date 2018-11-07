<div class="example-modal">
    <div class="modal fade item_modal" id="gallery_modal" role="dialog">
        <div class="modal-dialog modal-dialog-95" style="border-top:5px solid #0097bc; border-radius:4px">
            <div class="modal-content" id="modal-medias">
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
                        <div class="col-md-12 folder-link-tree" style="margin-top:10px">
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
                                                    <li><a href="#" class="selectFile_1">Upload files</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#newFolder">New folder</a></li>
                                                </ul>
                                            </div>
                                        @else
                                            <a href="" class="btn btn-default btn-sm custom" data-folder-id="{{ $fd_string->folder_id }}" data-folder-slug="{{ $fd_string->slug }}">
                                                {{ $fd_string['folder_name'] }}
                                            </a>
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
                                                    <li><a href="#" class="selectFile_1">Upload files</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#newFolder">New folder</a></li>
                                                </ul>
                                            </div>
                                        @else

                                            <a href="" class="btn btn-default btn-sm custom" data-folder-id="{{ $fd_string['folder_id'] }}" data-folder-slug="{{ $fd_string['folder_slug'] }}">
                                                {{ $fd_string['folder_name'] }}
                                            </a>
                                            <span class="custom"><i class="fa fa-angle-right"></i></span>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="form-hidden">
                                <form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data" id="formUploadImage">
                                    <input type="file" name="medias[]" id="form-file-hidden1" value="" style="display: none" multiple>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="accessory_id" value="{{ $accessory->id }}">
                                    <input type="hidden" name="folder_id" value="{{ $folder->id }}"/>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            @if($folder_list->isNotEmpty())
                                @if(count($folder_list) >= 1)
                                    <div id="folder-section">
                                        <h5><strong>Folders</strong></h5>
                                        <div class="row">
                                            @foreach($folder_list as $fd)
                                                @if($folder->id != $fd->id)
                                                    <a href="{{ route('admin.folder.show',$fd->slug) }}" data-folder-id="{{ $fd->id }}" data-folder-slug="{{ $fd->slug }}" class="folder-link" data-active="1">
                                                        <div class="col-md-12">
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
                            @else
                                <div id="folder-section"></div>
                            @endif
                        </div>
                        <div class="col-sm-10" >
                            <h5><strong>Files</strong></h5>
                            <div class="modalDisplayImages row">
                                @foreach($medias as $media)
                                    <div class="col-sm-2">
                                        <div class="thumbnails_img" style="background-image:url('{{ asset($media->url) }}')" id="thumbnails_img_{{ $media->id }}">
                                            <div class="caption">
                                                <div class="caption-content">
                                                    <a href="#" data-media-id="{{ $media->id }}" class="selectMultImgA">
                                                        <div class="btn btn-info">
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-hidden-article">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['method'=>'PUT', 'action'=>["AdminAccessoriesController@selectImage",$accessory->id] ,'files'=>true]) !!}
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
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div><!-- /.example-modal -->
@foreach($accessory->medias as $media)
    <div class="example-modal">
        <div class="modal fade item_modal" id="delete{{ $media->id }}" role="dialog">
            <div class="modal-dialog delete-dialog" style="">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Xóa hình này?</h5>
                    </div>
                    <div class="modal-footer">
                        {!! Form::open(['method'=>'DELETE', 'action'=>['AdminAccessoriesController@delete_image', $accessory->id], 'class'=>'form-horizontal']) !!}
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