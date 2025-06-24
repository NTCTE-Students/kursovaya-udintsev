@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-8">Управление пользователями</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-left">Имя</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Роль</th>
                <th class="border border-gray-300 px-4 py-2 text-center">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ ucfirst($user->role) }}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    @if($user->role !== 'admin')
                    <form action="{{ route('admin.users.toggle_consultant', $user) }}" method="POST" onsubmit="return confirm('Подтвердить изменение роли?')">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                            @if($user->role === 'consultant') Убрать консультанта @else Назначить консультантом @endif
                        </button>
                    </form>
                    @else
                        <span class="text-gray-500">Администратор</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
