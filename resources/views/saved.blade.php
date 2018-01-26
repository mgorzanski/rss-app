@extends('layout')

@section('main')

<div class="box saved-list-box">
	<p class="back-link"><a href="/">&#x25C0; @lang('layout.go-back-link')</a></p>
	<h3 class="box-title">@lang('saved.title')</h3>

	<div class="box-content">
        @if (empty($savedArticles))
            <div class="box-content-description">
                @lang('saved.box-content-description')
            </div>
        @else
		<nav class="saved-list-nav">
			<ul class="saved-list-menu">
				@foreach ($savedArticles as $savedArticle)
				<li class="saved-item">
					@if (!empty($savedArticle->subscription_favicon))
						<div class="saved-item-thumbnail">
							<img src="{{ $savedArticle->subscription_favicon }}">
						</div>
					@endif
					<div class="saved-item-heading">
						<h6 class="saved-item-title"><a href="/browse/article/{{ $savedArticle->saved_article_id }}">{{ $savedArticle->article_title }}</a></h6>
					</div>
					<div class="saved-item-actions">
						<p class="saved-item-action"><a href="/browse/saved?delete&articleId={{ $savedArticle->saved_article_id }}&savedArticleId={{ $savedArticle->saved_id }}"><img src="/storage/images/icons/delete.png" alt="@lang('saved.delete-saved-article-alt')"></a></p>
					</div>
				</li>
				@endforeach
			</ul>
        </nav>
        @endif
	</div>
</div>

@endsection

@section('scripts')

<script>
	window.Laravel = {!! json_encode([
		'apiToken' => $api_token
	]) !!};
</script>

@endsection