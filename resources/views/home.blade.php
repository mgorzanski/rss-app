@extends('layout')

@section('main')
<section class="box search-box">
	<form class="search-form" action="/search" method="get">
		<input type="search" class="search-input" name="query" placeholder="Search...">
		<button type="button" class="refresh-btn" id="refresh-button">Refresh</button>
	</form>
</section>

<section class="box feeds-box">
	<h3 class="box-title">Feeds</h3>
	<p class="box-more-link"><a href="/browse/feeds">view all &#x25B6;</a></p>

	<div class="box-content">
		<nav class="items-nav">
			<ul class="items-menu">
				@foreach($subscriptions as $subscription)
				<li class="menu-item">
					<a href="/browse/subscription/{{ $subscription->id }}">
						<div class="menu-item-thumbnail">
							<img src="{{ $subscription->favicon }}" alt="{{ $subscription->title }}">
						</div>
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
	<h3 class="box-title">Timeline</h3>
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
				<div class="feed-article-subscription-thumbnail">
					<img src="{{ $article->subscription_favicon }}" alt="{{ $article->subscription_title }}">
				</div>
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
		<a href="#" id="load-articles" data-id="15"><div class="more-articles-btn">Load more</div></a>
	</div>
</section>
@endsection
