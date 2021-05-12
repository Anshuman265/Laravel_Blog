<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="{{asset('js/app.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <title>{{config('app.name','LSAPP')}}</title>
    </head>
    <body class="antialiased">
        @include('inc/navbar')
        <div class="container">
        @include('inc/messages')
        @yield('content')
        </div>
        <!--Adding the ckeditor here-->
 <script type="text/javascript" src="{{ URL::to('js/ckeditor.js') }}"></script>
    <script>
            window.addEventListener("load", function(){
                ClassicEditor
                    .create( document.querySelector( '#article-ckeditor' ) )
                    .then( editor => {
                        console.log( editor );
                    } )
                    .catch( error => {
                        console.error( error );
                    });
            })
        </script>
        <!--CKEditor has been added-->
    </body>
</html>
