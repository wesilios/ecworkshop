<?php
/**
 * Created by PhpStorm.
 * User: Wesley Nguyen <wesley@ifreight.net>
 * Date: 12/11/18
 * Time: 6:38 AM
 */?>
@extends('layouts.adminapp')

@section('tinymce')
    @include('include.tinymce')
@endsection

@section('content')
    <section class="content-header">
        <h1>
            {{ !empty($item) ? $item->name : '' }}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.items.index',['item_category'=>$item_category_slug]) }}">Tất cả {{ !empty($title) ? strtolower($title) : '' }}</a></li>
            <li style="text-transform: capitalize">{{ !empty($item) ? strtolower($item->name) : '' }}</li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if(session('status'))
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            {!! Form::open(['method'=>'PUT', 'action'=>["AdminItemsController@update", $item->slug], 'class'=>'form-horizontal', 'files'=>true]) !!}
            <div class="col-md-8">
                <!-- Horizontal Form -->
                <div class="box">
                    <!-- form start -->
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                {!! Form::label('name', 'Tên sản phẩm:', ['class' => 'control-label'] ) !!}
                                {!! Form::text('name', $item->name, ['class'=>'form-control', 'placeholder'=>'Insert name']) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('name') }}</strong>
						                </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                {!! Form::label('price', 'Giá gốc:', ['class' => 'control-label'] ) !!}
                                {!! Form::number('price', $item->price, ['class'=>'form-control', 'placeholder'=>'Insert price']) !!}
                                @if ($errors->has('price'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('price') }}</strong>
						                </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('price_off') ? ' has-error' : '' }}">
                                {!! Form::label('price_off', 'Giá giảm:', ['class' => 'control-label'] ) !!}
                                {!! Form::number('price_off', $item->price_off, ['class'=>'form-control', 'placeholder'=>'']) !!}
                                @if ($errors->has('price_off'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('price_off') }}</strong>
						                </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
                                {!! Form::label('summary', 'Tóm tắt sản phẩm:', ['class' => 'control-label'] ) !!}
                                {!! Form::textarea('summary', $item->summary, ['class'=>'form-control', 'rows'=>'3']) !!}
                                @if ($errors->has('summary'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('summary') }}</strong>
						                </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                {!! Form::label('description', 'Miêu tả sản phẩm:', ['class' => 'control-label'] ) !!}
                                {!! Form::textarea('description', $item->description, ['class'=>'form-control textarea']) !!}
                                @if ($errors->has('description'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('description') }}</strong>
						                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <div><strong>Ngày đăng:</strong> {{ date("F jS, Y", strtotime($item->created_at)) }}</div>
                        <div><strong>Ngày cập nhật:</strong>  {{ date("F jS, Y", strtotime($item->updated_at)) }}</div>
                        <div><strong>Đăng bởi:</strong>  {{ $item->admin->name }}</div>
                    </div>
                    <div class="box-footer">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="#" data-toggle="modal" data-target="#delete" >
                                    <div class="btn btn-danger pull-right"  style="margin-left:3px">
                                        <i class="fa fa-trash "></i>
                                    </div>
                                </a>
                                {!! Form::submit('Lưu chỉnh sửa', ['class'=>'btn btn-success pull-right']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        @if($item->medias->isNotEmpty())
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @for($i = 0; $i<count($item->medias);$i++)
                                        <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : ''}}"></li>
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
                                        @foreach($item->medias as $media)
                                            <div class="item {{ $i == 0 ? 'active' : ''}}">
                                                <img src="{{ asset($media->url) }}" alt="{{ asset($media->file_name) }}">
                                            </div>
                                            @php
                                                $i++
                                            @endphp
                                        @endforeach
                                    @endif
                                </div>
                                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                    <span class="fa fa-angle-left"></span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                    <span class="fa fa-angle-right"></span>
                                </a>
                            </div>
                        @else

                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
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
                                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                    <span class="fa fa-angle-left"></span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                    <span class="fa fa-angle-right"></span>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="box-footer">
                        @if($item->medias->isNotEmpty())
                            <a href="#" data-toggle="modal" data-target="#slide_modal" >
                                <div class="btn btn-default btn-block" style="margin-bottom: 5px">
                                    Edit slides
                                </div>
                            </a>
                        @endif
                        <a href="#" data-toggle="modal" data-target="#gallery_modal" >
                            <div class="btn btn-primary btn-block">
                                Select form gallery
                            </div>
                        </a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label class="control-label">
                                        <input type="checkbox" class="minimal" {{ $item->homepage_active==1 ? 'checked' : '' }} name="homepage_active">
                                        Hiển thị trang chủ
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group" id="select_brand_div">
                                <label>Hãng sản phẩm</label>
                                {!! Form::select(
                                    'brand_id',
                                    $brands,
                                    $item->brand_id,
                                    ['class'=>'form-control select2-single']
                                    );
                                !!}
                            </div>
                        </div>

                        @if($item_category->itemCategories->isNotEmpty())
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Loại {{ !empty($title) ? strtolower($title) : '' }}</label>
                                <select name="item_category_id" id="" class="form-control select2-single">
                                    @foreach ($item_category->itemCategories as $it_cat)
                                        <option value="{{ $it_cat->id }}" {{ $item->item_category_id == $it_cat->id ? 'selected' : '' }}>{{ $it_cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        @if ($item->colors->count() > 0)
                        <div class="col-md-12">
                            <div class="form-group" id="select_color_div">
                                <label>Màu đầu đốt</label>
                                {!! Form::select(
                                    'color_id[]',
                                    $colors,
                                    null,
                                    ['class'=>'form-control select2-multi', 'multiple'=>'multiple', 'id'=>'colorSelect']
                                    );
                                !!}
                            </div>
                        </div>
                        @endif

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tình trạng</label>
                                {!! Form::select(
                                    'item_status_id',
                                    $statuses,
                                    $item->item_status_id,
                                    ['class'=>'form-control select2-multi']
                                    );
                                !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="" class="custom-link" data-label="Hãng mới" data-type="brn"><strong>+ Hãng mới</strong></a>
                                <a href="" class="custom-link" data-label="Màu mới" data-type="clr"><strong>+ Màu mới</strong></a>
                            </div>
                            <div class="form-group">
                                <div class="alert alert-info alert-dismissable" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                                    Thêm thành công
                                </div>
                            </div>
                            <div class="form-group target-form" style="display:none">
                                <label class="tagert-label"></label>
                                <input type="hidden" id="target-type"/>
                                <input type="text" id="main-info" class="form-control"/>
                            </div>
                            <div class="form-group target-form" style="display:none">
                                <button id="main-submit" class="btn btn-sm btn-info pull-right" value="" disabled> Thêm mới</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {!! Form::close()!!}

        </div>
    </section>
    <div class="example-modal">
        <div class="modal fade item_modal" id="delete" role="dialog">
            <div class="modal-dialog delete-dialog" style="">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Xóa sản phẩm này?</h5>
                    </div>
                    <div class="modal-footer">
                        {!! Form::open(['method'=>'DELETE', 'action'=>['AdminItemsController@destroy', $item->slug], 'class'=>'form-horizontal']) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <input type="hidden" name="item_category" value="{{$item_category_slug}}">
                        {!! Form::submit('Xóa', ['class'=>'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($item->medias->isNotEmpty())
        <div class="example-modal">
            <div class="modal fade item_modal" id="slide_modal" role="dialog">
                <div class="modal-dialog modal-dialog-95">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <span>Slides details</span>
                                <div class="pull-right">
                                    <button type="button" class="btn-custom btn-default" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" id="selected_img">
                            @if($item->medias->isNotEmpty())
                                <div id="carousel-slide-details" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @for($i = 0; $i<count($item->medias);$i++)
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
                                            @foreach($item->medias as $media)
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
                                @foreach($item->medias as $media)
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('admin.items.include.media')
@endsection

@section('extendscripts')
    <script>
        $('.select2-multi').select2();
        $('.select2-single').select2();
        $('.removeSelectedImg').click(function(e){
            e.preventDefault();
            var id = $(this).attr('data-media-id');
            var item_id = '{{ $item->id }}';
            var token = $("input[name='_token']").val();
            if(confirm('Are you sure?'))
            {
                $.ajax({
                    url: "{{ route('admin.tank.remove_selected_img') }}",
                    method:'POST',
                    dataType:'json',
                    data: {media_id:id, _token:token, item_id:item_id},
                    success: function(data) {
                        if(data.error) {
                            window.location.reload(true);
                            $('#selected_img').html('');
                            $('#selected_img').html(data.data);
                        } else {
                            $('#selected_img').html('');
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
        $('#new_folder').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var token = $("input[name='_token']").val();
            var item_id = '{{ $item->id }}';
            var folder_name = $("input[name='folder_name']").val();
            var folder_id = $("input[name='folder_id']").val();
            if(folder_name == '') {
                alert('Trống tên');
            } else {
                $.ajax({
                    url: "{{ route('admin.folder.createItemAjax') }}",
                    method:'POST',
                    dataType:'json',
                    data: {folder_name:folder_name, _token:token, folder_id:folder_id, item_id:item_id},
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

        function getFolderByAjax(folder_slug, folder_id, token, item_id) {
            $.ajax({
                url: "{{ route('admin.folder.item.ajax.show') }}",
                method: 'POST',
                dataType: 'json',
                data: {folder_slug:folder_slug, folder_id:folder_id, _token:token, item_id:item_id},
                success: function (data) {
                    if(data.error) {
                        alert(data.mess);
                    } else {
                        $("#newFolder input[name='folder_id']").val(data.folder_id);
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
            var item_id = '{{ $item->id }}';
            var item_category_id = '{{ $item->item_category_id }}';
            var token = $("input[name='_token']").val();
            var folder_slug = $(this).attr('data-folder-slug');
            var folder_id = $(this).attr('data-folder-id');
            if(folder_id == null || folder_slug == null) {
                alert('Cant get this folder');
            } else {
                getFolderByAjax(folder_slug, folder_id, token, item_id, item_category_id);
            }
        });

        $('.custom').click(function (e) {
            e.preventDefault();
            var item_id = '{{ $item->id }}';
            var token = $("input[name='_token']").val();
            var folder_slug = $(this).attr('data-folder-slug');
            var folder_id = $(this).attr('data-folder-id');
            if(folder_id == null || folder_slug == null) {
                alert('Cant get this folder');
            } else {
                getFolderByAjax(folder_slug, folder_id, token, item_id);
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
            var item_id = '{{ $item->id }}';
            var token = $("input[name='_token']").val();
            $("#formUploadImage").trigger('submit');
        });

        $('#formUploadImage').on('submit', function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: "{{ route('admin.item.ajaxUpload') }}",
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
    @component('components.ajax_post')

    @endcomponent
@endsection