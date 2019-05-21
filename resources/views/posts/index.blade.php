@extends('layouts.app')
@section('title','Posts')
@section('pageCss')
    <link rel="stylesheet" href="{{asset('css/blog/blog.css')}}">
@endsection
@section('content')
    @php
        $user=Auth::user();
    @endphp
    <!-- details card section starts from here -->
    <a href="{{route('posts.create')}}" class="btn btn-primary float-right mr-5  mb-5">Create Post</a>
    @if($posts)
        <section class="details-card">
            <div class="container">
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-4">
                            <div class="card-content">
                                <div class="card-img">
                                    <img src="{{asset('storage/'.$post->image)}}" alt="">
                                </div>
                                <div class="card-desc">
                                    <h3>{{$post->title}}</h3>
                                    <p>{{Str::limit($post->body, $limit = 75, $end = '...')}}</p>
                                    <a href="{{URL::signedRoute('posts.show',$post->id)}}" class="btn-card">Read</a>
                                    <button class="btn-card">
                                        @if($user->likes->contains($post->id))
                                            <i id="like{{$post->id}}" class="fa fa-heart" data-postid="{{$post->id}}"
                                               data-status="liked" style="color: red"></i>
                                        @else
                                            <i id="like{{$post->id}}" class="fa fa-heart" data-postid="{{$post->id}}"
                                               data-status="notLiked"></i>
                                        @endif
                                        <span class="ml-3"
                                              id="totalLikes{{$post->id}}">{{$post->likes->count()}}</span>
                                    </button>
                                    @if(Auth::user()->id == $post->user_id)
                                        <a href="{{URL::signedRoute('posts.edit',$post->id)}}" class="btn-card">
                                            <i class="fa fa-pencil-square-o"></i>
                                            Edit
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        No Post Found.
    @endif
    <!-- details card section starts from here -->

@endsection
@section('pageScript')
    <script type="text/javascript">
        $(document).ready(function () {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('button.btn-card').click(function () {
                var post_id = $(this).find('i.fa-heart').data('postid');
                console.log(post_id);
                $.ajax({
                    type: 'POST',
                    url: '{{route('like-dislike')}}',
                    data: {post_id: post_id},
                    success: function (data) {
                        if ($('#like' + post_id).data('status') == 'liked') {
                            $('#like' + post_id).css('color', 'white');
                            $('#like' + post_id).data('status', 'notLiked');
                        } else {
                            $('#like' + post_id).css('color', 'red');
                            $('#like' + post_id).data('status', 'liked');
                        }
                        $('#totalLikes' + post_id).html(data.totalLikes);
                    }
                });


            });
        });
    </script>
@endsection