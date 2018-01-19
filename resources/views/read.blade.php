@extends('layout')

@section('main')

<article class="box article-box" id="article-{{ $article->id }}" data-source="{{ $article->url }}">
	<div class="notif">
		<div class="notif-text"></div>
		<div class="notif-close"><a href="#" id="notif-close"><img src="/storage/images/icons/close.png" alt="@lang('article.notif-close')"></a></div>
	</div>
	<p class="back-link"><a href="/">&#x25C0; @lang('layout.go-back-link')</a></p>
	<nav class="article-tools-nav">
		<ul class="article-tools-menu">
			<li><a href="#" id="view-source-link">@lang('article.view-source-link')</a></li>
			<li><a href="#" id="increase-font-size-link">@lang('article.increase-font-size-link')</a></li>
			<li><a href="#" id="decrease-font-size-link">@lang('article.decrease-font-size-link')</a></li>
			<li><a href="#" id="save-for-later">@lang('article.save-for-later-link')</a></li>
		</ul>
	</nav>
	<h3 class="article-title">{{ $article->title }}</h3>

	<div class="box-content">
		{!! $article->body !!}
	</div>
</article>

@endsection

@section('scripts')

<script>
		window.Laravel = {!! json_encode([
			'apiToken' => $api_token
		]) !!};
		window.Lang = {!! json_encode([
			'notifSuccess'	=>	__('article.notif-success'),
			'notifFailed'	=>	__('article.notif-failed')
		]) !!};
	</script>
<script src="{{ asset('js/Article.js') }}"></script>

@endsection