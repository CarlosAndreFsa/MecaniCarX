<x-app-layout>
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Ordens de Serviço</h2>
            <div class="flex justify-end gap-2 pt-2 mb-2">
                <a href="{{ route('painel') }}"
                class="px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-500">
                        Dashboad
                </a>
                <a href="{{ route('service-orders.create') }}"
                class="px-4 py-2 bg-yellow-300 text-white rounded hover:bg-blue-500">
                        Novo
                </a>
            </div>                           
        </div>         
     </div>     

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="border-b">
                <th class="p-2">Número</th>
                <th class="p-2">Cliente</th>
                <th class="p-2">Status</th>
                <th class="p-2">Veiculo</th>
                <th class="p-2">Ações</th>
            </tr>
        </thead>

    <tbody>
        @foreach($orders as $service_order)
            <tr class="border-b">
                <td class="p-2">{{ $service_order->number }}</td>
                <td class="p-2">{{ $service_order->customer->name }}</td>
                <td class="p-2">{{ $service_order->status }}</td>
                <td class="p-2">{{ "veiculo xx"}}</td>
                <td class="p-2 space-x-2">
                    <a href="{{ route('service-orders.show', $service_order)}}">Detalhes</a>
                    <a href="">Editar</a>
                    <a href="">Excluir</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $orders->links() }}
</x-app-layout>
