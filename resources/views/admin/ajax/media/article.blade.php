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
    <div class="col-md-12">
        <div class="form-hidden">
            {!! Form::open(['method'=>'PUT', 'action'=>["AdminArticleController@uploadImage",$article->id] ,'files'=>true]) !!}
            {!! Form::file('medias', ['id'=>'form-file-hidden']) !!}
            <input type="hidden" name="folder_id" value="{{ $folder->id }}"/>
            <div id="preview-image">
                <h5 id="h5-pre"><strong>Preview</strong> <input type="submit" id="uploadBtn" class="btn btn-info btn-sm" value="Upload" style="display: none"></h5>
                <div class="row"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@if($folder_list->isNotEmpty())
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
@else
    <div id="folder-section"></div>
@endif
<div class="row">
    <div class="col-sm-12" >
        <div class="modalDisplayImages row">
            <div class="col-sm-2">
                <div class="thumbnails_img active" style="background-image:url('{{ asset($article->media->first()->url) }}')">
                    <div class="caption">
                        <div class="caption-content">
                            <a href="#" id="{{ $article->media->first()->id }}" class="selectImgA">
                                <div class="btn btn-info">
                                    <i class="fa fa-check"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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