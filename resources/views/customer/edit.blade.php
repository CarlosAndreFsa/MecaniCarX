<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 md:px-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
                    Editar Cliente <span class="text-orange-600">{{ $customer->name }}</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Atualize os dados do cliente em sua oficina</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('customer.index') }}"
                   class="px-5 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-semibold text-sm shadow-sm">
                    Cancelar
                </a>
                <button type="submit" form="main-form"
                        class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm">
                    Atualizar Cliente
                </button>
            </div>
        </div>
    </x-slot>

    <div class="pt-4 pb-8 w-full max-w-7xl mx-auto">
        <div class="px-4 md:px-8">
            <form id="main-form" method="POST" action="{{ route('customer.update', $customer) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- DADOS GERAIS --}}
                <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-6 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informações Gerais
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Razão Social / Nome</label>
                            <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                            @error('name') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nome Fantasia</label>
                            <input type="text" name="name_fantasy" value="{{ old('name_fantasy', $customer->name_fantasy) }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">CPF / CNPJ</label>
                            <input type="text" name="cpf_cnpj" value="{{ old('cpf_cnpj', $customer->cpf_cnpj) }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Telefone</label>
                            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Website</label>
                            <input type="text" name="website" value="{{ old('website', $customer->website) }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>
                    </div>
                </div>

                {{-- ENDEREÇO --}}
                <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-6 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Endereço
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Rua / Logradouro</label>
                            <input type="text" name="address[street]" value="{{ old('address.street', $customer->address->street ?? '') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Número</label>
                            <input type="text" name="address[number]" value="{{ old('address.number', $customer->address->number ?? '') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Bairro</label>
                            <input type="text" name="address[district]" value="{{ old('address.district', $customer->address->district ?? '') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Cidade</label>
                            <input type="text" name="address[city]" value="{{ old('address.city', $customer->address->city ?? '') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                            <input type="text" name="address[state]" value="{{ old('address.state', $customer->address->state ?? '') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">CEP</label>
                            <input type="text" name="address[zip_code]" value="{{ old('address.zip_code', $customer->address->zip_code ?? '') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Complemento</label>
                            <input type="text" name="address[complement]" value="{{ old('address.complement', $customer->address->complement ?? '') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
