<x-app-layout>
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Ordens de Serviço</h2>
            <div class="flex justify-end gap-2 pt-2 mb-2">
                <a href="{{ route('painel') }}"
                class="px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-500">
                        Dashboad
                </a>
                <a href="{{ route('serviceOrder.create') }}"
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
                <th class="p-2">Total</th>
            </tr>
        </thead>

    <tbody>
        @foreach($orders as $order)
            <tr class="border-b">
                <td class="p-2">{{ $order->number }}</td>
                <td class="p-2">{{ $order->customer->name }}</td>
                <td class="p-2">{{ $order->status }}</td>
                <td class="p-2">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $orders->links() }}
</x-app-layout>
