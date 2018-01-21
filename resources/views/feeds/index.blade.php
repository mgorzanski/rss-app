@extends('layout')

@section('main')

<div class="box feeds-list-box">
	<p class="back-link"><a href="/">&#x25C0; @lang('layout.go-back-link')</a></p>
	<h3 class="box-title">@lang('subscription.my-subscriptions-title')</h3>

	<div class="box-content">
		<nav class="feeds-list-nav">
			<ul class="feeds-list-menu">
				@foreach ($feeds as $feed)
				<li class="list-feed-item">
					<div class="list-feed-item-drag-box">

					</div>
					@if (!empty($feed->favicon))
						<div class="list-feed-item-thumbnail">
							<img src="{{ $feed->favicon }}">
						</div>
					@endif
					<div class="list-feed-item-heading">
						<h6 class="list-feed-item-title"><a href="/browse/subscription/{{ $feed->id }}">{{ $feed->title }}</a></h6>
					</div>
					<div class="list-feed-item-actions">
						<p class="list-feed-item-action"><a href="/browse/feeds?action=refresh&subscriptionId={{ $feed->id }}"><img src="/storage/images/icons/refresh.png" alt="@lang('subscription.refresh-feed-alt')"></a></p>
						<p class="list-feed-item-action"><a href="/browse/feeds?action=edit&subscriptionId={{ $feed->id }}"><img src="/storage/images/icons/edit.png" alt="@lang('subscription.edit-feed-alt')"></a></p>
						<p class="list-feed-item-action"><a href="/browse/feeds?action=delete&subscriptionId={{ $feed->id }}"><img src="/storage/images/icons/delete.png" alt="@lang('subscription.delete-feed-alt')"></a></p>
					</div>
				</li>
				@endforeach
				<li class="list-feed-add">
					<a href="/browse/feeds?action=add">
						<div class="list-feed-add-icon">
							<img src="/storage/images/icons/add.png" alt="@lang('subscription.add-feed-alt')">
						</div>
						<div class="list-feed-add-title">
							<p>@lang('subscription.add-feed-btn')</p>
						</div>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>

@endsection