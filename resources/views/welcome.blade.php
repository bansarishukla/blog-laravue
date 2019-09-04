<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .links > a {
                color: #00aef9;;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                text-align: center;
            }
            .header-top {
                height: 50px;
                border-bottom: 1px solid #DCDCDC;
            }
            .header-middle {
                height: 120px;
                text-align: center;
                padding: 30px 0 0 0;
            }
            .header-bottom {
                height: 70px;
                background-color: #ea1e10bd;
                text-align: center;
            }
            .category {
                color: white;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            p {
                margin: 0 0 0 0;
                padding: 0 0 0 0;
            }
            .title-top {
                color: black;
                font-size: 25px;
                font-weight: bold;
            }
            .main {
                display: flex;
            }
            .post {
                width: 70%;
                margin-left: 50px;
            }
            .category {
                width: 20%;
                margin-left: 40px;
            }
            .category_style {
                color: #D55;
                margin-left: 20px;
            }
            .category_display {
                list-style: none;
                color: black;
            }
            .card {
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="header-top">
                    <img height="50" width="200" src="https://gooyaabitemplates.com/download/Free-Blogger-Templates.png" alt="Blogger Templates" style="max-height: 88px;">
                    <div class="top-right links">
                            <a href="#"><i class="fa fa-paint-brush" aria-hidden="true"></i>By Styles</a>
                            <a href="#"><i class="fa fa-briefcase" aria-hidden="true"></i>By Features</a>
                            <a href="#"><i class="fa fa-paperclip" aria-hidden="true"></i>By Topics</a>
                            @auth
                                <a href="{{ url('/home') }}">Home</a>
                            @else
                                <a href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i>Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a>
                                @endif
                            @endauth
                    </div>
                </div>
                <div class="header-middle">
                    <p class="title-top">THE FUNC</p>
                    <p class="title-bottom">The Func Blogger Template</p>
                </div>
                <div class="header-bottom">

                </div>
            @endif
            <div>
                <div class="main">
                    <div class="post">
                        @foreach($posts as $post)
                        <div class="card">
                            <div class="card-header">
                                <h2>{{ $post->name }}</h2>
                            </div>
                            <div class="card-body">
                                {{ str_limit($post->description, 500) }}<a href="{{action('PostController@readMore', $post->id )}}" class="btn btn-primary">Read More</a><hr>
                                <small>Created At: {{ $post->created_at }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="category">
                        <div class="card">
                            <div class="card-header">
                                <h2 style="color: black;">Categories:</h2>
                            </div>
                            <div class="card-body">
                                @foreach($categories as $category)
                                    <li><a class="category_style" href="{{action('PostController@filterByCategory', $category->id )}}">{{ $category->category }}</a></li>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
