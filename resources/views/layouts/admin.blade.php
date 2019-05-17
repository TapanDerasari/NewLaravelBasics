<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title') | Admin</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{asset('img/project.png')}}"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('pageCss')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<?php $admin = Auth::guard('admin')->user(); ?>
<!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('/admin')}}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown show float-left">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    <span class="badge badge-warning navbar-badge small"
                          style="font-size: 60%">{{$admin->unreadNotifications()->count()}}</span>
                    <i class="fa fa-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 15rem">
                    <span class="dropdown-item dropdown-header">{{$admin->unreadNotifications()->count()}} Notifications</span>
                    @foreach($admin->unreadNotifications as $notification)
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
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('admin.dashboard')}}" class="brand-link">
            <img src="{{ asset('img/project.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Administrator</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{route('admin.dashboard')}}" class="d-block">Hello,{{$admin->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.dashboard')}}">
                            <i class="nav-icon fa fa-tachometer-alt"></i>
                            <p>
                                {{ __('Dashboard') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview menu">
                        <a href="#" class="nav-link">
                            <i class="fa fa-user-cog nav-icon"></i>
                            <p>
                                User Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('users.index')}}" class="nav-link">
                                    <i class="nav-icon fa fa-user-friends"></i>
                                    <p>User list</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-user-astronaut"></i>
                                    <p>Active User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview menu">
                        <a href="#" class="nav-link">
                            <i class="fa fa-images"></i>
                            <p>
                                Post Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-user-friends"></i>
                                    <p>User posts</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-user-lock"></i>
                                    <p>Admin Posts</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="nav-icon fa fa-chalkboard-teacher"></i>
                            <p>
                                {{ __('Messaging') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="nav-icon fa fa-power-off"></i>
                            <p>
                                {{ __('Logout') }}
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

@yield('content')


<!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2019 <a href="#">Tapan Derasari</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('pageScript')
</body>
</html>
