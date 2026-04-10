<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-4 md:px-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
                    Dados da <span class="text-orange-600">Empresa</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Detalhes e configurações da sua oficina</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('company.edit', $company->id ?? 1) }}"
                   class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Editar Empresa
                </a>
            </div>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 w-full max-w-7xl mx-auto">
        <div class="px-4 md:px-8 space-y-6">

            {{-- CARD 1: INFORMAÇÕES GERAIS --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-6 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-1 h-full bg-orange-500"></div>
                
                <div class="flex justify-between items-start mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <h3 class="text-lg font-black text-gray-700 dark:text-gray-200 flex items-center gap-2 uppercase tracking-tighter"> 
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Informações Principais
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nome Fantasia / Razão Social</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $company->name ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">CNPJ / Documento</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $company->cnpj ?? $company->cpf_cnpj ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">E-mail de Contato</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $company->email ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Telefone / WhatsApp</p>
                        <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $company->phone ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>

            {{-- CARD 2: ENDEREÇO --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-6 border-l-4 border-l-orange-600">
                <h3 class="text-lg font-black text-gray-700 dark:text-gray-200 mb-6 flex items-center gap-2 uppercase tracking-tighter border-b border-gray-100 dark:border-gray-700 pb-4">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Endereço e Localização
                </h3>

                @if (isset($company->address) && ($company->address->street || $company->address->city))
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Logradouro</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $company->address->street }}, {{ $company->address->number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bairro</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $company->address->district ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Cidade / Estado</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $company->address->city ?? '—' }} / {{ $company->address->state ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">CEP</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ $company->address->zip_code ?? '—' }}</p>
                        </div>
                        @if($company->address->complement)
                            <div class="md:col-span-3 pt-4 border-t border-gray-100 dark:border-gray-700 mt-2">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Complemento</p>
                                <p class="text-base font-medium text-gray-600 dark:text-gray-300 italic">{{ $company->address->complement }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Nenhum endereço cadastrado para esta empresa.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
