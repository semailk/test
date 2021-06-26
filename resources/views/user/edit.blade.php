@extends('layouts.app')
@section('content')
        <form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="mb-3">
                <h1 class="text-center">Редактировать данные</h1>
                <label for="name" class="form-label">Имя</label>
                <input value="{{$user->name}}" name="name" type="text" class="form-control" id="name"
                       placeholder="Name..." required>
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Аватарка</label>
                <input name="avatar" type="file" class="form-control" id="avatar">
            </div>
            <button type="submit" class="btn btn-outline-primary">Обновить</button>
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
