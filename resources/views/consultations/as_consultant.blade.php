@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Панель консультанта</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    @if ($consultations->isEmpty())
        <div class="p-4 bg-yellow-100 text-yellow-700 rounded shadow">
            У вас пока нет назначенных консультаций.
        </div>
    @else
        <div class="space-y-6">
            @foreach ($consultations as $consultation)
                <div class="bg-white shadow rounded-lg border border-gray-200 p-6 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0 md:flex-1">
                        <p class="text-lg font-semibold text-gray-800">
                            Тема: <span class="font-normal">{{ $consultation->topic->title }}</span>
                        </p>
                        <p class="text-gray-600">
                            Клиент: <span class="font-medium">{{ $consultation->user->name }}</span>
                        </p>
                        <p class="text-gray-600">
                            Дата: <span class="font-medium">{{ \Carbon\Carbon::parse($consultation->scheduled_at)->format('d.m.Y H:i') }}</span>
                        </p>
                        <p class="text-gray-600">
                            Статус:
                            <span class="inline-block px-2 py-0.5 rounded text-sm
                                @if($consultation->status === 'pending') bg-yellow-200 text-yellow-800
                                @elseif($consultation->status === 'approved') bg-blue-200 text-blue-800
                                @elseif($consultation->status === 'completed') bg-green-200 text-green-800
                                @elseif($consultation->status === 'cancelled') bg-red-200 text-red-800
                                @endif
                            ">
                                {{ ucfirst($consultation->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
                        <form action="{{ route('consultations.update_status', $consultation->id) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PATCH')

                            <select name="status" class="border rounded px-3 py-1 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="pending" @selected($consultation->status === 'pending')>Ожидает</option>
                                <option value="approved" @selected($consultation->status === 'approved')>Подтверждена</option>
                                <option value="completed" @selected($consultation->status === 'completed')>Завершена</option>
                                <option value="cancelled" @selected($consultation->status === 'cancelled')>Отменена</option>
                            </select>

                            <button type="submit" class="ml-2 bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition">
                                Обновить
                            </button>
                        </form>

                        <form action="{{ route('consultations.destroy', $consultation->id) }}" method="POST"
                              onsubmit="return confirm('Удалить консультацию?')" class="w-32">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 transition
                                    {{ !in_array($consultation->status, ['cancelled', 'completed']) ? 'invisible' : '' }}">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
