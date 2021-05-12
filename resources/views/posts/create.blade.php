@extends('layouts/app')

@section('content')
    <h1>Create Posts</h1>
    {!! Form::open(['action'  => 'App\Http\Controllers\PostsController@store','method' => 'POST' , 'enctype' => 'multipart/form-data'])!!}
        <div class="form-group">
            {{Form::label('title','Title')}}
            <!--Placeholder attribute is not working-->
            <!--Started working after the second argument was changed from ' ' to null-->
            {{Form::text('title',null, $attributes = array('class'=>'form-control','placeholder'=>'Title Goes here'))}}
        </div>
        <div class="form-group">
            {{Form::label('body','Body')}}
            {{Form::textarea('body',null,['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Body text'])}}
        </div>
        <!--Uploading image option-->
         <div class="form-group">
            {{Form::file('cover_image')}}
         </div>
            {{Form::submit('Submit', ['class' => 'btn btn-info'])}}
    {!! Form::close() !!}
@endsection
