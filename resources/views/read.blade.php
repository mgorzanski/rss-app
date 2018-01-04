@extends('layout')

@section('main')

<article class="box article-box" id="article-{{ $article->id }}" data-source="{{ $article->url }}">
	<p class="back-link"><a href="/">&#x25C0; Go back</a></p>
	<nav class="article-tools-nav">
		<ul class="article-tools-menu">
			<li><a href="#" id="view-source-link">View source</a></li>
			<li><a href="#" id="increase-font-size-link">Increase font size</a></li>
			<li><a href="#" id="decrease-font-size-link">Decrease font size</a></li>
			<li><a href="#" id="add-to-pocket-link">Add to Pocket</a></li>
		</ul>
	</nav>
	<h3 class="article-title">{{ $article->title }}</h3>

	<div class="box-content">
		{!! $article->body !!}
	</div>
</article>

@endsection

@section('scripts')

<script src="/js/Article.js"></script>

@endsection