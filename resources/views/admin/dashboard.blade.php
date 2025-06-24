@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900">
            Админ-панель — Пользователи
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">

            {{-- Сообщения успеха и ошибок --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-3 text-green-800 bg-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 px-4 py-3 text-red-800 bg-red-200 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Форма фильтрации --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6 flex flex-wrap gap-4 items-end">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Имя пользователя</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $filterName ?? '') }}" class="border rounded px-3 py-1">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Роль</label>
                    <select name="role" id="role" class="border rounded px-3 py-1">
                        <option value="">Все роли</option>
                        <option value="admin" @if(($filterRole ?? '') === 'admin') selected @endif>Админ</option>
                        <option value="consultant" @if(($filterRole ?? '') === 'consultant') selected @endif>Консультант</option>
                        <option value="client" @if(($filterRole ?? '') === 'client') selected @endif>Клиент</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Фильтровать
                    </button>
                </div>

                <div>
                    <a href="{{ route('admin.users.index') }}" class="text-gray-600 underline hover:text-gray-900">
                        Сбросить фильтры
                    </a>
                </div>
            </form>

            {{-- Таблица пользователей --}}
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Имя</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Роль</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $user->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <span class="inline-block px-2 py-1 rounded text-xs
                                @if($user->role == 'admin') bg-red-500 text-white
                                @elseif($user->role == 'consultant') bg-blue-500 text-white
                                @else bg-gray-300 text-gray-700
                                @endif
                            ">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                            @if($user->id !== Auth::id())
                                <form action="{{ route('admin.users.toggle_consultant', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-blue-600 hover:underline">
                                        {{ $user->role === 'consultant' ? 'Убрать консультанта' : 'Назначить консультантом' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.toggleRole', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm text-red-600 hover:underline">
                                        {{ $user->role === 'admin' ? 'Разжаловать' : 'Назначить админом' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Вы уверены, что хотите удалить пользователя {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-700 hover:underline">
                                        Удалить
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 text-sm">Вы</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Пользователи не найдены</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
