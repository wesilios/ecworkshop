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
            {{ !empty($title) ? $title : '' }} mới
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.items.index',['item_category'=>$item_category->slug]) }}">Tất cả {{ !empty($title) ? strtolower($title) : '' }}</a></li>
            <li class="active">{{ !empty($title) ? $title : '' }} mới</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            {!! Form::open(['method'=>'POST', 'action'=>['AdminItemsController@store',$item_category->slug], 'class'=>'form-horizontal', 'files'=>true]) !!}
            <div class="col-md-9">
                <!-- Horizontal Form -->
                <div class="box">
                    <!-- form start -->
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                {!! Form::label('name', 'Tên sản phẩm:', ['class' => 'control-label'] ) !!}
                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Insert name']) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('name') }}</strong>
						                </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                {!! Form::label('price', 'Giá gốc:', ['class' => 'control-label'] ) !!}
                                {!! Form::number('price', null, ['class'=>'form-control', 'placeholder'=>'Insert price']) !!}
                                @if ($errors->has('price'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('price') }}</strong>
						                </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('price_off') ? ' has-error' : '' }}">
                                {!! Form::label('price_off', 'Giá giảm:', ['class' => 'control-label'] ) !!}
                                {!! Form::number('price_off', null, ['class'=>'form-control', 'placeholder'=>'']) !!}
                                @if ($errors->has('price_off'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('price_off') }}</strong>
						                </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
                                {!! Form::label('summary', 'Tóm tắt sản phẩm:', ['class' => 'control-label'] ) !!}
                                {!! Form::textarea('summary', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                                @if ($errors->has('summary'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('summary') }}</strong>
						                </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                {!! Form::label('description', 'Miêu tả sản phẩm:', ['class' => 'control-label'] ) !!}
                                {!! Form::textarea('description', null, ['class'=>'form-control textarea']) !!}
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
            <div class="col-md-3">
                <div class="box">
                    <div class="box-body">
                        <div><strong>Ngày đăng:</strong>  N/A</div>
                        <div><strong>Ngày cập nhật:</strong>  N/A</div>
                        <div><strong>Đăng bởi:</strong>  {{ Auth::user()->name }}</div>
                    </div>
                    <div class="box-footer">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::submit('Đăng', ['class'=>'btn btn-success pull-right']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label class="control-label">
                                        <input type="checkbox" class="minimal" checked name="homepage_active">
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
                                    null,
                                    ['class'=>'form-control select2-single']
                                    );
                                !!}
                                @if ($errors->has('category_id'))
                                    <span class="help-block">
						                    <strong>{{ $errors->first('category_id') }}</strong>
						                </span>
                                @endif
                            </div>
                        </div>

                        @if($item_category->itemCategories->isNotEmpty() && $item_category->itemCategoryChild->id == $item_category->id && $item_category->itemCategories->count() ==1)
                            <input type="hidden" name="item_category_parent_id" value="{{$item_category->id}}">
                            <input type="hidden" name="item_category_id" value="{{$item_category->id}}">
                        @else
                            <input type="hidden" name="item_category_parent_id" value="{{$item_category->id}}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Loại {{ !empty($title) ? strtolower($title) : '' }}</label>
                                    <select name="item_category_id" id="" class="form-control select2-multi">
                                        @foreach($item_category->itemCategories as $it_cat)
                                            <option value="{{$it_cat->id}}">{{$it_cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        @php $features = json_decode($item_category->item_cat_features,true) @endphp
                        @if(!empty($features['color']))
                            <div class="col-md-12">
                                <div class="form-group" id="select_color_div">
                                    <label>Màu {{ !empty($title) ? strtolower($title) : '' }}</label>
                                    {!! Form::select(
                                        'color_id[]',
                                        $colors,
                                        null,
                                        ['class'=>'form-control select2-multi', 'multiple'=>'multiple']
                                        );
                                    !!}
                                </div>
                            </div>
                        @endif

                        @if(!empty($features['size']))
                            <div class="col-md-12">
                                <div class="form-group" id="select_juice_size_div">
                                    <label>Dung tích</label>
                                    {!! Form::select(
                                        'size_id',
                                        $juice_sizes,
                                        null,
                                        ['class'=>'form-control select2-multi']
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
                                    null,
                                    ['class'=>'form-control select2-multi']
                                    );
                                !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="" class="custom-link" data-label="Hãng mới" data-type="brn"><strong>+ Hãng mới</strong></a>
                                @if(!empty($features['color']))
                                    <a href="" class="custom-link" data-label="Màu mới" data-type="clr"><strong>+ Màu mới</strong></a>
                                @endif
                                @if(!empty($features['size']))
                                    <a href="" class="custom-link" data-label="Dung tích mới" data-type="sze"><strong>+ Dung tích mới</strong></a>
                                @endif
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
@endsection

@section('extendscripts')
    <script>
        $('.select2-multi').select2();
        $('.select2-single').select2();
    </script>

    @component('components.ajax_post')

    @endcomponent
@endsection
