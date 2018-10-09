@extends("layouts.app")
@section('content')
    <a href='\lsapp\public\posts' class='btn btn-default'>Go Back</a>
    <h4>{{$post->title}}</h4>
    <div>{{$post->body}}</div>
    <hr>
    <small> Written on {{$post->created_at}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id==$post->user_id)
            <a href="/lsapp/public/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
            <hr>
            {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete',['class' => 'btn btn-right'])}}
            {!!Form::close()!!}
        @endif
    @endif
    
@endsection