@extends('layouts.app')
@section('content')
<div class="jumbotron text-center">
      <h1>{{$title}}</h1>
      <p>This is the index page</p>
      <p class="lead">
    <a class="btn btn-dark btn-lg" href="/login" role="button">Login </a> <a class="btn btn-secondary btn-lg" href="/register" role="button">Register </a>
  </p>
</div>
@endsection
