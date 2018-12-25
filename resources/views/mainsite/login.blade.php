@extends('layouts.headerfooter')

@section('meta')
    <title>Đăng nhập | EC Distribution</title>


    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Đăng nhập | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Đăng nhập | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

@endsection

@section('content')
    <section class="section-login">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        <div><a href="{{ route('customer.login') }}" class="active">Đăng nhập</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    @if(session('status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-title">
                        <h5>Đăng nhập</h5>
                    </div>
                    <div class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Đăng nhập bằng facebook</div>
                    <div style="margin-top:15px">- hoặc đăng nhập bằng tài khoản tại EC</div>
                    {!! Form::open(['method'=>'POST', 'action'=>"CustomerLoginController@login", 'class'=>'form-login']) !!}
                        <div class="form-group {{ $errors->has('login') ? ' has-error' : '' }}">
                            {!! Form::label('login', 'Email hoặc số điện thoại:', ['class' => 'control-label'] ) !!}
                            {!! Form::text('login', null, ['class'=>'form-control']) !!}
                            @if ($errors->has('login'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('login') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password_login') ? ' has-error' : '' }}">
                            {!! Form::label('password', 'Mật khẩu', ['class' => 'control-label'] ) !!}
                            {!! Form::password('password_login', ['class'=>'form-control']) !!}
                            @if ($errors->has('password_login'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_login') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="checkbox">
                            <label style="font-size:12px">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                Nhớ đăng nhập
                            </label>
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Đăng nhập', ['class'=>'btn btn-primary btn-login']) !!}
                        </div>

                    {!! Form::close()!!}
                </div>
                <div class="col-lg-6 col-lg-offset-1">
                    <div class="form-title">
                        <h5>Đăng ký</h5>
                    </div>
                    <div style="margin-top:15px">Đăng ký tài khoản tại EC Distribution nếu bạn là khách hàng mới</div>
                    {!! Form::open(['method'=>'POST', 'action'=>"CustomerRegisterController@register", 'class'=>'form-login']) !!}
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Họ tên khách hàng', ['class' => 'control-label'] ) !!}
                            {!! Form::text('name', null, ['class'=>'form-control']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email_register', 'Email', ['class' => 'control-label'] ) !!}
                            {!! Form::email('email', null, ['class'=>'form-control']) !!}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('phonenumber') ? ' has-error' : '' }}">
                            {!! Form::label('phonenumber', 'Số điện thoại', ['class' => 'control-label'] ) !!}
                            {!! Form::text('phonenumber', null, ['class'=>'form-control']) !!}
                            @if ($errors->has('phonenumber'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phonenumber') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password', 'Mật khẩu', ['class' => 'control-label'] ) !!}
                            {!! Form::password('password', ['class'=>'form-control','id'=>'password']) !!}
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Đăng ký', ['class'=>'btn btn-primary btn-login']) !!}
                        </div>

                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </section>
@endsection