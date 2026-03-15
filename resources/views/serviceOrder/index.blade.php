<x-app-layout>
    {{-- Alertas Dinâmicos --}}
<div class="space-y-4 mb-4">
    @foreach (['success' => 'bg-green-100 border-green-500 text-green-700', 
               'edit' => 'bg-yellow-100 border-yellow-500 text-yellow-700', 
               'delete' => 'bg-red-100 border-red-500 text-red-700'] as $key => $style)
        
        @if(session($key))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 3000)" {{-- Some após 5 segundos --}}
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="{{ $style }} border-l-4 p-4 shadow-sm flex justify-between items-center" 
                 role="alert">
                
                <div>
                    <p class="font-bold">{{ ucfirst($key === 'delete' ? 'Excluído' : ($key === 'edit' ? 'Editado' : 'Sucesso')) }}</p>
                    <p>{{ session($key) }}</p>
                </div>

                <button @click="show = false" class="text-lg font-bold">&times;</button>
            </div>
        @endif
    @endforeach
</div>
    <div class="space-y-6">
      
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
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mb-6">
                <form id="filter-form" action="{{ route('service-orders.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" 
                            id="search-input"
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Nº OS, Nome ou ID do Cliente..." 
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500">
                    </div>

                    <div class="w-full md:w-48">
                        <select name="status" id="status-select" class="w-full border-gray-300 rounded-lg focus:ring-blue-500">
                            <option value="">Todos os Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Aberta</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                        </select>
                    </div>
                </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('filter-form');
            const searchInput = document.getElementById('search-input');
            const statusSelect = document.getElementById('status-select');
            let timer;

            // Função que envia o formulário
            const submitForm = () => form.submit();

            // Evento para o Input (com atraso/debounce)
            searchInput.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(submitForm, 500); // Aguarda 0.5s após parar de digitar
            });

            // Evento para o Select (imediato)
            statusSelect.addEventListener('change', submitForm);

            // Coloque isso dentro do seu DOMContentLoaded
            if (document.getElementById('search-input').value !== '') {
                const input = document.getElementById('search-input');
                // Coloca o cursor no final do texto
                input.focus();
                const val = input.value;
                input.value = '';
                input.value = val;
            }
        });
    </script>
</x-app-layout>