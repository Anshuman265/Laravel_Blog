@extends('layouts.app')


@section('content')
        <!--Checking to see if the message is present-->
       @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <!--Message logic ends here-->
        <h1>Posts</h1>
        @if(count($posts)> 0)
            @foreach ($posts as $post)
                <div class="card card-body bg-light" style="margin: 20px 0;">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <!--It's going to look for the image in the public folder (the one outside the resources)-->
                            <img src="/storage/cover_images/{{$post->cover_image}}" alt="post_image" style="width: 100%;">
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h3>  <a href="/posts/{{$post->id}}">{{$post->title}}</a> </h3>
                             <small>Written on {{$post->created_at}} by {{$post->user->name}} </small>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$posts->links("pagination::bootstrap-4")}}
        @else
            <p>No posts found</p>
        @endif
        <!--Adding jquery to fade out the message-->
       <script>
            $(document).ready(function(){
            $('.alert-success').fadeIn().delay(4000).fadeOut();
            });
        </script>
        <!--jQuery ends here-->

@endsection
