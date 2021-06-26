@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <form action="{{route('avatar.store')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <label for="avatar">Добавить аватарку</label>
                <input class="form-control" name="avatar" type="file">
                <button class="btn btn-primary mt-2" type="submit">Отправить</button>
            </form>
        </div>
    </div>
@endsection
