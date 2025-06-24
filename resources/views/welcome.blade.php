@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 min-h-screen flex flex-col justify-center items-center text-center px-4 py-20 relative">
        {{-- Кнопки Войти / Регистрация --}}
        <div class="absolute top-6 right-6">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="text-white font-semibold hover:underline">
                    Личный кабинет
                </a>
            @endauth
        </div>

        <h1 class="text-white text-5xl font-extrabold mb-6 max-w-4xl">
            Онлайн-консультации с профессиональными психологами
        </h1>
        <p class="text-blue-200 text-lg max-w-2xl mb-10">
            Заботьтесь о своём ментальном здоровье, не выходя из дома. Выбирайте консультанта, записывайтесь на сессию и оплачивайте онлайн — быстро, удобно и надёжно.
        </p>
        <a href="{{ route('consultations.create') }}" 
           class="bg-white text-blue-700 font-semibold px-8 py-4 rounded shadow hover:bg-gray-100 transition">
            Записаться на консультацию
        </a>
    </div>

    <div class="max-w-6xl mx-auto py-16 px-4">
        <h2 class="text-3xl font-bold text-white mb-8 text-center">Почему выбирают нас</h2>
        <div class="grid md:grid-cols-3 gap-10">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 20v-6M16 14l-4-4-4 4"/></svg>
                <h3 class="text-xl font-semibold mb-2">Проверенные специалисты</h3>
                <p class="text-gray-600">Все консультанты проходят тщательную проверку и сертификацию.</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><path d="M12 6v6l4 2"/></svg>
                <h3 class="text-xl font-semibold mb-2">Удобное бронирование</h3>
                <p class="text-gray-600">Выберите время, консультанта и способ оплаты за пару кликов.</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                <h3 class="text-xl font-semibold mb-2">Гарантия конфиденциальности</h3>
                <p class="text-gray-600">Ваши данные и консультации надежно защищены и не разглашаются.</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Отзывы наших клиентов</h2>
            <div class="space-y-10">
                <blockquote class="bg-white rounded-lg p-6 shadow">
                    <p class="text-gray-700 italic">"Очень благодарна сервису! Консультант помог разобраться с моими страхами и тревогами. Записаться легко, оплатить быстро."</p>
                    <footer class="mt-4 font-semibold text-blue-700">Анна, 29 лет</footer>
                </blockquote>
                <blockquote class="bg-white rounded-lg p-6 shadow">
                    <p class="text-gray-700 italic">"Профессиональные специалисты, удобно и конфиденциально. Рекомендую всем, кто ищет психологическую поддержку."</p>
                    <footer class="mt-4 font-semibold text-blue-700">Игорь, 35 лет</footer>
                </blockquote>
                <blockquote class="bg-white rounded-lg p-6 shadow">
                    <p class="text-gray-700 italic">"Быстрое бронирование и оплата, удобный интерфейс. Очень доволен сервисом."</p>
                    <footer class="mt-4 font-semibold text-blue-700">Марина, 42 года</footer>
                </blockquote>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto mt-10 px-4">
    <h1 class="text-3xl font-bold mb-8 text-center text-white">Наши консультанты</h1>

    @if($consultants->isEmpty())
        <p class="text-center text-gray-600">Пока нет доступных консультантов.</p>
    @else
        <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($consultants as $consultant)
                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center text-center">
                    <div class="w-32 h-32 mb-4 rounded-full overflow-hidden border-4 border-blue-600">
                        @if($consultant->photo)
                            <img src="{{ asset('storage/' . $consultant->photo) }}" alt="{{ $consultant->name }}" class="object-cover w-full h-full">
                        @else
                            <img src="https://via.placeholder.com/150?text=No+Photo" alt="Нет фото" class="object-cover w-full h-full">
                        @endif
                    </div>
                    <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ $consultant->name }}</h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $consultant->description ?? 'Описание отсутствует' }}</p>
                    <a href="{{ route('consultations.create', ['consultant_id' => $consultant->id]) }}"
                       class="mt-auto inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Записаться
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
