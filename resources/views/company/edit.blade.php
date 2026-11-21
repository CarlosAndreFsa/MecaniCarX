<x-app-layout>
    <form method="POST" action="{{ route('company.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-4 md:px-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
                        Editar Dados da <span class="text-orange-600">Empresa</span>
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Atualize as informações institucionais e de localização</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('company.show') }}"
                       class="px-5 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-semibold text-sm shadow-sm flex items-center justify-center">
                        Cancelar
                    </a>
                    
                    <button type="submit"
                       class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm flex items-center justify-center">
                        Salvar Alterações
                    </button>
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
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Informações Gerais
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Razão Social</label>
                            <input type="text" name="name"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('name', $company->name) }}">
                            @error('name') <p class="text-red-600 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Nome Fantasia</label>
                            <input type="text" name="name_fantasy"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('name_fantasy', $company->name_fantasy) }}">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">CPF / CNPJ</label>
                            <input type="text" name="cpf_cnpj"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('cpf_cnpj', $company->cpf_cnpj) }}">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Email Corporativo</label>
                            <input type="email" name="email"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('email', $company->email) }}">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Telefone</label>
                            <input type="text" name="phone"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('phone', $company->phone) }}">
                        </div>

                        <div class="md:col-span-3">
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Website</label>
                            <input type="text" name="website"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('website', $company->website) }}">
                        </div>
                    </div>
                </div>

                {{-- CARD 2: ENDEREÇO --}}
                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-6 border-l-4 border-l-orange-600">
                    <h3 class="text-lg font-black text-gray-700 dark:text-gray-200 mb-6 flex items-center gap-2 uppercase tracking-tighter border-b border-gray-100 dark:border-gray-700 pb-4">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Endereço de Faturamento
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-3">
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Logradouro (Rua)</label>
                            <input type="text" name="address[street]"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('address.street', $company->address->street ?? '') }}">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Número</label>
                            <input type="text" name="address[number]"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('address.number', $company->address->number ?? '') }}">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Bairro</label>
                            <input type="text" name="address[district]"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('address.district', $company->address->district ?? '') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Cidade</label>
                            <input type="text" name="address[city]"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('address.city', $company->address->city ?? '') }}">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Estado (UF)</label>
                            <input type="text" name="address[state]"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('address.state', $company->address->state ?? '') }}">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">CEP</label>
                            <input type="text" name="address[zip_code]"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-bold"
                                value="{{ old('address.zip_code', $company->address->zip_code ?? '') }}">
                        </div>

                        <div class="md:col-span-3">
                            <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 block">Complemento</label>
                            <input type="text" name="address[complement]"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 font-medium italic"
                                value="{{ old('address.complement', $company->address->complement ?? '') }}">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</x-app-layout>