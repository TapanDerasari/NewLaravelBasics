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
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h1>{{ $post->title }}</h1>
                            <hr>
                            <div class="text-center">
                                <img src="{{asset('storage/'.$post->image)}}" alt="{{ $post->title }}">
                            </div>
                            <p>
                                {{ $post->body }}
                            </p>
                            <hr/>
                            <h4>Comments:</h4>
                            @include('posts.comment', ['comments' => $post->comments, 'post_id' => $post->id])
                            <hr/>
                            <h4>Add comment</h4>
                            <form method="post" action="{{ route('posts.comment') }}">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control" name="body"></textarea>
                                    <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Add Comment"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
@endsection
