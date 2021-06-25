@extends('layouts.app')
@section('content')
    <form action="{{route('update', $post->id)}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="mb-3">
            <h1 class="text-center">Редактировать Пост</h1>
            <label for="title" class="form-label">Тема</label>
            <input value="{{$post->title}}" name="title" type="text" class="form-control" id="title" placeholder="Тема..." required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" class="form-control" id="description" rows="3" required>{{$post->description}}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Изображение</label>
            <input name="image" type="file" value="{{$post->image}}" class="form-control" id="image">
        </div>
        <button type="submit" class="btn btn-outline-primary">Добавить</button>
    </form>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert-danger">
                <h4>{{$error}}</h4>
            </div>
        @endforeach
    @endif
    @if(session('success'))
        <div class="alert-success">
            <h4> {{session('success')}}</h4>
        </div>
    @endif
@endsection
