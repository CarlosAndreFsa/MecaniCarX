<x-app-layout>
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Dados do Cliente</h2>
            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('customer.index') }}"
                    class="px-4 py-2 bg-yellow-300 text-white rounded hover:bg-yellow-600">
                        Voltar
                </a>
                <a href="{{ route('customer.edit', $customer->id) }}"
                class="px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-700">
                    Editar
                </a>
            </div>
        </div>

        {{-- DADOS PRINCIPAIS --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Informações Gerais</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                <div>
                    <span class="text-gray-500">Razão Social</span>
                    <p class="font-medium">{{ $customer->name }}</p>
                </div>

                <div>
                    <span class="text-gray-500">Nome Fantasia</span>
                    <p class="font-medium">{{ $customer->name_fantasy ?? '—' }}</p>
                </div>

                <div>
                    <span class="text-gray-500">CPF / CNPJ</span>
                    <p class="font-medium">{{ $customer->cpf_cnpj ?? '—' }}</p>
                </div>

                <div>
                    <span class="text-gray-500">Email</span>
                    <p class="font-medium">{{ $customer->email ?? '—' }}</p>
                </div>

                <div>
                    <span class="text-gray-500">Telefone</span>
                    <p class="font-medium">{{ $customer->phone ?? '—' }}</p>
                </div>

                 <div>
                    <span class="text-gray-500">Website</span>
                    <p class="font-medium">
                        {{ $customer->website ?? '—' }}
                    </p>
                </div>

                <div>
                    <span class="text-gray-500">Status</span>
                    <p class="font-medium">
                        {{ $customer->active ? 'Ativo' : 'Inativo' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- ENDEREÇO --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Endereço</h3>

            @if ($customer->address)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                    <div>
                        <span class="text-gray-500">Logradouro</span>
                        <p class="font-medium">
                            {{ $customer->address->street }}, {{ $customer->address->number }}
                        </p>
                    </div>

                    <div>
                        <span class="text-gray-500">Bairro</span>
                        <p class="font-medium">{{ $customer->address->district }}</p>
                    </div>

                    <div>
                        <span class="text-gray-500">Cidade / Estado</span>
                        <p class="font-medium">
                            {{ $customer->address->city }} / {{ $customer->address->state }}
                        </p>
                    </div>

                    <div>
                        <span class="text-gray-500">CEP</span>
                        <p class="font-medium">{{ $customer->address->zip_code }}</p>
                    </div>

                    @if($customer->address->complement)
                        <div class="md:col-span-2">
                            <span class="text-gray-500">Complemento</span>
                            <p class="font-medium">{{ $customer->address->complement }}</p>
                        </div>
                    @endif

                </div>
            @else
                <p class="text-gray-500 text-sm">
                    Nenhum endereço cadastrado.
                </p>
            @endif
        </div>

    </div>
</x-app-layout>
