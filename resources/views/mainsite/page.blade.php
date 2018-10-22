@extends('layouts.headerfooter')

@section('meta')
    <title>{{ $page->name }} | EC Distribution</title>
    
    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="{{ $page->name }} | EC Distribution">
    <meta itemprop="description" content="{{ $page->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('customer.account') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ $page->name }} | EC Distribution">
    <meta property="og:title" content="Tài khoản | EC Distribution" />
    <meta property="og:description" content="{{ $page->description }}" />
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
                        <div><a href="">Điều khoản chung</a></div>
                        <div><a href="" class="active">{{ $page->name }}</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="account-content">
                        <div class="term-title">Danh sách điều khoản</div>
                        <ul class="list_terms">
                            @foreach($footer_2nd_menu->pages as $pageslist)
                                <li><a href="/{{ $pageslist->slug }}">{{ $pageslist->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                      <h3>{{ $page->name }}</h3>
                      {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        var current = window.location.href;
        var temp = current.split("&");
        //alert(temp[0]);
        $('ul.list_terms li a').each(function() {
            var $this = $(this);
            if(this.href === temp[0] ){
                $this.parent().addClass('active');
                $this.parent().parent().parent().addClass('active');
            }
            //alert(this.href);
        });
    </script>
@endsection