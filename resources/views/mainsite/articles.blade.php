@extends('layouts.headerfooter')

@section('meta')
    <title>EC Distribution</title>
    

    <!-- seo thong thuong-->
    <title>{{ $page->name }} - EC Distribution</title>
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $page->description }}" />
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
    <meta property="og:url" content="{{ route('articles.index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="{{ $page->name }} | EC Distribution" />
    <meta property="og:description" content="{{ $page->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    {{ $settings->google_id }}
    {{ $settings->webmaster }}

@endsection

@section('content')
	<section class="section-blog">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
	                <div class="page-breadcrumb">
	                    <div><a href="{{ route('index') }}">Trang chủ</a></div>
	                    <div><a href="{{ route('articles.index') }}" class="active">{{ $page->name }}</a></div>
	                </div>
	            </div>
			</div>
			<div class="row">
				@foreach($articles as $article)
				<div class="col-lg-4">
					<a href="/review-blog/{{ $article->slug }}"><img class="img-responsive" src="{{ asset($article->media()->first()->url) }}" alt=""></a>
                    <h5 class="blog-title">{{ $article->title }}</h5>
                    <p>{{ str_limit($article->summary, 110) }}</p>
                    <a href="/review-blog/{{ $article->slug}}">Xem thêm >></a>
				</div>
				@endforeach
			</div>
	</section>
@endsection