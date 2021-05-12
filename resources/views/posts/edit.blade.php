@extends('layouts/app')

@section('content')
    <h1>Edit Post</h1>
    {!! Form::open(['action'  => ['App\Http\Controllers\PostsController@update',$post->id],'method' => 'POST','enctype' => 'multipart/form-data'])!!}
        <div class="form-group">
            {{Form::label('title','Title')}}
            <!--Placeholder attribute is not working-->
            <!--Started working after the second argument was changed from ' ' to null-->
            {{Form::text('title',$post->title, $attributes = array('class'=>'form-control','placeholder'=>'Title Goes here'))}}
        </div>
        <div class="form-group">
            {{Form::label('body','Body')}}
            {{Form::textarea('body',$post->body,['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Body text'])}}
        </div>
        <!--Uploading image option-->
         <div class="form-group">
            {{Form::file('cover_image')}}
         </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Submit Changes', ['class' => 'btn btn-info'])}}
    {!! Form::close() !!}
@endsection
