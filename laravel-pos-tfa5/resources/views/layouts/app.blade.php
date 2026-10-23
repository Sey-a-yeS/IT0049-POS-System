<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A four-page Laravel point-of-sale demonstration for IT0049 TFA5.">
    <title>@yield('title') | Counterpoint POS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a class="skip-link" href="#content">Skip to content</a>
    <div class="site-shell">
        <header class="site-header">
            <div class="header-inner">
                <a class="brand" href="{{ route('home') }}" aria-label="Counterpoint POS home"><span class="brand-mark" aria-hidden="true">C<span>.</span></span><span><strong>Counterpoint</strong><small>POS / LARAVEL EDITION</small></span></a>
                <nav aria-label="Main navigation"><ul class="nav-list">
                    <li><a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Home</a></li>
                    <li><a href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>About</a></li>
                    <li><a href="{{ route('customers.index') }}" @if(request()->routeIs('customers.index')) aria-current="page" @endif>Customer Accounts</a></li>
                    <li><a href="{{ route('users.index') }}" @if(request()->routeIs('users.index')) aria-current="page" @endif>User Accounts</a></li>
                </ul></nav>
            </div>
        </header>
        <main id="content" class="main-content">@yield('content')</main>
        <footer class="site-footer"><span>Counterpoint POS</span><span>IT0049 · Technical Formative Assessment 5</span></footer>
    </div>
</body>
</html>
