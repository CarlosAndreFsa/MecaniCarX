<x-app-layout>
    {{-- Alertas Dinâmicos --}}
<div class="space-y-4 mb-4">
    @foreach (['success' => 'bg-green-100 border-green-500 text-green-700', 
               'edit' => 'bg-yellow-100 border-yellow-500 text-yellow-700', 
               'error' => 'bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm', 
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
                    <p class="font-bold">{{ ucfirst($key === 'delete' ? 'Excluído' : ($key === 'error' ? 'Erro' : ($key === 'edit' ? 'Editado' : 'Sucesso'))) }}</p>
                    <p>{{ session($key) }}</p>
                </div>

                <button @click="show = false" class="text-lg font-bold">&times;</button>
            </div>
        @endif
    @endforeach
</div>
    <div class="space-y-6">
      
       
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 md:px-8">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
                {{ __('Marcas de Veículos') }}
            </h2>
            <a href="{{ route('brands.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-xl text-sm transition-all shadow-lg shadow-orange-600/20 hover:scale-105">
                {{ __('+ Nova Marca') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 w-full">
        <div class="px-4 md:px-8">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-6 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-400 p-4 rounded-xl shadow-sm transition">
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Barra de Busca Melhorada --}}
            <div class="mb-6 flex flex-col md:flex-row md:justify-end gap-4">
                <form action="{{ route('brands.index') }}" method="GET" class="flex w-full md:w-1/2 lg:w-1/3">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar marca ou ID..." 
                               class="w-full bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 rounded-l-xl focus:ring-orange-500 focus:border-orange-500 text-gray-700 dark:text-gray-300 pr-10">
                        @if(request('search'))
                            <a href="{{ route('brands.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-6 rounded-r-xl transition border border-l-0 border-gray-300 dark:border-gray-700">
                        Filtrar
                    </button>
                </form>
            </div>

            <div class="w-full bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50/50 dark:bg-gray-900/30">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest w-24">ID</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Marca</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest w-64">Ações Disponíveis</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($brands as $brand)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-orange-600 italic">#{{ $brand->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300 capitalize">{{ $brand->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex justify-center gap-3">
                                            {{-- Ação: Visualizar --}}
                                            <a href="{{ route('brands.show', $brand->id) }}" class="p-2 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-300 rounded-lg hover:bg-emerald-600 dark:hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="Ver Detalhes">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>

                                            {{-- Ação: Editar --}}
                                            <a href="{{ route('brands.edit', $brand->id) }}" class="p-2 bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 rounded-lg hover:bg-blue-600 dark:hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Editar Marca">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                            </a>

                                            {{-- Ação: Excluir --}}
                                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Atenção: Excluir esta marca pode afetar veículos vinculados. Continuar?')" class="p-2 bg-red-50 dark:bg-red-900/40 text-red-600 dark:text-red-300 rounded-lg hover:bg-red-600 dark:hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Excluir Marca">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic text-sm">Nenhuma marca cadastrada no sistema.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($brands->hasPages())
                    <div class="px-8 py-4 bg-gray-50/50 dark:bg-gray-900/20 border-t border-gray-100 dark:border-gray-700">
                        {{ $brands->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>