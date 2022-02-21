@extends('layouts.app')
@section('content')
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container">
    @foreach($posts as $post)
        @can('show-post', $post, $post->user)
        <div class="row featurette mt-2">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading">{{ $post->title }}</h2>
                <p class="lead">{{ $post->description }}</p>

                <h1>{{ $post->user->name }}</h1>
            </div>
            <div class="col-md-5 order-md-1">
                <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>

            </div>
            <div class="row">
            <div class="col-md-6">
                @can('deleteOrUpdatePost', $post, $post->user)
                    <div class="btn btn-danger">Delete Post</div>
                @endcan
                @can('deleteOrUpdatePost', $post, $post->user)
                    <div class="btn btn-warning">Edit Post</div>
                @endcan
            </div>
            </div>

        </div>
        @endcan
    @endforeach
</div>
</body>
</html>
@endsection
