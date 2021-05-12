@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <a href="/posts/create" class="btn btn-info" style="margin-bottom: 10px;">Create New Post</a>

                        <h2>Your Past Posts</h2>
                {{--Adding the if statement to avoid error for new users who have no past posts--}}
                @if(count($posts) > 0)
                    <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                    <tr>
                                        <th scope="row">{{$post->title}}</th>
                                        <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></td>
                                        <td>
                                        <!--Opening the form for adding the delete button-->
                                            {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy',$post->id],'method' => 'POST','class' => 'float-right'])!!}
                                                {{Form::hidden('_method','DELETE')}}
                                                {{Form::submit('Delete the post', ['class' => 'btn btn-secondary'])}}
                                            {!!Form::close()!!}
                                        <!--Closing the form-->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                    </table>
                {{--As the posts are null hence displaying an error--}}
                @else
                    <div class="alert alert-info text-center" role="alert">
                        You have no posts! Click the Create button to create your first post!
                    </div>
                {{--Ending the if statement--}}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
