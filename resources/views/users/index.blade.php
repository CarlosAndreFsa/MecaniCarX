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
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Usuários</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gerencie os acessos ao sistema</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('users.create') }}"
                    class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm">
                    + Novo Usuário
                </a>
            </div>
        </div>

        {{-- TABELA --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 dark:bg-gray-900/30 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Nome</th>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Acesso</th>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="p-4 text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
                                <td class="p-4">
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $user->name }}</div>
                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </td>
                                <td class="p-4">
                                    @php
                                        $roleColors = [
                                            'admin' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-400',
                                            'employee' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                                            'client' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                        ];
                                        $roleLabels = [
                                            'admin' => 'Administrador',
                                            'employee' => 'Funcionário',
                                            'client' => 'Cliente',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-black rounded-full tracking-tighter uppercase {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    @if($user->active)
                                        <span class="px-3 py-1 text-xs font-black rounded-full uppercase tracking-tighter bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">Ativo</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-black rounded-full uppercase tracking-tighter bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">Inativo</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2 items-center">
                                        <form method="POST" action="{{ route('users.active', $user) }}" class="inline m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-2 transition-colors {{ $user->active ? 'text-gray-400 hover:text-red-500' : 'text-gray-400 hover:text-green-500' }}" title="{{ $user->active ? 'Desativar' : 'Ativar' }}">
                                                @if($user->active)
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @endif
                                            </button>
                                        </form>
                                        <a href="{{ route('users.edit', $user) }}" class="p-2 text-gray-400 hover:text-blue-500 transition-colors" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-10 text-center text-gray-500 dark:text-gray-400 italic">Nenhum usuário encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
