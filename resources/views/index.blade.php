@extends('layouts.app')
@section('content')

    <div class="container">
        <main class="container">
            <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
                <div class="col-md-6 px-0">
                    <h1 class="display-4 fst-italic">My test task for laravel</h1>
                    <p class="lead my-3">Welcome to my personal blog, leave interesting stories about your life.</p>
                </div>
            </div>

            <div class="row mb-2">
                @foreach($posts as $post)
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <h3 class="mb-0">{{$post->title}}</h3>
                            <div class="mb-1 text-muted">{{$post->created_at}}</div>
                            <p class="card-text mb-auto">{{mb_strimwidth($post->description,0,150,".....")}}</p>
                            <a href="{{route('show' , $post->id)}}" class="stretched-link">Читатать дальше.</a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img src="{{asset('storage/'. $post->image)}}" alt="" width="200" height="200">
                        </div>
                    </div>
                </div>

                @endforeach
            {{$posts->links()}}
            </div>
@endsection
