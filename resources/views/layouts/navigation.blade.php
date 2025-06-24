<nav x-data="{ open: false, scrolled: false }" 
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :class="scrolled ? 'bg-white/80 backdrop-blur shadow-md' : 'bg-transparent'" 
     class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M7 8h10M7 12h6m-3 8a9 9 0 100-18 9 9 0 000 18zm5-2v1a2 2 0 01-2 2H9a2 2 0 01-2-2v-1" />
    </svg>
    <span class="text-xl font-semibold text-white">PsyHelp</span>
</a>

            </div>

            <!-- Desktop Nav -->
            <div class="hidden sm:flex space-x-8 items-center">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Главная</x-nav-link>
                <x-nav-link :href="route('consultations.create')" :active="request()->routeIs('consultations.create')">Забронировать консультацию</x-nav-link>
                <x-nav-link :href="route('consultations.index')" :active="request()->routeIs('consultations.index')">Мои консультации</x-nav-link>
                <x-nav-link :href="route('consultants.full')" :active="request()->routeIs('consultants.*')">
                    {{ __('Список консультантов') }}
                </x-nav-link>
                @auth
    @if (Auth::user()->role === 'admin')
        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.')">
            {{ __('Админ-панель') }}
        </x-nav-link>
    @endif
@endauth


                @auth
                    @if (Auth::user()->role === 'consultant')
                        <x-nav-link :href="route('consultations.as_consultant')" :active="request()->routeIs('consultations.as_consultant')">Панель консультанта</x-nav-link>
                    @endif
                @endauth
            </div>

            <!-- Auth / Guest -->
            <div class="hidden sm:flex items-center space-x-4">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Профиль</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Выйти</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-700">Войти</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-blue-600 hover:underline">Регистрация</a>
                @endauth
            </div>

            <!-- Burger -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile -->
    <div :class="open ? 'block' : 'hidden'" class="sm:hidden px-4 pt-2 pb-4 bg-white border-t">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Главная</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('consultations.create')" :active="request()->routeIs('consultations.create')">Создать консультацию</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('consultations.index')" :active="request()->routeIs('consultations.index')">Мои консультации</x-responsive-nav-link>
        @auth
            @if (Auth::user()->role === 'consultant')
                <x-responsive-nav-link :href="route('consultations.as_consultant')" :active="request()->routeIs('consultations.as_consultant')">Панель консультанта</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('profile.edit')">Профиль</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Выйти</x-responsive-nav-link>
            </form>
        @else
            <a href="{{ route('login') }}" class="block text-sm text-gray-700 hover:underline">Войти</a>
            <a href="{{ route('register') }}" class="block text-sm text-blue-600 hover:underline font-semibold">Регистрация</a>
        @endauth
    </div>
</nav>
