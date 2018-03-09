@extends('layout')

@section('main')
<section class="box search-box">
	<form class="search-form" action="/search" method="get">
		<input type="search" class="search-input" name="query" placeholder="@lang('feed.search-placeholder')">
		<button type="button" class="refresh-btn" id="refresh-button">@lang('feed.refresh-btn')</button>
	</form>
</section>

<section class="box feeds-box">
	<h3 class="box-title">@lang('feed.box-title-feeds')</h3>
	<p class="box-more-link"><a href="/browse/feeds">@lang('feed.view-all-subscriptions-link') &#x25B6;</a></p>

	<div class="box-content">
		<nav class="items-nav">
			<ul class="items-menu">
				@foreach($subscriptions as $subscription)
				<li class="menu-item">
					<a href="/browse/subscription/{{ $subscription->id }}">
						@if (!empty($subscription->favicon))
							<div class="menu-item-thumbnail">
								<img src="{{ $subscription->favicon }}">
							</div>
						@endif
						<div class="menu-item-title">
							<p><a href="/browse/subscription/{{ $subscription->id }}">{{ $subscription->title }}</a></p>
						</div>
					</a>
				</li>
				@endforeach
			</ul>
		</nav>
	</div>
</section>

<section class="box my-feed-box">
	<h3 class="box-title">@lang('feed.box-title-timeline')</h3>
	<div class="box-content">
		@php
			$id = 0;
			$lastArticleTimestamp;
		@endphp

		@foreach($articles as $article)

		@php
			$dt = new DateTime($article->datetime);
			$dt->format('Y-m-d H:i:s');
			$dt->setTime(0, 0, 0);
			$article->timestamp = $dt->getTimestamp();
			$article->day = new DateTime($article->datetime);
			$article->day = $months[$article->day->format('D')];
			$article->date = new DateTime($article->datetime);
			$article->date = $article->date->format('Y-m-d');
		@endphp

		@if (!empty($lastArticleTimestamp) && $article->timestamp < $lastArticleTimestamp)
			<section class="day-divider">
				<h4 class="day-divider__date">{{ $article->day }}, {{ $article->date }}</h4>
			</section>
		@endif

		@php
			$id++;
			$lastArticleTimestamp = $article->timestamp;
		@endphp
		<article class="feed-article" id="feed-item-{{ $id }}">
			@if ($settings['always_open_source_of_article'] === 'on')
			<a href="{{ $article->url }}">
			@else
			<a href="/browse/article/{{ $article->id }}">
			@endif
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
		<div class="more-articles-btn"><a href="#" id="load-articles" class="more-articles-link" data-id="15">@lang('feed.load-more-articles-btn')</a></div>
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

	window.UseScripts = ['loadDataAjax'];

	var refresh = document.querySelector('#refresh-button');
	refresh.addEventListener('click', function () {
		window.location.reload();
	});
</script>

@endsection