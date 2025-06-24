@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Мои консультации</h1>

    <div class="mb-6 text-right">
        <a href="{{ route('consultations.create') }}"
           class="inline-block bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
            + Создать консультацию
        </a>
    </div>

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

    @if ($consultations->isEmpty())
        <div class="p-4 bg-yellow-100 text-yellow-800 rounded border border-yellow-300">
            У вас пока нет забронированных консультаций.
        </div>
    @else
        <div class="space-y-6">
            @foreach ($consultations as $consultation)
                <div class="bg-white shadow rounded-lg border border-gray-200 p-5">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $consultation->topic->title ?? 'Без темы' }}</h2>
                    <p class="text-gray-600"><strong>Дата:</strong> {{ \Carbon\Carbon::parse($consultation->scheduled_at)->format('d.m.Y H:i') }}</p>
                    <p class="text-gray-600"><strong>Статус:</strong> {{ ucfirst($consultation->status) }}</p>
                    <p class="text-gray-600"><strong>Консультант:</strong> {{ $consultation->consultant->name ?? 'Неизвестно' }}</p>

                    @if ($consultation->payments->isNotEmpty())
                        <div class="mt-4 bg-gray-50 p-4 rounded border border-gray-200">
                            <h3 class="font-semibold text-gray-800 mb-2">История оплат:</h3>
                            <ul class="text-sm text-gray-700 list-disc list-inside space-y-1">
                                @foreach ($consultation->payments as $payment)
                                    <li>
                                        Консультация: {{ $payment->consultation->topic->title ?? 'Без темы' }},
                                        Консультант: {{ $payment->consultation->consultant->name ?? 'Неизвестно' }},
                                        Сумма: <strong>{{ number_format($payment->amount / 100, 2, ',', ' ') }} ₽</strong>,
                                        Метод: <strong>{{ ucfirst($payment->method) }}</strong>,
                                        Статус: <span class="{{ $payment->status === 'success' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $payment->status }}
                                        </span>,
                                        Дата: {{ \Carbon\Carbon::parse($payment->paid_at)->format('d.m.Y H:i') }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        @if (!$consultation->is_paid && $consultation->status === 'pending' && Auth::id() === $consultation->user_id)
                            <!-- Кнопка для открытия модального окна -->
                            <button onclick="openModal({{ $consultation->id }})"
                                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700"
                                    id="pay-button-{{ $consultation->id }}">
                                Оплатить консультацию
                                <svg id="spinner-{{ $consultation->id }}" class="hidden animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </button>

                            <!-- Модальное окно -->
                            <div id="modal-{{ $consultation->id }}" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center px-4">
                                <div
                                    class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative
                                           transform transition-transform duration-300 scale-95 opacity-0 modal-content">
                                    <!-- Кнопка закрытия -->
                                    <button onclick="closeModal({{ $consultation->id }})"
                                            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 focus:outline-none"
                                            aria-label="Закрыть">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>

                                    <h2 class="text-xl font-semibold text-gray-800 mb-5">Оплата консультации</h2>

                                    <form action="{{ route('consultations.pay', $consultation->id) }}" method="POST" id="payment-form-{{ $consultation->id }}">
                                        @csrf

                                        <div class="mb-4">
                                            <label for="payment_method" class="block text-gray-700 font-medium mb-1">Способ оплаты:</label>
                                            <select name="payment_method" id="payment_method" required
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="card">Карта</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="sbp">СБП</option>
                                            </select>
                                        </div>

                                        <div class="mb-6">
                                            <label for="card_number" class="block text-gray-700 font-medium mb-1">Номер карты:</label>
                                            <input type="text" name="card_number" id="card_number" maxlength="16" pattern="\d{16}" placeholder="1234567812345678"
                                                   class="w-full border border-gray-300 rounded-md px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                   required>
                                        </div>

                                        <div class="flex justify-end gap-3 items-center">
                                            <button type="button" onclick="closeModal({{ $consultation->id }})"
                                                    class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 transition">
                                                Отмена
                                            </button>
                                            <button type="submit"
                                                    class="relative px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition flex items-center">
                                                Оплатить
                                                <svg id="spinner-form-{{ $consultation->id }}" class="hidden animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                         @if (Auth::id() === $consultation->user_id || Auth::id() === $consultation->consultant_id)
                        <form action="{{ route('consultations.destroy', $consultation->id) }}" method="POST" class="mt-4"
                              onsubmit="return confirm('Удалить консультацию?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                Удалить
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

<script>
    function openModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.modal-content').classList.remove('opacity-0', 'scale-95');
            }, 10);
        }
    }

    function closeModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) {
            const content = modal.querySelector('.modal-content');
            content.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        @foreach ($consultations as $consultation)
            const form{{ $consultation->id }} = document.querySelector('#payment-form-{{ $consultation->id }}');
            if (form{{ $consultation->id }}) {
                form{{ $consultation->id }}.addEventListener('submit', function() {
                    const btn = form{{ $consultation->id }}.querySelector('button[type="submit"]');
                    const spinner = btn.querySelector('svg');
                    if (btn && spinner) {
                        btn.disabled = true;
                        spinner.classList.remove('hidden');
                        btn.childNodes[0].textContent = 'Оплата...';
                    }
                });
            }
        @endforeach
    });
</script>
