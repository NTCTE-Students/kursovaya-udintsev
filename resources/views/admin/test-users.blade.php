<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Тест пользователей</title>
</head>
<body>
    <h1>Пользователи</h1>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->id }} — {{ $user->name }} — {{ $user->role }}</li>
        @endforeach
    </ul>
</body>
</html>
