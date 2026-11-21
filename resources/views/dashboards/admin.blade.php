<x-app-layout>
    <div class="space-y-6">
        {{-- Título do Painel --}}
       <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
    Painel do <span class="text-orange-600 font-black">Administrador</span>
</h2>

        {{-- Primeira Linha de Cards (Operacional) --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            {{-- Funcionários --}}
            <div class="p-5 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl transition-all">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Funcionários</p>
                <a href="{{ route('users.index') }}" class="group">
                    <p class="text-3xl font-black text-gray-900 dark:text-white group-hover:text-orange-600 transition">
                        {{ $usersCount ?? 0 }}
                    </p>
                </a>
            </div>

            {{-- Clientes --}}
            <div class="p-5 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Clientes</p>
                <a href="{{ route('customer.index') }}" class="group">
                    <p class="text-3xl font-black text-gray-900 dark:text-white group-hover:text-orange-600 transition">
                        {{ $clientsCount ?? 0 }}
                    </p>
                </a>
            </div>

            {{-- Veículos --}}
            <div class="p-5 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Veículos</p>
                 <a href="{{ route('vehicles.index') }}" class="group">
                    <p class="text-3xl font-black text-gray-900 dark:text-white group-hover:text-orange-600 transition">
                        {{ $vehicleCount ?? 00 }}
                    </p>
                 </a>
            </div>

            {{-- Ordens de Serviço --}}
            <div class="p-5 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ordens de Serviço</p>
                <a href="{{ route('service-orders.index') }}" class="group">
                    <p class="text-3xl font-black text-gray-900 dark:text-white group-hover:text-orange-600 transition">
                        {{ $serviceOrderCount ?? 0}}
                    </p>
                </a>
            </div>
        </div>

        {{-- Segunda Linha de Cards (Financeiro/Empresa) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Faturamento --}}
            <div class="p-5 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl border-l-4 border-l-green-500">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Faturamento do Mês</p>
                <p class="text-3xl font-black text-gray-900 dark:text-white">R${{ number_format($serviceOrderSum ?? 0, 2, ',', '.') }}</p>
            </div>

            {{-- Ordens Abertas --}}
            <div class="p-5 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl ">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ordens Abertas</p>
                 <a href="{{ route('service-orders.index', ['status' => 'open']) }}" class="group">
                    <p class="text-3xl font-black text-gray-900 dark:text-white group-hover:text-orange-600 transition">
                        {{ $openOrdersCount ?? 0 }}
                    </p>
                 </a>
            </div>

            {{-- Empresa --}}
            <div class="p-5 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Empresas</p>
                <a href="{{ route('company.show') }}" class="group">
                    <p class="text-3xl font-black text-gray-900 dark:text-white group-hover:text-orange-600 transition">
                        {{ $companyCount ?? 0 }}
                    </p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>