@foreach($medias as $media)
    <div class="col-sm-2">
        <div class="thumbnails_img" style="background-image:url('{{ asset($media->url) }}')">
            <div class="caption">
                <div class="caption-content">
                    <a href="#" id="{{ $media->id }}" class="selectMultImgA">
                        <div class="btn btn-info">
                            <i class="fa fa-check"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="form-hidden-article">
        {!! Form::open(['method'=>'PUT', 'action'=>["AdminJuicesController@selectImage",$accessory->id] ,'files'=>true]) !!}
        {!! Form::text('media_id', $media->id ,['id'=>'form-file-hidden']) !!}
        <div class="form-group">
            {!! Form::submit('Select', ['class'=>'btn btn-info','id'=>'selectImgbtn'.$media->id]) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endforeach
<script>
    $('.selectMultImgA').click(function(event){
        event.preventDefault();
        var id = $(this).attr('id');
        var thumbnails_img = '#thumbnails_img';
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

    $('.selectImgIndex').click(function(event){
        event.preventDefault();
        var id = $(this).attr('id');
        //alert(id);
        var thumbnails_img = '#thumbnails_index_img';
        $('.thumbnails_img').removeClass('active');
        $(thumbnails_img.concat(id)).toggleClass('active');
        $('#selIndexImgForm option').attr('selected', false);
        $('#selIndexImgForm option[value="'+ id +'"]').attr('selected', true);
    });
</script>