<x-app-layout>
     <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Listar Clientes</h2>
            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('painel') }}"
                    class="px-4 py-2 border rounded">
                        Dashboad
                </a>
            </div>
        </div>
     </div>

 <h2 class="text-xl font-semibold mb-4">Clientes</h2>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="border-b">
                <th class="p-2">Nome</th>
                <th class="p-2">Nome Fantasia</th>
                <th class="p-2">Email</th>
                <th class="p-2">Status</th>
                <th class="p-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr class="border-b">
                    <td class="p-2">{{ $customer->name }}</td>
                     <td class="p-2">{{ $customer->name_fantasy }}</td>
                    <td class="p-2">{{ $customer->email }}</td>                   
                    <td class="p-2">
                        {{ $customer->active ? 'Ativo' : 'Inativo' }}
                    </td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('customer.edit', $customer) }}">Editar</a>
                        <a href="{{ route('customer.show', $customer) }}">Detalhes</a>

                        <form method="POST"
                              {{-- action="{{ route('customer.active', $customer) }}" --}}
                              class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit">
                                {{ $customer->active ? 'Desativar' : 'Ativar' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>