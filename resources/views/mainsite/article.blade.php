@extends('layouts.headerfooter')

@section('meta')
    <title>EC Distribution</title>

    <!-- seo thong thuong-->
    <title>{{ $page->name }} | EC Distribution</title>
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $article->summary }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="{{ $page->name }} | EC Distribution">
    <meta itemprop="description" content="{{ $page->summary }}">
    <meta itemprop="image" content="{{ !empty($article->media->first()) ? asset($article->media->first()->url) : asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('article.single',[$article->slug]) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="{{ $article->title }} | EC Distribution" />
    <meta property="og:description" content="{{ $article->summary }}" />
    <meta property="og:image" content="{{ !empty($article->media->first()) ? asset($article->media->first()->url) : asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    {{ $settings->google_id }}
    {{ $settings->webmaster }}

@endsection

@section('content')
	<section class="section-article">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-8">
					<h5 class="blog-title">{{ $article->title }}</h5>
					<div class="time-publish"><i class="fa fa-calendar"></i> Ngày đăng:{{ date("j/n/Y", strtotime($article->created_at)) }}</div>
					<a href="/review-blog/{{ $article->slug }}">
                        @if(!empty($article->media->first()))
                        <img class="img-responsive" src="{{ asset($article->media()->first()->url) }}" alt="">
                            @else
                            <img class="img-responsive" src="https://via.placeholder.com/750x340?text=No+image" alt="">
                        @endif
                    </a>
                    {!! $article->content !!}
                    <div class="article-cat">Loại bài viết: <em>{{ $article->category->name }}</em></div>
                    <div class="article-tags">Tags:
                    	@foreach($article->tags as $tag)
							<a href="">#{{ $tag->name }}</a>
                    	@endforeach
                    </div>
				</div>

				<div class="col-sm-12 col-md-4 col-lg-4">
					<div class="article-relate-section">
						<div class="title">Bài viết liên quan</div>
						<div class="title-hr"></div>
					</div>
					@foreach($random_articles as $article)
					<div class="article-related-item">
						<a href="/review-blog/{{ $article->slug }}">
                            @if(!empty($article->media->first()))
                            <img class="img-responsive" src="{{ asset($article->media()->first()->url) }}" alt="">
                                @else
                                <img class="img-responsive" src="https://via.placeholder.com/360x163?text=No+image" alt="">
                            @endif
                        </a>
	                    <h5 class="article-relate-title">{{ $article->title }}</h5>
					</div>
                    @endforeach
				</div>
			</div>
	</section>
@endsection