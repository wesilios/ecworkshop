@extends('layouts.headerfooter')

@section('meta')
    <title>Contact | EC Distribution</title>

    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Contact | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Contact | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

@endsection

@section('content')
    <section class="section-account">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        <div><a href="{{ route('contact') }}">Liên hệ</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <p>{{ $page->description ? $page->description : '' }}</p>
                    {!! $page->content ? $page->content : '' !!}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    @if(session('status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="account-content">
                        <h3>Liên hệ với chúng tôi</h3>
                        <div class="account-title">Thông tin cơ bản</div>
                        <form action="{{route('contact.post')}}" class="form-horizontal" id="contact-form" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Họ và tên</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-3 control-label">Số điện thoại</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message" class="col-sm-3 control-label">Tin nhắn</label>
                                <div class="col-sm-8">
                                    <textarea rows="5" class="form-control" name="message" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-11">
                                    <button class="btn btn-primary pull-right" id="submit">Gửi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#submit').on('click change',function (e) {
                e.preventDefault();
                var route = "{{ route('contact.post') }}";
                var data = new FormData($('#contact-form')[0]);
                $.ajax({
                    url: route,
                    type: "POST",
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (data) {
                        console.log(data);
                    }
                })
            })
        })
    </script>
@endsection
