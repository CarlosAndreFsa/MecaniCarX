<x-app-layout>
    <div class="space-y-6">

    <h2 class="text-xl font-semibold">
        Painel do Administrador
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Funcionários</p>
             <a href="{{ route('users.index') }}">
                <p class="text-2xl font-bold">{{ $usersCount ?? 0 }}</p>
             </a>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Clientes</p>
            <a href="{{ route('customer.index') }}">
                        <p class="text-2xl font-bold">{{ $clientsCount ?? 0 }}</p>
                </a>
          
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Veículos</p>
            <p class="text-2xl font-bold">0</p>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Ordens de Serviço</p>
             <a href="{{ route('service-orders.index') }}">
                <p class="text-2xl font-bold">{{ $serviceOrderCount ?? 0}}</p>
             </a>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Faturamento do Mês</p>
            <p class="text-2xl font-bold">R$ 0,00</p>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Ordens Abertas</p>
            <p class="text-2xl font-bold">0</p>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Empresas</p>
             <a href="{{ route('company.show') }}"
                <p class="text-2xl font-bold">{{ $companyCount ?? 0 }}</p>
             </a>
        </div>

    </div>

</div>
</x-app-layout>