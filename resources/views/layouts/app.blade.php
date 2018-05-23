<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/home.css')}}">

        <title>Laravel</title>


        <!-- Styles -->
        <style>
           @media only screen and (max-width: 1024px){ 
                .main-header{
                    background:url({{asset('image/backgroundSmall2.jpg')}});
                    background-repeat:no-repeat;
                    height:220px;
                    margin-bottom:-5px;
                    background-size:cover;
                }
            }
            @media only screen and (min-width: 1024px){
                .main-header{
                    background-image: url({{asset('image/background2.jpg')}});
                    background-position:-50px -350px;
                    background-repeat:no-repeat;
                    height:240px;
                }
            }
        </style>
    </head>
    <body>
        <header class="main-header">
        </header>
        @include('Nav.Navbar')
        <div id="app">
            <div class="main">
                @yield('content')
            </div>
        </div>

    </body>

<script type="text/javascript" src="{{mix('js/app.js')}}"></script>
@yield('js')
</html>
