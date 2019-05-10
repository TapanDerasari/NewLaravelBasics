<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="userID" content="{{ auth()->user()->id }}">
    @endauth
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{asset('img/project.png')}}"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('pageCss')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shares.index') }}">@lang('labels.links.shareDetails')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.chat') }}">@lang('labels.links.chat')</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @lang('labels.language') <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="locale/en">@lang('labels.english')</a>
                                <a class="dropdown-item" href="locale/gu">@lang('labels.gujarati')</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">@lang('labels.links.login')</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">@lang('labels.links.register')</a>
                            </li>
                        @endif
                    @else
                    <!-- Notifications Dropdown Menu -->
                        <li class="nav-item dropdown show float-left">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                                <span class="badge badge-warning navbar-badge small" style="font-size: 60%">{{Auth::user()->unreadNotifications()->count()}}</span>
                                <i class="fa fa-bell"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 15rem">
                                <span class="dropdown-item dropdown-header">{{Auth::user()->unreadNotifications()->count()}} Notifications</span>
                                @foreach(Auth::user()->unreadNotifications as $notification)
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">
                                        <i class="fa fa-users mr-2"></i> New user registered- {{ $notification->data['name']}}
                                        <span class="float-right text-muted text-sm">{{$notification->created_at}}</span>
                                    </a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('breadcrumb')
        @yield('content')
    </main>
</div>
<!-- Scripts -->
<script type="text/javascript" src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
@yield('pageScript')
</body>
</html>
