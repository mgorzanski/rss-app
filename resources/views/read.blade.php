@extends('layout')

@section('main')

<article class="box article-box" id="article-{{ $article->id }}" data-source="{{ $article->url }}">
	<div class="notif">
		<div class="notif-text"></div>
		<div class="notif-close"><a href="#" id="notif-close"><img src="/storage/images/icons/close.png" alt="Close"></a></div>
	</div>
	<p class="back-link"><a href="/">&#x25C0; Go back</a></p>
	<nav class="article-tools-nav">
		<ul class="article-tools-menu">
			<li><a href="#" id="view-source-link">View source</a></li>
			<li><a href="#" id="increase-font-size-link">Increase font size</a></li>
			<li><a href="#" id="decrease-font-size-link">Decrease font size</a></li>
			<li><a href="#" id="save-for-later">Save for later</a></li>
		</ul>
	</nav>
	<h3 class="article-title">{{ $article->title }}</h3>

	<div class="box-content">
		{!! $article->body !!}
	</div>
</article>

@endsection

@section('scripts')

<script src="{{ asset('js/Article.js') }}"></script>
<script>
	window.Laravel = {!! json_encode([
		'apiToken' => $api_token
	]) !!};
</script>

@endsection