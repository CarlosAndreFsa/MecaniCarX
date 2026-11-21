<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MecaniCarX | Gestão Automotiva Inteligente</title>

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

    {{-- Botão Dark Mode --}}
    <button id="theme-toggle" class="fixed bottom-6 right-6 z-50 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full shadow-2xl hover:scale-110 transition-all text-orange-600">
        <svg id="theme-toggle-light-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
        <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
    </button>

    {{-- Botão Voltar ao Topo --}}
    <button id="back-to-top" class="fixed bottom-20 right-6 z-50 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full shadow-2xl hover:scale-110 transition-all text-orange-600 opacity-0 pointer-events-none duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
    </button>

    {{-- Navegação --}}
    <nav class="sticky top-0 z-40 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logo-mecanicarx.png') }}" class="h-10 w-auto" alt="MecaniCarX">
                    <span class="text-2xl font-black tracking-tighter ">Mecani<span class="text-orange-600">CarX</span></span>
                </div>
                
                <div class="hidden md:flex space-x-8 text-[10px] font-black uppercase tracking-[0.2em]">
                    <a href="#features" class="hover:text-orange-600 transition">Recursos</a>
                    <a href="#pricing" class="hover:text-orange-600 transition">Preços</a>
                    <a href="#roadmap" class="hover:text-orange-600 transition">Roadmap</a>
                    <a href="#contact" class="hover:text-orange-600 transition">Contato</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-orange-600 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-orange-700 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-black uppercase hover:text-orange-600 transition">Entrar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative py-32 bg-white dark:bg-gray-900 transition-colors overflow-hidden border-b border-gray-200 dark:border-gray-800">
        <!-- Efeito Visual Tecnológico (Grid Background) -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        <div class="absolute left-1/2 top-0 -z-10 -translate-x-1/2 mt-10 h-[300px] w-[600px] rounded-full bg-orange-500/20 blur-[120px]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 text-[10px] font-mono font-black uppercase tracking-widest mb-8 border border-orange-200 dark:border-orange-800/50">
                <span class="w-2 h-2 rounded-full bg-orange-600 animate-pulse"></span> Sistema SaaS Multi-Tenant v1.0
            </div>
            <h1 class="text-6xl md:text-8xl font-black tracking-tighter mb-6 leading-none text-gray-900 dark:text-white relative z-10">
                Gestão Automotiva de <br> <span class="text-orange-600 italic">ALTA PERFORMANCE.</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-500 dark:text-gray-400 max-w-3xl mx-auto mb-10 font-medium leading-relaxed relative z-10">
                Desenvolvido para mecânicos que exigem organização e para oficinas que buscam lucratividade. Tudo o que você precisa em uma plataforma Full Stack.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                <a href="#contact" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-8 py-4 rounded-xl font-black uppercase tracking-widest text-xs shadow-xl hover:scale-105 transition-all">Solicitar Acesso</a>
                <a href="#features" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 px-8 py-4 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    Explorar Arquitetura
                </a>
            </div>
        </div>
    </section>

    {{-- SEÇÃO RECURSOS (O que o sistema já faz) --}}
    <section id="features" class="py-24 bg-gray-50 dark:bg-gray-800/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 hover:border-orange-500 transition-colors group shadow-sm hover:shadow-xl">
                    <div class="text-orange-600 mb-4 font-mono font-black text-xl group-hover:scale-110 transition-transform origin-left">01_</div>
                    <h3 class="font-black uppercase mb-2">Ordens de Serviço</h3>
                    <p class="text-sm text-gray-500">Abertura de OS, checklist de entrada, parecer técnico e impressão térmica/A4 com sua logo.</p>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 hover:border-orange-500 transition-colors group shadow-sm hover:shadow-xl">
                    <div class="text-orange-600 mb-4 font-mono font-black text-xl group-hover:scale-110 transition-transform origin-left">02_</div>
                    <h3 class="font-black uppercase mb-2">CRM de Veículos</h3>
                    <p class="text-sm text-gray-500">Histórico completo por placa, controle de proprietários e avisos de manutenção via WhatsApp.</p>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 hover:border-orange-500 transition-colors group shadow-sm hover:shadow-xl">
                    <div class="text-orange-600 mb-4 font-mono font-black text-xl group-hover:scale-110 transition-transform origin-left">03_</div>
                    <h3 class="font-black uppercase mb-2">Multi-Tenant</h3>
                    <p class="text-sm text-gray-500">Segurança total. Isolamento de dados por empresa, permitindo centenas de oficinas no mesmo sistema.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SEÇÃO ARQUITETURA (Tech Stack) --}}
    <section class="py-24 bg-gray-900 dark:bg-gray-950 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-orange-500 via-transparent to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-[10px] font-mono text-orange-500 tracking-[0.3em] mb-4">// STACK DE ENGENHARIA</h2>
                <h3 class="text-3xl md:text-5xl font-black uppercase tracking-tighter">Por baixo do capô</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-6 border border-gray-800 rounded-2xl bg-gray-800/40 hover:bg-gray-800 hover:border-red-500/50 transition-colors">
                    <div class="text-red-500 mb-3 font-black text-xl">Laravel 11</div>
                    <p class="text-xs text-gray-400 font-mono leading-relaxed">Backend seguro, estruturado e escalável. Rotas otimizadas e lógica MVC limpa.</p>
                </div>
                <div class="p-6 border border-gray-800 rounded-2xl bg-gray-800/40 hover:bg-gray-800 hover:border-cyan-400/50 transition-colors">
                    <div class="text-cyan-400 mb-3 font-black text-xl">TailwindCSS</div>
                    <p class="text-xs text-gray-400 font-mono leading-relaxed">Design System avançado, garantindo uma interface fluida, responsiva e com Dark Mode nativo.</p>
                </div>
                <div class="p-6 border border-gray-800 rounded-2xl bg-gray-800/40 hover:bg-gray-800 hover:border-blue-500/50 transition-colors">
                    <div class="text-blue-500 mb-3 font-black text-xl">MySQL</div>
                    <p class="text-xs text-gray-400 font-mono leading-relaxed">Modelagem de dados relacional e performática, preparada para ecossistemas Multi-Tenant.</p>
                </div>
                <div class="p-6 border border-gray-800 rounded-2xl bg-gray-800/40 hover:bg-gray-800 hover:border-yellow-400/50 transition-colors">
                    <div class="text-yellow-400 mb-3 font-black text-xl">JavaScript ES6</div>
                    <p class="text-xs text-gray-400 font-mono leading-relaxed">Buscas assíncronas (AJAX), manipulação de DOM inteligente e interatividade reativa.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SEÇÃO ROADMAP FINANCEIRO (O que está sendo feito AGORA) --}}
    <section id="roadmap" class="py-24 border-y border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-12 flex items-center gap-4">
                Desenvolvimento: <span class="text-orange-600">Módulo Financeiro</span> <span class="h-px grow bg-gray-200 dark:bg-gray-800"></span>
            </h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700">
                    <h4 class="font-black uppercase text-xs text-orange-600 mb-3">Em Andamento (70%)</h4>
                    <p class="font-bold text-sm mb-2">Contas a Pagar e Receber</p>
                    <p class="text-xs text-gray-500">Gestão de despesas da oficina e faturamento das OS.</p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700">
                    <h4 class="font-black uppercase text-xs text-blue-600 mb-3">Planejado (40%)</h4>
                    <p class="font-bold text-sm mb-2">Baixas e Conciliação</p>
                    <p class="text-xs text-gray-500">Confirmação de pagamentos e batimento com extrato bancário.</p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700">
                    <h4 class="font-black uppercase text-xs text-gray-400 mb-3">Próximo</h4>
                    <p class="font-bold text-sm mb-2">Fluxo de Caixa Mensal</p>
                    <p class="text-xs text-gray-500">Dashboard de lucratividade e saúde financeira.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SEÇÃO PREÇOS --}}
    <section id="pricing" class="py-24 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
            <h2 class="text-4xl font-black uppercase tracking-tighter">Planos de Assinatura</h2>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-3 gap-8">
            {{-- Starter --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow flex flex-col">
                <h3 class="text-[10px] font-black text-gray-400 uppercase mb-4">Starter</h3>
                <div class="text-4xl font-black mb-6 italic text-gray-800 dark:text-white">R$ 97</div>
                <ul class="space-y-4 mb-8 text-xs font-bold text-gray-500 uppercase flex-1">
                    <li>✅ Até 100 OS/mês</li>
                    <li>✅ Clientes Ilimitados</li>
                    <li>✅ Suporte Ticket</li>
                </ul>
                <button class="w-full py-3 border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white transition-colors font-black rounded-xl uppercase text-[10px] tracking-widest mt-auto">Assinar</button>
            </div>
            {{-- Professional --}}
            <div class="bg-gray-900 dark:bg-orange-600 p-8 rounded-3xl border-4 border-orange-600 text-white md:scale-105 shadow-2xl flex flex-col relative">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-orange-600 text-white px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full">Recomendado</div>
                <h3 class="text-[10px] font-black uppercase opacity-70 mb-4">Professional</h3>
                <div class="text-4xl font-black mb-6 italic">R$ 197</div>
                <ul class="space-y-4 mb-8 text-xs font-black uppercase flex-1">
                    <li>🚀 OS Ilimitadas</li>
                    <li>🚀 Financeiro Completo</li>
                    <li>🚀 Backup em Nuvem</li>
                </ul>
                <button class="w-full py-3 bg-white text-orange-600 hover:bg-gray-100 transition-colors font-black rounded-xl uppercase text-[10px] tracking-widest mt-auto">Escolher</button>
            </div>
            {{-- Enterprise --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow flex flex-col">
                <h3 class="text-[10px] font-black text-gray-400 uppercase mb-4">Enterprise</h3>
                <div class="text-2xl font-black mb-6 uppercase">Sob Consulta</div>
                <ul class="space-y-4 mb-8 text-xs font-bold text-gray-500 uppercase flex-1">
                    <li>🌐 Integração API</li>
                    <li>🌐 Multi-Unidades</li>
                    <li>🌐 Gerente Dedicado</li>
                </ul>
                <button class="w-full py-3 bg-gray-900 hover:bg-gray-800 text-white dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200 transition-colors font-black rounded-xl uppercase text-[10px] tracking-widest mt-auto">Falar com Consultor</button>
            </div>
        </div>
    </section>

    {{-- SEÇÃO CONTATO (Ajustada para o seu WhatsApp) --}}
    <section id="contact" class="py-24 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-[3rem] p-12 border dark:border-gray-700 shadow-sm flex flex-col md:flex-row items-center justify-between gap-12 text-center md:text-left">
                <div>
                    <h2 class="text-4xl font-black uppercase tracking-tighter mb-4 italic">Procurando por um <br><span class="text-orange-600">Desenvolvedor Full Stack?</span></h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Fale diretamente com o criador do MecaniCarX para projetos sob demanda.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="https://wa.me/5575999198876" target="_blank" class="h-14 px-8 flex items-center justify-center bg-green-600 text-white font-black rounded-2xl uppercase text-[10px] tracking-widest hover:bg-green-700 transition shadow-lg shadow-green-600/20">
                        WhatsApp Suporte
                    </a>
                    <a href="mailto:contato@mecanicarx.com.br" class="h-14 px-8 flex items-center justify-center bg-gray-900 dark:bg-gray-100 dark:text-gray-900 text-white font-black rounded-2xl uppercase text-[10px] tracking-widest hover:opacity-90 transition">
                        E-mail Direto
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Rodapé --}}
    <footer class="py-20 bg-white dark:bg-gray-950 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <img src="{{ asset('assets/img/logo-mecanicarx.png') }}" class="h-12 mx-auto mb-8" alt="MecaniCarX">
            <p class="text-sm font-black uppercase text-gray-500 tracking-[0.3em]">
                Desenvolvido por <span class="text-orange-600">Carlos André</span> | Full Stack Developer
            </p>
            <p class="text-[10px] font-bold text-gray-400 mt-4 uppercase">Feira de Santana - BA | MecaniCarX &copy; 2026</p>
        </div>
    </footer>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        function updateTheme() {
            if (document.documentElement.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            }
        }
        updateTheme();
        themeToggleBtn.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            updateTheme();
        });

        // Lógica do botão Voltar ao Topo
        const backToTopBtn = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>