<!DOCTYPE html>
<html>
<head>
	<title>Today</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<header class="header">
		<div class="heading">
			<h2 class="title"><a href="/">Today</a></h2>
		</div>

		<nav class="day-night-switch">
			<!--<p class="switch-title">Night Mode</p>
			<div class="onoffswitch">
			    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
			    <label class="onoffswitch-label" for="myonoffswitch">
			        <span class="onoffswitch-inner"></span>
			        <span class="onoffswitch-switch"></span>
			    </label>
			</div>-->
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