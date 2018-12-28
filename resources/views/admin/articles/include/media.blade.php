<div class="example-modal">
    <div class="modal fade item_modal" id="gallery_modal" role="dialog">
        <div class="modal-dialog modal-dialog-fullscreen" style="">
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
                    <div id="modal-medias">
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
                                    <form method="POST" action="{{ route('admin.articles.upload', $article->id) }}" accept-charset="UTF-8" enctype="multipart/form-data" id="formUploadImage">
                                        <input type="file" name="medias" id="form-file-hidden1" value="" style="display: none">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="article_id" value="{{ $article->id }}">
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
                                                        <a href="{{ route('admin.folder.show',['id'=>$fd->id,'slug'=>$fd->slug]) }}" data-folder-id="{{ $fd->id }}" data-folder-slug="{{ $fd->slug }}" class="folder-link" data-active="1">
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
                                    @if($article->media->first())
                                        <div class="col-sm-2">
                                            <div class="thumbnails_img active" style="background-image:url('{{ asset($article->media->first()->url) }}')">
                                                <div class="caption">
                                                    <div class="caption-content">
                                                        <a href="#" id="{{ $article->media->first()->id }}" class='selectImgA'>
                                                            <div class="btn btn-success">
                                                                <i class="fa fa-close"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach($medias as $media)
                                        <div class="col-sm-2">
                                            <div class="thumbnails_img" style="background-image:url('{{ asset($media->url) }}')">
                                                <div class="caption">
                                                    <div class="caption-content">
                                                        <a href="#" id="{{ $media->id }}" class="selectImgA">
                                                            <div class="btn btn-info">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-hidden-article">
                                            {!! Form::open(['method'=>'PUT', 'action'=>["AdminArticleController@selectImage",$article->id]]) !!}
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
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div><!-- /media.example-modal -->
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
                        <input type="text" name="folder_name" id="folder_name" class="form-control"/>
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