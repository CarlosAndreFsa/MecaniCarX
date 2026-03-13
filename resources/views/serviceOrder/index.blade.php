<x-app-layout>
    <div class="space-y-6">
        @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm" role="alert">
        {{ session('error') }}
    </div>
@endif
        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Ordens de Serviço</h2>
            <div class="flex gap-2">
                <a href="{{ route('painel') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg border hover:bg-gray-200 transition">
                    Dashboard
                </a>
                <a href="{{ route('service-orders.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition">
                    + Nova OS
                </a>
            </div>
        </div>

        {{-- TABELA --}}
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Número</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Cliente</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Data Entrada</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Veículo</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Ações</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($orders as $service_order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-sm font-bold text-blue-600">
                                #{{ $service_order->number }}
                            </td>
                            <td class="p-4 text-sm text-gray-700">
                                {{ $service_order->customer->name }}
                            </td>
                            <td class="p-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($service_order->entry_date)->format('d/m/Y') }}
                            </td>
                            <td class="p-4">
                                @php
                                    $colors = [
                                        'open' => 'bg-gray-100 text-gray-700',
                                        'in_progress' => 'bg-yellow-100 text-yellow-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'canceled' => 'bg-red-100 text-red-700',
                                    ];
                                    $labels = [
                                        'open' => 'Aberta',
                                        'in_progress' => 'Em Andamento',
                                        'completed' => 'Concluída',
                                        'canceled' => 'Cancelada',
                                    ];
                                @endphp

                                <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $colors[$service_order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $labels[$service_order->status] ?? $service_order->status }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-500">
                                {{ $service_order->vehicle_plate ?? 'Veículo XX' }}
                            </td>
                            <td class="p-4 text-sm text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('service-orders.show', $service_order) }}" class="text-blue-600 hover:text-blue-800 font-medium">Ver</a>
                                    <a href="{{ route('service-orders.edit', $service_order) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">Editar</a>
                                    
                                    {{-- Botão de Excluir com formulário para segurança --}}
                                    <form action="{{ route('service-orders.destroy', $service_order) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINAÇÃO --}}
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>