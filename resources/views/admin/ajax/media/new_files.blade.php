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
            {!! Form::open(['method'=>'PUT', 'action'=>["AdminArticleController@selectImage",$article->id] ,'files'=>true]) !!}
            {!! Form::text('media_id', $media->id ,['id'=>'form-file-hidden']) !!}
            <div class="form-group">
                {!! Form::submit('Select', ['class'=>'btn btn-info','id'=>'selectImgbtn'.$media->id]) !!}
            </div>
            {!! Form::close() !!}
        </div>
    @endforeach
@endif
<script>
    $('.selectImgA').click(function(event){
        event.preventDefault();
        var id = $(this).attr('id');
        var btn = '#selectImgbtn';
        $(btn.concat(id)).click();
    });
</script>