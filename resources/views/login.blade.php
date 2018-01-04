<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Today</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/css/login.css" rel="stylesheet">
    </head>
    <body>
        <header class="header">
            <h1 class="header-title">Today</h1>
        </header>
        <main class="main">
            <section class="login">
                <h2 class="section-title">Login</h2>
                <form action="/login" method="post">
                    <label>Login:</label>
                    <input type="text" name="name">
                    <label>Password:</label>
                    <input type="password" name="password">
                    {{ csrf_field() }}
                    <button type="submit">Login</button>
                </form>
            </section>
            <section class="register">
                <h2 class="section-title">Register</h2>
                <form action="/register" method="post">
                    <label>Login:</label>
                    <input type="text" name="name">
                    <label>E-mail:</label>
                    <input type="email" name="email">
                    <label>Password:</label>
                    <input type="password" name="password">
                    <label>Repeat password:</label>
                    <input type="password" name="repeat_password">
                    {{ csrf_field() }}
                    <button type="submit">Register</button>
                </form>
            </section>
        </main>
    </body>
</html>