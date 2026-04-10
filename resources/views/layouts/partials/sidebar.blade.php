<aside class="w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transition-colors duration-300">
        <h2 class="text-lg font-bold mb-4">
        Painel
    </h2>

    <nav class="space-y-2">

        <a href="{{ route('painel') }}"
           class="block px-3 py-2 rounded hover:bg-gray-700">
            Dashboard
        </a>

        {{-- ADMIN --}}
        @if(auth()->user()->role === 'admin')
            <p class="mt-4 text-xs text-gray-400 uppercase">
                Administração
            </p>

            <a href="{{ route('company.show') }}""
               class="block px-3 py-2 rounded hover:bg-gray-700">
                Empresas
            </a>

            <a href="{{ route('users.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                Usuários
            </a>
        @endif

        {{-- ADMIN + EMPLOYEE --}}
        @if(in_array(auth()->user()->role, ['admin', 'employee']))
            <p class="mt-4 text-xs text-gray-400 uppercase">
                Operacional
            </p>

            <a href="{{ route('customer.index')}}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                Clientes
            </a>

            <a href="{{ route('service-orders.index')}}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                Ordens de Serviço
            </a>
        @endif

    </nav>
</aside>
