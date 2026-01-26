<x-app-layout>
    <form method="POST" action="{{ route('company.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Editar Empresa</h2>
                <div class="flex justify-end gap-2 pt-2">
                    <a href="{{ route('company.show') }}"
                        class="px-4 py-2 border rounded">
                            Cancelar
                    </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </div>

        {{-- DADOS DA EMPRESA --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Informações Gerais</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm text-gray-600">Razão Social</label>
                    <input type="text" name="name"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('name', $company->name) }}">
                    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Nome Fantasia</label>
                    <input type="text" name="name_fantasy"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('name_fantasy', $company->name_fantasy) }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">CPF / CNPJ</label>
                    <input type="text" name="cpf_cnpj"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('cpf_cnpj', $company->cpf_cnpj) }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('email', $company->email) }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Telefone</label>
                    <input type="text" name="phone"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('phone', $company->phone) }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Website</label>
                    <input type="text" name="website"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('website', $company->website) }}">
                </div>

            </div>
        </div>

        {{-- ENDEREÇO --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Endereço</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm text-gray-600">Rua</label>
                    <input type="text" name="address[street]"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('address.street', $company->address->street ?? '') }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Número</label>
                    <input type="text" name="address[number]"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('address.number', $company->address->number ?? '') }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Bairro</label>
                    <input type="text" name="address[district]"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('address.district', $company->address->district ?? '') }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Cidade</label>
                    <input type="text" name="address[city]"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('address.city', $company->address->city ?? '') }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Estado</label>
                    <input type="text" name="address[state]"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('address.state', $company->address->state ?? '') }}">
                </div>

                <div>
                    <label class="text-sm text-gray-600">CEP</label>
                    <input type="text" name="address[zip_code]"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('address.zip_code', $company->address->zip_code ?? '') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Complemento</label>
                    <input type="text" name="address[complement]"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ old('address.complement', $company->address->complement ?? '') }}">
                </div>

            </div>
        </div>

    </form>
</x-app-layout>
