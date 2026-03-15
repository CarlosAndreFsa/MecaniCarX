<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MecaniCarX | Oficina Especializada</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="antialiased font-sans bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">

    {{-- Botão de Alternar Tema (Fixo no canto inferior) --}}
    <button id="theme-toggle" class="fixed bottom-6 right-6 z-50 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full shadow-lg hover:scale-110 transition-all text-orange-600">
        {{-- Ícone Sol (Modo Claro) --}}
        <svg id="theme-toggle-light-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
        {{-- Ícone Lua (Modo Escuro) --}}
        <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
    </button>

    {{-- Navegação --}}
    <nav class="sticky top-0 z-40 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/img/favicon.png') }}" class="h-8 w-auto" alt="Logo">
                    <span class="text-xl font-bold tracking-tight">Mecani<span class="text-orange-600">CarX</span></span>
                </div>
                
                <div class="hidden md:flex space-x-8 text-sm font-medium">
                    <a href="#home" class="hover:text-orange-600 transition">Início</a>
                    <a href="#sobre" class="hover:text-orange-600 transition">Quem Somos</a>
                    <a href="#servicos" class="hover:text-orange-600 transition">Serviços</a>
                    <a href="#contato" class="hover:text-orange-600 transition">Contato</a>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-orange-700 transition">Painel</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium hover:text-orange-600 transition">Entrar</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section id="home" class="relative py-20 bg-gray-50 dark:bg-gray-900 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            <div class="mb-8">
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="MecaniCarX" class="h-40 w-auto rounded-3xl shadow-2xl border-4 border-white dark:border-gray-800">
            </div>
            <h1 class="text-5xl md:text-6xl font-black tracking-tighter mb-4 text-gray-900 dark:text-white">
                Mecani<span class="text-orange-600">CarX</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl">
                Cuidando do seu veículo com a tecnologia que ele merece. Transparência e agilidade em cada serviço.
            </p>
            <div class="mt-10 flex gap-4">
                <a href="#contato" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition">Agendar Avaliação</a>
            </div>
        </div>
    </section>

    {{-- Quem Somos --}}
    <section id="sobre" class="py-20 bg-white dark:bg-gray-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6 italic border-l-4 border-orange-600 pl-4">Quem Somos</h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                        Localizada em Feira de Santana, a <strong>MecaniCarX</strong> moderniza o atendimento mecânico. 
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Nossa equipe combina anos de experiência com ferramentas de diagnóstico avançadas.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-2xl border border-gray-200 dark:border-gray-800">
                        <span class="block text-3xl font-bold text-orange-600">+500</span>
                        <span class="text-sm text-gray-500">Clientes</span>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-2xl border border-gray-200 dark:border-gray-800">
                        <span class="block text-3xl font-bold text-orange-600">100%</span>
                        <span class="text-sm text-gray-500">Qualidade</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Serviços --}}
    <section id="servicos" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Nossos Serviços</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach(['Mecânica Geral', 'Injeção Eletrônica', 'Suspensão e Freios'] as $servico)
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-orange-600 transition group shadow-sm">
                    <h3 class="text-xl font-bold mb-2">{{ $servico }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Manutenção preventiva e corretiva com tecnologia de ponta.</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contato --}}
    <section id="contato" class="py-20 bg-gray-100 dark:bg-gray-800/80 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Agende sua visita</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-10 max-w-xl mx-auto">
                Estamos na Avenida Getúlio Vargas, Feira de Santana. <br>
                Atendimento de Segunda a Sexta das 08h às 18h.
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-6">
                {{-- Botão WhatsApp --}}
                @php
                    $telefoneLimpo = "75999999999"; // Coloque seu número aqui
                    $msgWhats = urlencode("Olá MecaniCarX! Gostaria de agendar uma avaliação para o meu veículo.");
                @endphp
                <a href="https://wa.me/55{{ $telefoneLimpo }}?text={{ $msgWhats }}" 
                   target="_blank"
                   class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-green-600/20 transition-all hover:scale-105">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.891 11.893-11.891 3.181 0 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.481 8.403 0 6.556-5.332 11.892-11.893 11.892-1.99 0-3.946-.499-5.672-1.447l-6.321 1.665zm6.155-3.863c1.551.921 3.23 1.408 4.951 1.408 5.397 0 9.79-4.393 9.79-9.791 0-2.617-1.02-5.078-2.871-6.928-1.851-1.85-4.312-2.871-6.929-2.871-5.398 0-9.791 4.393-9.791 9.79 0 1.729.458 3.418 1.327 4.954l-.872 3.186 3.25-.853zm11.332-6.526c-.301-.151-1.781-.878-2.057-.978-.275-.1-.476-.151-.676.151-.2.301-.777.978-.951 1.179-.174.201-.351.226-.652.075-.301-.151-1.272-.469-2.422-1.494-.894-.797-1.498-1.782-1.674-2.083-.174-.301-.018-.463.132-.613.135-.134.301-.351.452-.527.151-.176.201-.301.301-.502.101-.201.05-.376-.026-.527-.075-.151-.676-1.631-.926-2.233-.244-.586-.493-.507-.676-.516-.174-.008-.376-.01-.577-.01-.201 0-.527.075-.803.376-.275.301-1.053 1.028-1.053 2.508 0 1.48 1.078 2.911 1.228 3.112.151.201 2.122 3.241 5.141 4.542.718.309 1.279.494 1.716.633.721.23 1.376.198 1.893.121.577-.088 1.781-.728 2.031-1.43.25-.702.25-1.304.176-1.43-.076-.126-.276-.201-.577-.352z"/></svg>
                    WhatsApp da Oficina
                </a>

                {{-- Card de Telefone --}}
                <div class="px-8 py-4 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 font-medium shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    (75) 3333-3333
                </div>
            </div>
        </div>
    </section>

    {{-- Script para Lógica do Botão Dark Mode --}}
    <script>
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Função para atualizar os ícones e a classe no HTML
    function updateTheme() {
        if (document.documentElement.classList.contains('dark')) {
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            themeToggleLightIcon.classList.add('hidden');
            themeToggleDarkIcon.classList.remove('hidden');
        }
    }

    // Inicialização
    updateTheme();

    themeToggleBtn.addEventListener('click', function() {
        // Alterna a classe dark no elemento raiz (HTML)
        document.documentElement.classList.toggle('dark');
        
        // Salva a preferência
        if (document.documentElement.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            console.log("Modo Escuro Ativado");
        } else {
            localStorage.setItem('theme', 'light');
            console.log("Modo Claro Ativado");
        }
        
        // Atualiza os ícones do botão
        updateTheme();
    });
</script>
</body>
</html>