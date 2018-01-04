@extends('layout')

@section('main')

<div class="box feeds-list-box">
	<p class="back-link"><a href="/">&#x25C0; Go back</a></p>
	<h3 class="box-title">My subscriptions</h3>

	<div class="box-content">
		<nav class="feeds-list-nav">
			<ul class="feeds-list-menu">
				@foreach ($feeds as $feed)
				<li class="list-feed-item">
					<div class="list-feed-item-drag-box">

					</div>
					<div class="list-feed-item-thumbnail">
						<img src="{{ $feed->favicon }}" alt="{{ $feed->title }}">
					</div>
					<div class="list-feed-item-heading">
						<h6 class="list-feed-item-title"><a href="/browse/subscription/{{ $feed->id }}">{{ $feed->title }}</a></h6>
					</div>
					<div class="list-feed-item-actions">
						<p class="list-feed-item-action"><a href="/browse/feeds?action=refresh&subscriptionId={{ $feed->id }}"><img src="/storage/images/icons/refresh.png" alt="Refresh"></a></p>
						<p class="list-feed-item-action"><a href="/browse/feeds?action=edit&subscriptionId={{ $feed->id }}"><img src="/storage/images/icons/edit.png" alt="Edit"></a></p>
						<p class="list-feed-item-action"><a href="/browse/feeds?action=delete&subscriptionId={{ $feed->id }}"><img src="/storage/images/icons/delete.png" alt="Delete"></a></p>
					</div>
				</li>
				@endforeach
				<li class="list-feed-add">
					<a href="/browse/feeds?action=add">
						<div class="list-feed-add-icon">
							<img src="/storage/images/icons/add.png" alt="Add">
						</div>
						<div class="list-feed-add-title">
							<p>Add new feed</p>
						</div>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>

@endsection
