@extends('layouts.headerfooter')

@section('meta')
    <title>Tài khoản | EC Distribution</title>
    
    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Tài khoản | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('customer.account') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Tài khoản | EC Distribution">
    <meta property="og:title" content="Tài khoản | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    {{ $settings->google_id }}
    {{ $settings->webmaster }}

@endsection

@section('content')
    <section class="section-account">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        <div><a href="{{ route('customer.account') }}">{{ Auth::user()->name }}</a></div>
                        <div><a href="{{ route('customer.account') }}" class="active">Thông tin cá nhân</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <ul class="acount-link-setting">
                        <li><a href="{{ route('customer.account') }}" class="active">Thông tin tài khoản</a></li>
                        <li><a href="{{ route('customer.orders') }}">Lịch sử mua hàng</a></li>
                        <li>
                            <a href="{{ route('customer.logout') }}"
                             onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>

                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    @if(session('status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="account-content">
                        <h3>Thông tin tài khoản</h3>
                        <div class="account-title">Thông tin cơ bản</div>
                        {!! Form::open(['method'=>'PUT', 'action'=>['CustomerController@update'], 'class'=>'form-horizontal']) !!}
                      
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                {!! Form::label('name', 'Họ tên khách hàng:', ['class' => 'col-sm-3 control-label'] ) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('name', Auth::user()->name, ['class'=>'form-control']) !!}
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::label('email', 'Email:', ['class' => 'col-sm-3 control-label'] ) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('email', Auth::user()->email, ['class'=>'form-control']) !!}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('phonenumber') ? ' has-error' : '' }}">
                                {!! Form::label('phonenumber', 'Số điện thoại:', ['class' => 'col-sm-3 control-label'] ) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('phonenumber', Auth::user()->phonenumber, ['class'=>'form-control']) !!}
                                    @if ($errors->has('phonenumber'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phonenumber') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sửa mật khẩu:</label>
                                <div class="col-sm-8" style="padding-top:8px">
                                    <input type="checkbox" value="1" name="change_password" id="change_password">
                                </div>
                            </div>
                            <div id="password-hiddenForm" style="display:none">
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    {!! Form::label('password', 'Password:', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::password('password', ['class'=>'form-control']) !!}
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('password_confirmation', 'Confirm Password:', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-11">
                                    {!! Form::submit('Lưu thay đổi', ['class'=>'btn btn-primary pull-right']) !!}
                                </div>
                            </div>

                        {!! Form::close() !!}

                        <div class="account-title">Thông tin phụ (nếu có)</div>
                        {!! Form::open(['method'=>'PUT', 'action'=>['CustomerController@customInfoUpdate'], 'class'=>'form-horizontal']) !!}
                      
                            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                {!! Form::label('address', 'Địa chỉ giao hàng:', ['class' => 'col-sm-3 control-label'] ) !!}
                                <div class="col-sm-8">
                                    {!! Form::textarea('address', $customer->customerInfo['address'], ['class'=>'form-control','rows'=>'3']) !!}
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                <div class="col-sm-5 col-sm-offset-1">
                                    {!! Form::label('city_id', 'Thành phố:', ['class' => 'control-label'] ) !!}
                                    @if($customer->customerInfo->city_id == 0)
                                        {!! Form::select(
                                            'city_id',
                                            $cities,
                                            null,
                                            ['class'=>'form-control','placeholder'=>'-- Tỉnh/Thành phố --','id'=>'select_city']
                                            );
                                        !!}
                                    @else
                                        
                                        {!! Form::select(
                                            'city_id',
                                            $cities,
                                            $customer->customerInfo->city->id,
                                            ['class'=>'form-control','id'=>'select_city']
                                            );
                                        !!}
                                    @endif
                                    @if ($errors->has('city_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('city_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-5">
                                    {!! Form::label('district_id', 'Quận:', ['class' => 'control-label'] ) !!}
                                    @if($customer->customerInfo->district_id == 0)
                                        <select name="district_id" id="select_district" class="form-control">
                                            <option value="">-- Quận/Huyện --</option>
                                        </select>
                                    @else
                                        {!! Form::select(
                                            'district_id',
                                            $districts,
                                            $customer->customerInfo->district->id,
                                            ['class'=>'form-control','id'=>'select_district']
                                            );
                                        !!}
                                    @endif
                                    @if ($errors->has('district_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('district_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-11">
                                    {!! Form::submit('Lưu thay đổi', ['class'=>'btn btn-primary pull-right']) !!}
                                </div>
                            </div>

                        {!! Form::close() !!}
                    </div>   
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('#select_city').change(function(event) {
            var $this = $(this);
            var city_id = $this.val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('districts.list') }}",
                method:'POST',
                dataType:'json',
                data: {city_id:city_id, _token:token},
                success: function(data) {
                    $('#select_district').html('');
                    $('#select_district').html(data.option);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.status);
                   console.log(xhr.responseText);
                   console.log(thrownError);
               }
            });
        });

        $('#change_password').change(function() {
            if(this.checked) {
                //Do stuff
                $('#password-hiddenForm').show();
            }
            else
            {
                $('#password-hiddenForm').hide();
            }
        });
    </script>
@endsection