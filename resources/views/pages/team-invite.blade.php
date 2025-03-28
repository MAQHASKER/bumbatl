@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Приглашение в команду</div>

                <div class="card-body text-center">
                    @if($invite)
                        <h4>Вас пригласили присоединиться к команде "{{ $invite->team->name }}"</h4>
                        <p class="mb-4">Приглашение от: {{ $invite->inviter->first_name }} {{ $invite->inviter->last_name }}</p>

                        @if(!Auth::check())
                            <div class="alert alert-info">
                                Для присоединения к команде необходимо войти в систему.
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                Войти
                            </a>
                        @else
                            <form action="{{ route('team.invite.accept', $invite->uid) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success me-2">
                                    Присоединиться к команде
                                </button>
                                <a href="{{ route('team.invite.reject', $invite->uid) }}" class="btn btn-danger">
                                    Отклонить приглашение
                                </a>
                            </form>
                        @endif
                    @else
                        <div class="alert alert-danger">
                            Приглашение не найдено или срок его действия истек.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
