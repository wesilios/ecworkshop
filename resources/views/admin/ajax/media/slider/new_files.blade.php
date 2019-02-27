<?php
/**
 * Created by PhpStorm.
 * User: Wesley Nguyen <wesley@ifreight.net>
 * Date: 12/16/18
 * Time: 10:55 AM
 */?>
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
<script>
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
    $('#new_folder').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        var token = $("input[name='_token']").val();
        var slider_id = '{{ $slider->id }}';
        var folder_name = $("input[name='folder_name']").val();
        var folder_id = $("input[name='folder_id']").val();
        if(folder_name == '') {
            alert('Trống tên');
        } else {
            $.ajax({
                url: "{{ route('admin.folder.createSliderAjax') }}",
                method:'POST',
                dataType:'json',
                data: {folder_name:folder_name, _token:token, folder_id:folder_id, slider_id:slider_id},
                success: function(data) {
                    if(data.error) {
                        $('#newFolder .error').html(data.mess);
                    } else {
                        $('.modal_folder').html('');
                        $('.modal_folder').html(data.option);
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
        var slider_id = '{{ $slider->id }}';
        var token = $("input[name='_token']").val();
        var folder_slug = $(this).attr('data-folder-slug');
        var folder_id = $(this).attr('data-folder-id');
        if(folder_id == null || folder_slug == null) {
            alert('Cant get this folder');
        } else {
            getFolderByAjax(folder_slug, folder_id, token, slider_id);
        }
    });

    function getFolderByAjax(folder_slug, folder_id, token, slider_id) {
        $.ajax({
            url: "{{ route('admin.folder.slider.ajax.show') }}",
            method: 'POST',
            dataType: 'json',
            data: {folder_slug:folder_slug, folder_id:folder_id, _token:token, slider_id:slider_id},
            success: function (data) {
                if(data.error) {
                    alert(data.mess);
                } else {
                    $("#newFolder input[name='folder_id']").val(data.folder_id);
                    $('#modal-content').html(data.option);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            }
        });
    };

    $('.custom').click(function (e) {
        e.preventDefault();
        var slider_id = '{{ $slider->id }}';
        var token = $("input[name='_token']").val();
        var folder_slug = $(this).attr('data-folder-slug');
        var folder_id = $(this).attr('data-folder-id');
        if(folder_id == null || folder_slug == null) {
            alert('Cant get this folder');
        } else {
            getFolderByAjax(folder_slug, folder_id, token, slider_id);
        }
    });

    function uploadImage() {};
    function uploadImages() {};

    $('.selectFile_1').click(function(e){
        e.preventDefault();
        $("input[name='medias[]']").trigger('click');
    });

    $("input[name='medias[]']").change(function(e) {
        var medias = e.target.files;console.log('here');
        var folder_id = $(this).attr('data-folder-id');
        var item_id = '{{ $slider->id }}';
        var token = $("input[name='_token']").val();
        $("#formUploadImage").trigger('submit');
    });

    $('#formUploadImage').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            url: "{{ route('admin.slider.ajaxUpload') }}",
            method: 'POST',
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function (data){
                if(data.success == '1')
                {
                    $('#gallery_modal #modal-medias').html('');
                    $('#gallery_modal #modal-medias').html(data.data);
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

