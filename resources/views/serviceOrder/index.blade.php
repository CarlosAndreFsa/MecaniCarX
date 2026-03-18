<x-app-layout>
    {{-- Alertas Dinâmicos --}}
    <div class="space-y-4 mb-4 px-4 md:px-8 pt-4">
        @foreach (['success' => 'bg-green-100 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400', 
                   'edit' => 'bg-yellow-100 border-yellow-500 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400', 
                   'delete' => 'bg-red-100 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                   'error' => 'bg-red-100 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400'] as $key => $style)
            
            @if(session($key))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 3000)"
                     x-transition:leave="transition ease-in duration-1000"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="{{ $style }} border-l-4 p-4 shadow-sm flex justify-between items-center rounded-r-xl" 
                     role="alert">
                    <div>
                        <p class="font-bold">{{ ucfirst($key === 'delete' ? 'Excluído' : ($key === 'error' ? 'Erro' : ($key === 'edit' ? 'Editado' : 'Sucesso'))) }}</p>
                        <p class="text-sm">{{ session($key) }}</p>
                    </div>
                    <button @click="show = false" class="text-xl font-bold leading-none">&times;</button>
                </div>
            @endif
        @endforeach
    </div>

    <div class="px-4 md:px-8 space-y-6 pb-8">
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Ordens de Serviço</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gerencie as manutenções da sua oficina</p>
            </div>
            <div class="flex gap-3">
    
                <a href="{{ route('service-orders.create') }}"
                    class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm">
                    + Nova OS
                </a>
            </div>
        </div>

        {{-- FILTRO --}}
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <form id="filter-form" action="{{ route('service-orders.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" 
                        id="search-input"
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Nº OS, Nome ou ID do Cliente..." 
                        class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-gray-700 dark:text-gray-200 transition-all">
                </div>

                <div class="w-full md:w-64">
                    <select name="status" id="status-select" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-gray-700 dark:text-gray-200 transition-all">
                        <option value="">Todos os Status</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Aberta</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- TABELA --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 dark:bg-gray-900/30 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Número</th>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Cliente</th>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Data Entrada</th>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center">Veículo</th>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($orders as $service_order)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
                                <td class="p-4 text-sm font-bold text-orange-600 dark:text-orange-500">
                                    #{{ $service_order->number }}
                                </td>
                                <td class="p-4">
                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $service_order->customer->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $service_order->vehicle_plate ?? 'S/ Veículo' }}</div>
                                </td>
                                <td class="p-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($service_order->entry_date)->format('d/m/Y') }}
                                </td>
                                <td class="p-4">
                                    @php
                                        $colors = [
                                            'open' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                            'in_progress' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400',
                                            'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
                                            'canceled' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400',
                                        ];
                                        $labels = [
                                            'open' => 'Aberta',
                                            'in_progress' => 'Em Andamento',
                                            'completed' => 'Concluída',
                                            'canceled' => 'Cancelada',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-black rounded-full uppercase tracking-tighter {{ $colors[$service_order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $labels[$service_order->status] ?? $service_order->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                                   {{ $service_order->vehicle->plate ?? 'S/ Modelo' }}
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('service-orders.show', $service_order) }}" class="p-2 text-gray-400 hover:text-orange-600 transition-colors" title="Ver">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('service-orders.edit', $service_order) }}" class="p-2 text-gray-400 hover:text-blue-500 transition-colors" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                        </a>
                                        <form action="{{ route('service-orders.destroy', $service_order) }}" method="POST" onsubmit="return confirm('Excluir OS?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-gray-500 dark:text-gray-400 italic">Nenhuma Ordem de Serviço encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINAÇÃO --}}
        <div class="mt-4 px-2">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- Script de Filtro (Mesma lógica) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('filter-form');
            const searchInput = document.getElementById('search-input');
            const statusSelect = document.getElementById('status-select');
            let timer;

            searchInput.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => form.submit(), 500);
            });

            statusSelect.addEventListener('change', () => form.submit());

            if (searchInput.value !== '') {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }
        });
    </script>
</x-app-layout>