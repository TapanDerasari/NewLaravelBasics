@extends('layouts.app')
@section('title','Posts')
@section('pageCss')
    <link rel="stylesheet" href="{{asset('css/blog/blog.css')}}">
@endsection
@section('content')
    <!-- details card section starts from here -->
    <a href="{{route('posts.create')}}" class="btn btn-primary float-right mr-5 ">Create Post</a>
    <section class="details-card">
        <div class="container">
            <div class="row">
                @if($posts)
                    @foreach($posts as $post)
                        <div class="col-md-4">
                            <div class="card-content">
                                <div class="card-img">
                                    <img src="{{asset('storage/'.$post->image)}}" alt="">
                                    <span>
                                        <h4>
                                            <a href="{{route('posts.edit',$post->id)}}">
                                                <i class="fa fa-pencil-square-o"></i>
                                                Edit
                                            </a>
                                        </h4>
                                    </span>
                                </div>
                                <div class="card-desc">
                                    <h3>{{$post->title}}</h3>
                                    <p>{{$post->body}}</p>
                                    <a href="#" class="btn-card">Read</a>
                                    <button class="btn-card">
                                        <i class="fa fa-heart" style="color: red"></i>
                                        <span class="text-danger ml-2">0</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- details card section starts from here -->

@endsection
@section('pageScript')
@endsection