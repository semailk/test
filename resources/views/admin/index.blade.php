@extends('layouts.app')
@section('content')
@foreach($users as $user)
    @if($user->role !== 'admin')
        <h4>{{ $user->name }}</h4>
        @if( $user->avatar))
            <img src="{{ '/storage/' . auth()->user()->avatar }}" width="200" height="200" alt="">
        @else
            <img src="/images/35440139.png" alt="" width="200" height="200">
            <h5 class="text-danger">У вас нету аватарки, можете загрузить!</h5>
        @endif
        <form action="{{ route('avatar.store', $user->id) }}" class="w-50" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="avatar" class="form-control">
            <button class="btn btn-primary">Загрузить</button>
        </form>

    @endcan
@endforeach
@endsection
