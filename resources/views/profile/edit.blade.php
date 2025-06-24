@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Профиль</h2>

    @if (session('status'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label class="block">Имя:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" value="{{ $user->email }}" class="w-full border px-3 py-2 rounded bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label class="block">Роль:</label>
            <input type="text" value="{{ $user->role }}" class="w-full border px-3 py-2 rounded bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label class="block">Новый пароль:</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block">Подтвердите пароль:</label>
            <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Сохранить изменения</button>
    </form>
</div>
@endsection
