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
                        <a href="" class="btn btn-default btn-sm custom" data-folder-id="{{ $fd_string['folder_id'] }}" data-folder-slug="{{ $fd_string['folder_slug'] }}">
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
            <div id="folder-section">
                <h5><strong>Folders</strong></h5>
                <div class="row">
                    <div class="col-md-12">
                        <p>No folder here!</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-sm-10" >
        <h5><strong>Files</strong></h5>
        <div class="modalDisplayImages row">
            @if($medias->isNotEmpty())
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
                @else
                <div id="nothing">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <span><i class="fa fa-file-code-o"></i></span>
                            <h4>No file here</h4>
                        </div>
                    </div>
                </div>
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
                    console.log(data.folder_string);
                    $('#modal-medias').html(data.option);
                    $("input[name='folder_id']").val(data.folder_id);
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

    $('.custom').click(function (e) {
        e.preventDefault();
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

    function uploadImage() {};
    function uploadImages() {};

    $('.selectFile_1').click(function(e){
        e.preventDefault();
        $("input[name='medias']").click();
    });

    $("input[name='medias']").change(function(e) {
        var medias = e.target.files;
        var folder_id = $(this).attr('data-folder-id');
        var article_id = '{{ $article->id }}';
        var token = $("input[name='_token']").val();
        $("#formUploadImage").trigger('submit');
    });

    $('#formUploadImage').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            url: "{{ route('admin.article.ajaxUpload') }}",
            method: 'POST',
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function (data){
                if(data.success == '1')
                {
                    $('.modalDisplayImages').html();
                    $('.modalDisplayImages').html(data.data);
                } else {
                    if(data.error == '1')
                    {
                        console.log(data.message);
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            }
        });
    });

</script>
<script src="{{ asset('js/admin/custom.js') }}"></script>
