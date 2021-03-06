@extends('layouts.app')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/areaselect/imgareaselect-default.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="card uper">
            <div class="card-header">
                Add Share
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                <form id="shareform" method="post" action="{{ route('shares.store') }}" enctype="multipart/form-data">
                    <div class="form-group">
                        @csrf
                        <label for="name">Share Name:</label>
                        <input type="text" class="form-control" name="share_name" id="share_name"
                               value="{{old('share_name')}}"/>
                    </div>
                    <div class="form-group">
                        <label for="price">Share Price :</label>
                        <input type="text" class="form-control" name="share_price" id="share_price"
                               value="{{old('share_price')}}"/>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Share Quantity:</label>
                        <input type="text" class="form-control" name="share_qty" id="share_qty"
                               value="{{old('share_qty')}}"/>
                    </div>
                    <div class="form-group d-flex flex-md-column">
                        <label for="InputImage">Image:</label>
                        <input type="file" name="image" id="InputImage" class="image">
                        <input type="hidden" name="x1" value=""/>
                        <input type="hidden" name="y1" value=""/>
                        <input type="hidden" name="w" value=""/>
                        <input type="hidden" name="h" value=""/>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
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
           /* $('#shareform').validate({
                rules: {
                    share_name: {
                        required: true
                    },
                    share_price: {
                        required: true,
                        digits: true
                    },
                    share_qty:{
                        required: true,
                        digits: true
                    },
                    image: {
                        required: true,
                        extension: "jpeg|png"
                    },
                },
                errorClass: "error"
            });*/
        });
    </script>
@endsection