<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 md:px-8">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
                {{ __('Veículos') }}
            </h2>
            <a href="{{ route('vehicles.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-xl text-sm transition-all shadow-lg shadow-orange-600/20 hover:scale-105">
                {{ __('+ Novo Veículo') }}
            </a>
        </div>
    </x-slot>

    <div class="pt-4 pb-8 w-full">
        <div class="px-4 md:px-8 space-y-4">
            
            {{-- Alertas Padronizados --}}
            @foreach (['success', 'edit', 'delete', 'error'] as $key)
                @if(session($key))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                         class="bg-white dark:bg-gray-800 border-l-4 {{ $key == 'success' ? 'border-green-500 text-green-600' : ($key == 'edit' ? 'border-blue-500 text-blue-600' : 'border-red-500 text-red-600') }} p-4 rounded-r-xl shadow-md flex justify-between items-center">
                        <p class="text-sm font-bold">{{ session($key) }}</p>
                        <button @click="show = false" class="text-xl font-bold">&times;</button>
                    </div>
                @endif
            @endforeach

            {{-- Filtro Full Width --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <form action="{{ route('vehicles.index') }}" method="GET" class="flex w-full gap-4">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por placa, modelo ou cliente..." 
                               class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-gray-700 dark:text-gray-200 transition-all">
                    </div>
                    <button type="submit" class="bg-gray-200 dark:bg-gray-700 hover:bg-orange-600 hover:text-white dark:hover:bg-orange-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-8 rounded-xl transition-all border border-gray-200 dark:border-gray-600 shadow-sm">
                        Filtrar
                    </button>
                </form>
            </div>

            {{-- Tabela Full Width --}}
            <div class="w-full bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 dark:bg-gray-900/30 border-b dark:border-gray-700">
                            <tr>
                                <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Placa</th>
                                <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Marca / Modelo</th>
                                <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($vehicles as $vehicle)
                                <tr class="hover:bg-orange-50/20 dark:hover:bg-orange-900/10 transition-colors">
                                    <td class="p-4">
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-md font-mono font-bold border dark:border-gray-600 shadow-sm uppercase">
                                            {{ $vehicle->plate }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $vehicle->brand->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $vehicle->model }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="p-2 text-gray-400 hover:text-emerald-500 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="p-2 text-gray-400 hover:text-blue-500 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></a>
                                             <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('Excluir veículo?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="p-10 text-center text-gray-500 italic">Nenhum veículo cadastrado.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>