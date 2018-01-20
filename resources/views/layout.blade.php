<!DOCTYPE html>
<html>
<head>
	<title>Today</title>
	<script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<header class="header">
		<div class="heading">
			<h2 class="title"><a href="/">Today</a></h2>
		</div>

		<nav class="header-nav">
			<ul class="header-menu">
				@if (Request::is('/'))
					<li class="header-menu-link header-menu-link-active"><a href="/"><i class="fas fa-home"></i>&nbsp;@lang('layout.home-link')</a></li>
				@else
					<li class="header-menu-link"><a href="/"><i class="fas fa-home"></i>&nbsp;@lang('layout.home-link')</a></li>
				@endif

				@if (Request::is('browse/feeds'))
					<li class="header-menu-link header-menu-link-active"><a href="/browse/feeds"><i class="fas fa-list-alt"></i>&nbsp;@lang('layout.feeds-link')</a></li>
				@else
					<li class="header-menu-link"><a href="/browse/feeds"><i class="fas fa-list-alt"></i>&nbsp;@lang('layout.feeds-link')</a></li>
				@endif

				@if (Request::is('browse/saved'))
					<li class="header-menu-link header-menu-link-active"><a href="/browse/saved"><i class="far fa-bookmark"></i>&nbsp;@lang('layout.saved-link')</a></li>
				@else
					<li class="header-menu-link"><a href="/browse/saved"><i class="far fa-bookmark"></i>&nbsp;@lang('layout.saved-link')</a></li>
				@endif

				@if (Request::is('user/profile'))
					<li class="header-menu-link header-menu-link-active"><a href="/user/profile"><i class="fas fa-user"></i>&nbsp;@lang('layout.account-link')</a></li>
				@else
					<li class="header-menu-link"><a href="/user/profile"><i class="fas fa-user"></i>&nbsp;@lang('layout.account-link')</a></li>
				@endif

				@if (Request::is('settings'))
					<li class="header-menu-link header-menu-link-active"><a href="/settings"><i class="fas fa-sliders-h"></i>&nbsp;@lang('layout.settings-link')</a></li>
				@else
					<li class="header-menu-link"><a href="/settings"><i class="fas fa-sliders-h"></i>&nbsp;@lang('layout.settings-link')</a></li>
				@endif

				@if (Request::is('logout'))
					<li class="header-menu-link header-menu-link-active"><a href="/logout"><i class="fas fa-sign-out-alt"></i></a></li>
				@else
					<li class="header-menu-link"><a href="/logout"><i class="fas fa-sign-out-alt"></i></a></li>
				@endif
			</ul>
		</nav>
	</header>

	<main class="main">
		<div class="center-wrapper">
			@yield('main')
		</div>
	</main>

	<script src="{{ asset('js/app.js') }}"></script>
	@yield('scripts')
</body>
</html>