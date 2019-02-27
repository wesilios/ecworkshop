<?php
/**
 * Created by PhpStorm.
 * User: Wesley Nguyen <wesley@ifreight.net>
 * Date: 12/16/18
 * Time: 10:55 AM
 */?>
@if($folder_list)
    @foreach($folder_list as $fd)
        @if($folder->id != $fd->id)
        <a href="{{ route('admin.folder.show',['id'=>$fd->id,'slug'=>$fd->slug])  }}" data-folder-id="{{ $fd->id }}" data-folder-slug="{{ $fd->slug }}" class="folder-link">
            <div class="col-md-12">
                <div class="folder">
                    <i class="fa fa-folder"></i> <span>{{ $fd->name }}</span>
                </div>
            </div>
        </a>
        @endif
    @endforeach
@endif


<script type="text/javascript">
    $('.folder-link').click(function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        if($(this).attr('data-active') == 1) {
            $(this).attr('data-active',0);
        } else {
            $(this).attr('data-active',1);
        }
    });

    function getFolderByAjax(folder_slug, folder_id, token, slider_id) {
        $.ajax({
            url: "{{ route('admin.folder.item.ajax.show') }}",
            method: 'POST',
            dataType: 'json',
            data: {folder_slug:folder_slug, folder_id:folder_id, _token:token, slider_id:slider_id},
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
</script>
