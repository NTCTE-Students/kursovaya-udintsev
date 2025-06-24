@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Забронировать консультацию</h1>

    <!-- Сообщения об успехе или ошибках -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded border border-red-300">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded border border-red-300">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Форма выбора консультанта (GET) -->
    <form method="GET" action="{{ route('consultations.create') }}" class="mb-6">
        <label for="consultant_id" class="block mb-2 font-medium text-gray-700">Консультант</label>
        <select name="consultant_id" id="consultant_id" onchange="this.form.submit()"
                class="border border-gray-300 rounded px-3 py-2 w-full">
            <option value="">-- Выберите консультанта --</option>
            @foreach ($consultants as $consultant)
                <option value="{{ $consultant->id }}" {{ ($selectedConsultantId == $consultant->id) ? 'selected' : '' }}>
                    {{ $consultant->name }}
                </option>
            @endforeach
        </select>
    </form>

    @if ($selectedConsultantId)
        <!-- Форма бронирования (POST) -->
        <form method="POST" action="{{ route('consultations.store') }}">
            @csrf
            <input type="hidden" name="consultant_id" value="{{ $selectedConsultantId }}">

            <label for="topic_id" class="block mb-2 font-medium text-gray-700">Тема консультации</label>
            <select name="topic_id" id="topic_id" class="border border-gray-300 rounded px-3 py-2 w-full mb-4">
                <option value="">-- Выберите тему --</option>
                @foreach ($topics as $topic)
                    <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                        {{ $topic->title }}
                    </option>
                @endforeach
            </select>

            <label for="scheduled_at" class="block mb-2 font-medium text-gray-700">Дата и время консультации</label>
            <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}"
                   class="border border-gray-300 rounded px-3 py-2 w-full mb-6">

            <button type="submit" 
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition w-full font-semibold">
                Забронировать
            </button>
        </form>
    @endif
</div>
@endsection
