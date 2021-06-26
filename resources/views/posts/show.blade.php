@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                @can('edit', $post)
                    <a href="{{route('edit', $post->id)}}"> <button type="button" class="btn btn-warning">Редактировать</button></a>
                   <a href="{{route('delete', $post->id)}}"><button type="button" class="btn btn-danger">Удалить</button></a>
                @endif
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4"></div>
            <div class="col-md-4"><img src="{{asset('storage/' . $post->image)}}" width="400" height="400"></div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center"><h1>{{$post->title}}</h1></div>
            <div class="col-md-12 mt-5"><h3>{{$post->description}}</h3></div>
            <div class="col-md-12 mt-5"><h4>{{$post->created_at}}</h4></div>
            <div class="col-md-2 mt-5"><span style="color: #4c110f">Автор поста:</span><h1>{{$post->user->name}}</h1></div>
        </div>
    </div>

@endsection
