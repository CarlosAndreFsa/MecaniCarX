<x-app-layout>
    <div class="space-y-6">

    <h2 class="text-xl font-semibold">
        Painel do Administrador
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Funcionários</p>
            <p class="text-2xl font-bold">{{ $usersCount ?? 0 }}</p>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Clientes</p>
            <p class="text-2xl font-bold">{{ $employeesCount ?? 0 }}</p>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Veículos</p>
            <p class="text-2xl font-bold">0</p>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Ordens de Serviço</p>
            <p class="text-2xl font-bold">0</p>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Faturamento do Mês</p>
            <p class="text-2xl font-bold">R$ 0,00</p>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <p class="text-gray-500 text-sm">Ordens Abertas</p>
            <p class="text-2xl font-bold">0</p>
        </div>

    </div>

</div>
</x-app-layout>