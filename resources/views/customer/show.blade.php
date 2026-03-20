<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-4 md:px-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
                    Dados do Cliente <span class="text-orange-600">{{ $customer->name }}</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Detalhes e informações de contato</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('customer.index') }}"
                   class="px-5 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-semibold text-sm shadow-sm flex items-center justify-center">
                    Voltar
                </a>
                
                <form method="POST" action="{{ route('customer.active', $customer) }}" class="inline m-0 p-0">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="h-full px-5 py-2 rounded-xl transition font-bold text-sm shadow-sm border flex items-center justify-center {{ $customer->active ? 'bg-red-50 text-red-600 hover:bg-red-100 border-red-200 dark:bg-red-900/20 dark:border-red-900/50 dark:hover:bg-red-900/40' : 'bg-green-50 text-green-600 hover:bg-green-100 border-green-200 dark:bg-green-900/20 dark:border-green-900/50 dark:hover:bg-green-900/40' }}">
                        {{ $customer->active ? 'Desativar' : 'Ativar' }}
                    </button>
                </form>

                <a href="{{ route('customer.edit', $customer) }}"
                   class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm flex items-center justify-center">
                    Editar Cliente
                </a>
            </div>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 w-full max-w-7xl mx-auto">
        <div class="px-4 md:px-8 space-y-6">

            {{-- CARD 1: INFORMAÇÕES GERAIS --}} 
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-6 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-1 h-full {{ $customer->active ? 'bg-green-500' : 'bg-red-500' }}"></div>
                
                <div class="flex justify-between items-start mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <h3 class="text-lg font-black text-gray-700 dark:text-gray-200 flex items-center gap-2 uppercase tracking-tighter"> 
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informações Gerais
                    </h3>
                    <div>
                        @if($customer->active)
                            <span class="px-3 py-1 text-[10px] font-black rounded-lg uppercase bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">Ativo</span>
                        @else
                            <span class="px-3 py-1 text-[10px] font-black rounded-lg uppercase bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">Inativo</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Razão Social / Nome</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->name }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nome Fantasia</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->name_fantasy ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">CPF / CNPJ</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->cpf_cnpj ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->email ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Telefone</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->phone ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Website</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">
                            @if($customer->website)
                                <a href="{{ str_starts_with($customer->website, 'http') ? $customer->website : 'https://'.$customer->website }}" target="_blank" class="text-orange-600 hover:underline">{{ $customer->website }}</a>
                            @else
                                —
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- CARD 2: ENDEREÇO --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-6 border-l-4 border-l-orange-600">
                <h3 class="text-lg font-black text-gray-700 dark:text-gray-200 mb-6 flex items-center gap-2 uppercase tracking-tighter border-b border-gray-100 dark:border-gray-700 pb-4">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Endereço
                </h3>

                @if ($customer->address && ($customer->address->street || $customer->address->city))
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Logradouro</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->address->street }}, {{ $customer->address->number }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bairro</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->address->district ?? '—' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Cidade / Estado</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->address->city ?? '—' }} / {{ $customer->address->state ?? '—' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">CEP</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $customer->address->zip_code ?? '—' }}</p>
                        </div>

                        @if($customer->address->complement)
                            <div class="md:col-span-3 pt-4 border-t border-gray-100 dark:border-gray-700 mt-2">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Complemento</p>
                                <p class="text-base font-medium text-gray-600 dark:text-gray-300 italic">{{ $customer->address->complement }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Nenhum endereço cadastrado para este cliente.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
