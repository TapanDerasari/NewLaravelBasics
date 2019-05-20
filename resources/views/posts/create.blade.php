@extends('layouts.app')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/areaselect/imgareaselect-default.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="card uper">
            <div class="card-header">
                @if(!empty($post))
                    Edit Post
                @else
                    Create Post
                @endif
                <a href="{{route('posts.index')}}" class="btn btn-link float-right">Back</a>
            </div>
            <div class="card-body">
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                <form id="postform" method="post"
                      action="{{ !empty($post)?route('posts.update',$post->id):route('posts.store') }}"
                      enctype="multipart/form-data">
                    @if(!empty($post))
                        @method('PATCH')
                    @endif
                    <div class="form-group">
                        @csrf
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title"
                               value="{{ !empty($post->title) ? $post->title : old('title')}}"/>
                    </div>
                    <div class="form-group">
                        <label for="price">Post Body :</label>
                        <textarea name="body" id="body" class="form-control" cols="30"
                                  rows="10">{{!empty($post->body) ? $post->body : old('body')}}</textarea>
                    </div>
                    @if(!empty($post->image))
                        <div class="img-thumbnail">
                            <img src="{{asset('storage/'.$post->image)}}" alt="Image">
                        </div>
                    @endif
                    <div class="form-group d-flex flex-md-column">
                        <label for="InputImage">Image:</label>
                        <input type="file" name="image" id="InputImage" class="image">
                        <input type="hidden" name="x1" value=""/>
                        <input type="hidden" name="y1" value=""/>
                        <input type="hidden" name="w" value=""/>
                        <input type="hidden" name="h" value=""/>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
                <div class="row mt-5">
                    <p>
                        <label for="previewimage" id="lbl" style="display:none">Crop Image</label>
                        <img id="previewimage" style="display:none;"/>
                    </p>
                    @if(session('path'))
                        <img src="{{ session('path') }}"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageScript')
    <script type="text/javascript" src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/areaselect/jquery.imgareaselect.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.validate.js')}}"></script>
    <script>
        jQuery(function ($) {

            var p = $("#previewimage");
            $("body").on("change", ".image", function () {

                var imageReader = new FileReader();
                imageReader.readAsDataURL(document.querySelector(".image").files[0]);

                imageReader.onload = function (oFREvent) {
                    p.attr('src', oFREvent.target.result).fadeIn();
                    $('#lbl').fadeIn();
                };
            });

            $('#previewimage').imgAreaSelect({
                onSelectEnd: function (img, selection) {
                    $('input[name="x1"]').val(selection.x1);
                    $('input[name="y1"]').val(selection.y1);
                    $('input[name="w"]').val(selection.width);
                    $('input[name="h"]').val(selection.height);
                }
            });
        });
    </script>
@endsection