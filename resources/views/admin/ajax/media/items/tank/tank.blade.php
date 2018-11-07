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
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            @if($folder_list->isNotEmpty())
                @if(count($folder_list) >= 1)
                    <div id="folder-section">
                        <h5><strong>Folders</strong></h5>
                        <div class="row modal_folder">
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
                    <div id="folder-section">
                        <div class="row modal_folder"></div>
                    </div>
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
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['method'=>'PUT', 'action'=>["AdminTanksController@selectImage",$tank->id] ,'files'=>true]) !!}
            <div class="form-group">
                <select multiple class="form-control" name="media_id[]" id="selForm">
                    @foreach($medias as $media)
                        <option value="{{ $media->id }}">{{ $media->file_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {!! Form::submit('Lưu vào sản phẩm', ['class'=>'btn btn-info pull-right','id'=>'selectImgbtn']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    $('.select2-multi').select2();
    $('.select2-single').select2();
    $('.removeSelectedImg').click(function(e){
        e.preventDefault();
        var id = $(this).attr('data-media-id');
        var tank_id = '{{ $tank->id }}';
        var token = $("input[name='_token']").val();
        if(confirm('Are you sure?'))
        {
            $.ajax({
                url: "{{ route('admin.tank.remove_selected_img') }}",
                method:'POST',
                dataType:'json',
                data: {media_id:id, _token:token, tank_id:tank_id},
                success: function(data) {
                    if(data.error) {
                        console.log(data.message);
                        window.location.reload(true);
                        console.log(data.tank);
                        $('#selected_img').html('');
                        $('#selected_img').html(data.data);
                    } else {
                        $('#selected_img').html('');
                        console.log(data.data);
                        $('#selected_img').html(data.data);
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
    $('.selectMultImgA').click(function(event){
        event.preventDefault();
        var id = $(this).attr('data-media-id');
        var thumbnails_img = '#thumbnails_img_';
        $(thumbnails_img.concat(id)).toggleClass('active');

        if($('#selForm option[value="' + id + '"]').attr('selected'))
        {
            $('#selForm option[value="' + id + '"]').attr('selected', false);
        }
        else
        {
            $('#selForm option[value="' + id + '"]').attr('selected', true);
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

    function getFolderByAjax(folder_slug, folder_id, token, tank_id) {
        $.ajax({
            url: "{{ route('admin.folder.tank.ajax.show') }}",
            method: 'POST',
            dataType: 'json',
            data: {folder_slug:folder_slug, folder_id:folder_id, _token:token, tank_id:tank_id},
            success: function (data) {
                if(data.error) {
                    alert(data.mess);
                } else {
                    console.log(data.folder_string);
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
        var tank_id = '{{ $tank->id }}';
        var item_category_id = '{{ $tank->item_category_id }}';
        var token = $("input[name='_token']").val();
        var folder_slug = $(this).attr('data-folder-slug');
        var folder_id = $(this).attr('data-folder-id');
        if(folder_id == null || folder_slug == null) {
            alert('Cant get this folder');
        } else {
            getFolderByAjax(folder_slug, folder_id, token, tank_id, item_category_id);
        }
    });

    $('.custom').click(function (e) {
        e.preventDefault();
        var tank_id = '{{ $tank->id }}';
        var token = $("input[name='_token']").val();
        var folder_slug = $(this).attr('data-folder-slug');
        var folder_id = $(this).attr('data-folder-id');
        if(folder_id == null || folder_slug == null) {
            alert('Cant get this folder');
        } else {
            getFolderByAjax(folder_slug, folder_id, token, tank_id);
        }
    });

    function uploadImage() {};
    function uploadImages() {};

    $('.selectFile_1').click(function(e){
        e.preventDefault();
        $("input[name='medias[]']").click();
    });

    $("input[name='medias[]']").change(function(e) {
        var medias = e.target.files;
        var folder_id = $(this).attr('data-folder-id');
        var tank_id = '{{ $tank->id }}';
        var token = $("input[name='_token']").val();
        $("#formUploadImage").trigger('submit');
    });

    $('#formUploadImage').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            url: "{{ route('admin.tank.ajaxUpload') }}",
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
