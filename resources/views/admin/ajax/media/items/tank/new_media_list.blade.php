@if($tank->medias->isNotEmpty())
    <div id="carousel-slide-details" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @for($i = 0; $i<count($tank->medias);$i++)
                <li data-target="#carousel-slide-details" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : ''}}"></li>
            @endfor
        </ol>
        <div class="carousel-inner">
            @php
                $i = 0
            @endphp
            @if($index_img != null)
                <div class="item {{ $i == 0 ? 'active' : ''}}">
                    <img src="{{ asset($index_img->url) }}" alt="{{ asset($index_img->file_name) }}">
                </div>
                @foreach($media_remain as $media)
                    <div class="item">
                        <img src="{{ asset($media->url) }}" alt="{{ asset($media->file_name) }}">
                    </div>
                    @php
                        $i++
                    @endphp
                @endforeach
            @else
                @foreach($tank->medias as $media)
                    <div class="item {{ $i == 0 ? 'active' : ''}}">
                        <img src="{{ asset($media->url) }}" alt="{{ asset($media->file_name) }}">
                    </div>
                    @php
                        $i++
                    @endphp
                @endforeach
            @endif
        </div>
        <a class="left carousel-control" href="#carousel-slide-details" data-slide="prev">
            <span class="fa fa-angle-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-slide-details" data-slide="next">
            <span class="fa fa-angle-right"></span>
        </a>
    </div>
@else
    <div id="carousel-slide-details" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-slide-details" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-slide-details" data-slide-to="1" class=""></li>
            <li data-target="#carousel-slide-details" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active">
                <img src="http://placehold.it/900x500/39CCCC/ffffff&text=Item+image" alt="First slide">
                <div class="carousel-caption">
                    First Slide
                </div>
            </div>
            <div class="item">
                <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=Item+image" alt="Second slide">
                <div class="carousel-caption">
                    Second Slide
                </div>
            </div>
            <div class="item">
                <img src="http://placehold.it/900x500/f39c12/ffffff&text=Item+image" alt="Third slide">
                <div class="carousel-caption">
                    Third Slide
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#carousel-slide-details" data-slide="prev">
            <span class="fa fa-angle-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-slide-details" data-slide="next">
            <span class="fa fa-angle-right"></span>
        </a>
    </div>
@endif
<hr>
<div class="row">
    @foreach($tank->medias as $media)
        <div class="col-sm-2">
            <div class="thumbnails_img active" style="background-image:url('{{ asset($media->url) }}')">
                <div class="caption">
                    <div class="caption-content">
                        <a href="#" data-media-id="{{ $media->id }}" class='removeSelectedImg'>
                            <div class="btn btn-success">
                                <i class="fa fa-trash"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<script>
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
</script>