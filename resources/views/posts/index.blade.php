@extends('layouts.app')
@section('content')
    <h3>Posts</h3>
    @if(count($posts)>=1)
        @foreach($posts as $post)
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <img style="width: 100%" src="\storage\app\public\cover_images\{{$post->cover_image}}">
                </div>
                <div class="col-md-8 col-sm-8">
                    <h4> <a href="/lsapp/public/posts/{{$post->id}}"> {{$post->title}} </a></h4>
                    <small> Written on {{$post->created_at}} by {{$post->user->name}}</small
                </div>
            </div>
            <div class="well">
                >
            </div>
        @endforeach
    @else
        <h2>No posts found</h2>
    @endif
@endsection