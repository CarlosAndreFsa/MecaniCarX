<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MecaniCarX - Sistema</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body
    class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300"
    x-data="{ sidebarOpen: true, openMenu: null }">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}

        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 transition-all duration-300 flex flex-col z-50 border-r border-gray-200 dark:border-slate-800">
            {{-- Logo --}}
            <a href="{{ url('/') }}"
                class="h-16 flex items-center px-6 bg-gray-50 dark:bg-slate-950/50 shrink-0 border-b border-gray-200 dark:border-transparent hover:opacity-80 transition-opacity cursor-pointer">
                <img src="{{ asset('assets/img/favicon.png') }}" class="h-8 w-8 min-w-[32px]">
                <span x-show="sidebarOpen"
                    class="ml-3 font-bold text-xl text-slate-900 dark:text-white whitespace-nowrap">
                    Mecani<span class="text-orange-600">CarX</span>
                </span>
            </a>

            {{-- Navegação --}}
            <nav class="flex-1 px-3 py-4 space-y-2 overflow-y-auto">
                {{-- Item Simples: Dashboard --}}
                <a href="{{ route('painel') }}"
                    class="flex items-center p-3 rounded-lg hover:bg-slate-800 transition group {{ request()->routeIs('painel') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Dashboard</span>
                </a>

                {{-- Categoria Expansível: Cadastros --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open; sidebarOpen = true"
                        class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-800 transition group">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 font-medium">Cadastros</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open && sidebarOpen" x-cloak class="mt-1 ml-9 space-y-1">
                        <a href="{{ route('customer.index') }}"
                            class="block p-2 text-sm hover:text-white transition">Clientes</a>
                        <a href="{{ route('users.index') }}"
                            class="block p-2 text-sm hover:text-white transition">Funcionários</a>
                        <a href="{{ route('vehicles.index') }}"
                            class="block p-2 text-sm hover:text-white transition">Veículos</a>
                        @if (auth()->user()->role === 'super-admin')
                            <a href="{{ route('brands.index') }}"
                                class="block p-2 text-sm hover:text-white transition">Marcas</a>
                        @endif
                    </div>
                </div>

                {{-- Categoria Expansível: Oficina --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open; sidebarOpen = true"
                        class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-800 transition group">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 font-medium">Oficina</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open && sidebarOpen" x-cloak class="mt-1 ml-9 space-y-1">
                        <a href="{{ route('service-orders.index') }}"
                            class="block p-2 text-sm hover:text-white transition">Ordens de Serviço</a>
                        <a href="#" class="block p-2 text-sm hover:text-white transition">Agendamentos</a>
                    </div>
                </div>

                {{-- Categoria Expansível: Configurações --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open; sidebarOpen = true"
                        class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-800 transition group">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3 font-medium">Configurações</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open && sidebarOpen" x-cloak class="mt-1 ml-9 space-y-1">
                        <a href="{{ route('company.show') }}"
                            class="block p-2 text-sm hover:text-white transition">Minha Empresa</a>
                        <a href="{{ route('profile') }}" class="block p-2 text-sm hover:text-white transition">Meu
                            Perfil</a>
                    </div>
                </div>

            </nav>

            {{-- Botão de Minimizar --}}
            <button @click="sidebarOpen = !sidebarOpen"
                class="p-4 bg-slate-950/30 hover:bg-slate-800 flex justify-center transition border-t border-slate-800">
                <svg :class="sidebarOpen ? '' : 'rotate-180'" class="w-5 h-5 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>
        </aside>

        {{-- CONTEÚDO --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- TOPBAR --}}
            <header
                class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-8 z-40">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 hover:text-orange-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-6">
                    {{-- BOTÃO DARK MODE DIRETO AQUI --}}
                    <button onclick="toggleTheme()"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition relative group">
                        <svg id="theme-icon-light" class="hidden w-6 h-6 text-orange-500" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                            </path>
                        </svg>
                        <svg id="theme-icon-dark" class="hidden w-6 h-6 text-slate-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>

                    {{-- LIVEWIRE NAV (Perfil / Logout) --}}
                    <livewire:layout.navigation />
                </div>
            </header>

            {{-- ÁREA DE SCROLL --}}
<main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-slate-950 transition-colors duration-300">
                    @if (isset($header))
                    <div class="mb-8">
                        {{ $header }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        // Escopo global limpo para evitar erros com Livewire
        window.updateIcons = function () {
            const lightIcon = document.getElementById('theme-icon-light');
            const darkIcon = document.getElementById('theme-icon-dark');
            
            if (document.documentElement.classList.contains('dark')) {
                lightIcon?.classList.remove('hidden');
                darkIcon?.classList.add('hidden');
            } else {
                lightIcon?.classList.add('hidden');
                darkIcon?.classList.remove('hidden');
            }
        };

        window.toggleTheme = function () {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            window.updateIcons();
        };

        // Inicialização garantida
        document.addEventListener('DOMContentLoaded', window.updateIcons);
        document.addEventListener('livewire:navigated', window.updateIcons);
        window.updateIcons();
    </script>

    {{-- A Pilha (Stack) onde o script do Tom Select das Views entrará --}}
    @stack('scripts')
</body>

</html>
