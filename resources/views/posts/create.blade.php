@extends('layouts.app')
@section('content')
    <form action="{{route('store')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
    <div class="mb-3">
        <h1 class="text-center">Создать Пост</h1>
        <label for="title" class="form-label">Тема</label>
        <input value="{{old('title')}}" name="title" type="text" class="form-control" id="title" placeholder="Тема..." required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Описание</label>
        <textarea name="description" class="form-control" id="description" rows="3" required>{{old('description')}}</textarea>
    </div>
        <div class="mb-3">
            <label for="image" class="form-label">Изображение</label>
            <input name="image" type="file" class="form-control" id="image" required>
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
