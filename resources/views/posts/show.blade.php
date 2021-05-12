@extends('layouts.app')
@section('content')
    @if($post->count() > 0)
        <!--Go back button-->
        <a href="/posts" class = "btn btn-success btn-lg" style="margin: 10px 0;">Go Back</a>
        <!--Title of the Post-->
        <h1 class="text-center">{{$post->title}}</h1>
        <!--User name -->
            <h6 class="text-center">  by <em>{{$post->user->name}}</em></h6>

        <!--Body div-->
        <img src="/storage/cover_images/{{$post->cover_image}}" alt="post_image" style="width: 100%;border: 1px solid #B1C9DB;">
        <br><br>
        <div class="container">
            <!--If the double exclamation marks are not included then ck-editor will not parse the text-->
            {!!$post->body!!}
        </div>
        <hr>
        <!--Creating a time stamp of the creation of the post-->
        <small>Written on {{$post->created_at}}</small>
        <br>
        <!--Adding the if statement to ensure that the guest is not able to see the Edit and create buttons in the post-->
        @if(!Auth::guest())
            <!--Adding a link to edit posts -->
            @if(Auth::user()->id == $post->user_id)
                <a href="/posts/{{$post->id}}/edit" class="btn btn-outline-secondary">Edit</a>
                <!--Opening the form for adding the delete button-->
                {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy',$post->id],'method' => 'POST','class' => 'float-right'])!!}
                    {{Form::hidden('_method','DELETE')}}
                    {{Form::submit('Delete the post', ['class' => 'btn btn-info'])}}
                {!!Form::close()!!}
                <!--Closing the form-->
            @endif
        @endif
    @endif
@endsection
