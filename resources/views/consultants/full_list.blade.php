@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-10 text-center text-white">Наши консультанты</h1>

@forelse ($consultants as $consultant)
    <div class="bg-white p-6 mb-10 rounded shadow-lg">
        <div class="flex flex-col md:flex-row gap-6 items-start">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-600">
                @if($consultant->photo)
                    <img src="{{ asset('storage/' . $consultant->photo) }}" alt="{{ $consultant->name }}" class="object-cover w-full h-full">
                @else
                    <img src="https://via.placeholder.com/150?text=No+Photo" alt="Нет фото" class="object-cover w-full h-full">
                @endif
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-semibold text-gray-800">{{ $consultant->name }}</h2>
                <p class="text-gray-600 mt-2">{{ $consultant->description ?? 'Описание отсутствует' }}</p>

                <h3 class="mt-6 text-lg font-semibold text-blue-700">Предоставляемые консультации:</h3>

                @if($consultant->topics->isEmpty())
                    <p class="text-sm text-gray-500 italic mt-1">Нет доступных тем</p>
                @else
                    <ul class="mt-2 list-disc list-inside space-y-1 text-gray-700 text-sm">
                        @foreach ($consultant->topics as $topic)
                            <li>{{ $topic->title }}</li>
                        @endforeach
                    </ul>
                @endif

                <a href="{{ route('consultations.create', ['consultant_id' => $consultant->id]) }}"
                   class="inline-block mt-6 bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                    Записаться к этому специалисту
                </a>
            </div>
        </div>
    </div>
@empty
    <p class="text-center text-gray-600">Нет доступных консультантов.</p>
@endforelse

</div>
@endsection
