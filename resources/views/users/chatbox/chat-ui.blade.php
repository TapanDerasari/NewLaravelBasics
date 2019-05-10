@extends('layouts.app')
@section('title','ChatBox')
@section('pageCss')
    <link rel="stylesheet" href="{{asset('css/chatbox/chat.css')}}">
@endsection
@section('content')
    <chat-application></chat-application>
@endsection