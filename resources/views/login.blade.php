<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Today</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    </head>
    <body>
        <header class="header">
            <h1 class="header-title">Today</h1>
        </header>
        <main class="main">
            <section class="login">
                <h2 class="section-title">@lang('login.login-heading')</h2>
                <form action="/login" method="post">
                    <label>@lang('login.login-label')</label>
                    <input type="text" name="name">
                    <label>@lang('login.password-label')</label>
                    <input type="password" name="password">
                    {{ csrf_field() }}
                    <p class="remember-label"><input type="checkbox" name="remember"> @lang('login.remember')</p>
                    <button type="submit">@lang('login.login-btn')</button>
                </form>
            </section>
            <section class="register">
                <h2 class="section-title">@lang('login.register-heading')</h2>
                <form action="/register" method="post">
                    <label>@lang('login.login-label')</label>
                    <input type="text" name="name">
                    <label>@lang('login.email-label')</label>
                    <input type="email" name="email">
                    <label>@lang('login.password-label')</label>
                    <input type="password" name="password">
                    <label>@lang('login.repeat-password-label')</label>
                    <input type="password" name="repeat_password">
                    {{ csrf_field() }}
                    <button type="submit">@lang('login.register-btn')</button>
                </form>
            </section>
        </main>
    </body>
</html>