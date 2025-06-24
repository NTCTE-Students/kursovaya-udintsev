<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Просмотр консультации</title>
</head>
<body>
    <h1>{{ $consultation->topic }}</h1>
    <p><strong>Пользователь:</strong> {{ $consultation->user_id }}</p>
    <p><strong>Описание:</strong> {{ $consultation->description }}</p>
    <p><strong>Когда:</strong> {{ $consultation->scheduled_at }}</p>

    <p><a href="/consultations">Назад к списку</a></p>
</body>
</html>
