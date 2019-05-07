@extends('layouts.admin')
@section('title','View users')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            {{Breadcrumbs::render('user-view',$user)}}
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        Name: {{$user->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        Email: {{$user->email}}
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
