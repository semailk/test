@extends('layouts.app')
@section('content')
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Пользователи
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Подтвержденные Посты
            </button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Неподтвержденные посты
            </button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <table class="table table-success text-center">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Верификация</th>
                    <th>Аватарка</th>
                </tr>
                </thead>
                <?php $i = 1; ?>
                @foreach($users as $user)
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->email_verified_at}}</td>
                        <td>
                            @if(isset($user->avatar->avatar))
                                <img
                                    src="{{asset('storage/' . $user->avatar->avatar)}}"
                                    alt="" width="50" height="50"></td>
                        @else
                            <img src="{{asset('../images/no-avatar.jpg')}}" width="50" height="50">
                        @endif
                        <td><a href="{{route('user.edit', $user->id)}}">Редактировать</a></td>
                    </tr>
                @endforeach
            </table>

        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

            <table class="table table-success text-center">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Тема</th>
                    <th>Описание</th>
                    <th>Изображение</th>
                </tr>
                </thead>
                <?php $i = 1; ?>
                @foreach($postPublished as $post)
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td>{{$post->title}}</td>
                        <td>{{$post->description}}</td>
                        <td><img src="{{asset('storage/' . $post->image)}}" width="100" height="100" alt=""></td>
                        <td><a href="{{route('edit' , $post->id)}}">Редактировать</a> <a
                                href="{{route('delete', $post->id)}}">Удалить</a></td>
                    </tr>
                @endforeach
            </table>

        </div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

            <table class="table table-danger text-center">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Тема</th>
                    <th>Описание</th>
                    <th>Изображение</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <?php $i = 1; ?>
                @foreach($postNoPublished as $post)
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td>{{$post->title}}</td>
                        <td>{{$post->description}}</td>
                        <td><img src="{{asset('storage/' . $post->image)}}" width="100" height="100" alt=""></td>
                        <td><a href="{{route('published' , $post->id)}}">Добавить</a> <a
                                href="{{route('cancel.published', $post->id)}}">Отменить</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
