@extends('layouts.headerfooter')

@section('meta')
    <title>404| EC Distribution</title>

    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Tìm kiếm | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="404 | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />


@endsection

@section('content')
    <section class="section-items">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-breadcrumb">
                        <div><a href="{{ route('index') }}">Trang chủ</a></div>
                        <div><a href="" class="active">404</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div style="height:100%" class="col-lg-12 empty-item">
                    <p>
                        404 Không tìm thấy được trang này!
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection