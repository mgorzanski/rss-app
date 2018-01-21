@extends('layout')

@section('main')
<section class="box search-box">
	<p class="back-link"><a href="/">&#x25C0; @lang('layout.go-back-link')</a></p>
	<form class="search-form" action="/search" method="get">
		<input type="search" class="search-input" name="query" placeholder="@lang('feed.search-placeholder')" value="{{ $q }}">
        @if($subscription_id != null)
		<input type="hidden" name="subscriptionId" value="{{ $subscription_id }}">
        @endif
		<button type="button" class="refresh-btn" id="refresh-button">@lang('feed.refresh-btn')</button>
	</form>
</section>

<section class="box my-feed-box">
	<h3 class="box-title">@lang('feed.search-results-for') "{{ $q }}"</h3>
	<div class="box-content">
		@php
			$id = 0;
		@endphp

		@foreach($articles as $article)

		@php
			$id++;
		@endphp
		<article class="feed-article" id="feed-item-{{ $id }}">
			<a href="/browse/article/{{ $article->id }}">
				@if (!empty($article->subscription_favicon))
					<div class="feed-article-subscription-thumbnail">
						<img src="{{ $article->subscription_favicon }}">
					</div>
				@endif
				<div class="feed-article-heading">
					<h4 class="feed-article-title">{{ $article->title }}</h4>
				</div>
				<div class="feed-article-intro">
					<p>{{ $article->summary }}</p>
				</div>
				<div class="feed-article-meta">
					@php
						$article->datetime = substr($article->datetime, 0, -3);
					@endphp
					<p>{{ $article->subscription_title }}, {{ $article->datetime }}</p>
				</div>
			</a>
		</article>
		@endforeach
		<div class="more-articles-btn"><a href="#" id="load-articles" class="more-articles-link" data-id="{{ $records }}">@lang('feed.load-more-articles-btn')</a></div>
	</div>
</section>
@endsection

@section('scripts')

<script>
	window.Laravel = {!! json_encode([
		'apiToken' => $api_token
	]) !!};

	window.Lang = {!! json_encode([
		'loadingArticlesLabel'	=>	__('feed.loading-articles-label'),
		'noMoreArticlesLabel'	=>	__('feed.no-more-articles-label')
	]) !!};
</script>

@endsection