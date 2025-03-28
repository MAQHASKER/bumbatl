<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Приглашение присоединиться к команде</title>
</head>
<body>
    <h2>Приглашение присоединиться к команде</h2>

    <p>Здравствуйте!</p>

    <p>Вас пригласили присоединиться к команде "{{ $invite->team->name }}" на сайте {{ config('app.name') }}.</p>

    <p>Чтобы присоединиться к команде, перейдите по следующей ссылке:</p>
    <p><a href="{{ route('team.invite.accept', $invite->uid) }}">Присоединиться к команде</a></p>

    <p>Если вы не хотите присоединяться к команде, перейдите по этой ссылке:</p>
    <p><a href="{{ route('team.invite.reject', $invite->uid) }}">Отклонить приглашение</a></p>

    <p>Ссылка действительна до {{ $invite->expires_at->format('d.m.Y H:i') }}.</p>

    <p>С уважением,<br>{{ config('app.name') }}</p>
</body>
</html>
