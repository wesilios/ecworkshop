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
            @if($article->media->first())
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
            @endif
        </div>
    </div>
</div>
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
            var folder_slug = $(this).attr('data-folder-slug');
            var folder_id = $(this).attr('data-folder-id');
            if(folder_id == null || folder_slug == null) {
                alert('Cant get this folder');
            } else {
                getFolderByAjax(folder_slug, folder_id, token, article_id);
            }
        });

    </script>
