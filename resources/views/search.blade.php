@extends('layout')

@section('main')
<section class="box search-box">
	<p class="back-link"><a href="/">&#x25C0; Go back</a></p>
	<form class="search-form" action="/search" method="get">
		<input type="search" class="search-input" name="query" placeholder="Search..." value="{{ $q }}">
        @if($subscription_id != null)
		<input type="hidden" name="subscriptionId" value="{{ $subscription_id }}">
        @endif
		<button type="button" class="refresh-btn" id="refresh-button">Refresh</button>
	</form>
</section>

<section class="box my-feed-box">
	<h3 class="box-title">Search results for... "{{ $q }}"</h3>
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
