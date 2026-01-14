<x-app-layout>
    <h2 class="text-xl font-semibold mb-4">Usuários</h2>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="border-b">
                <th class="p-2">Nome</th>
                <th class="p-2">Email</th>
                <th class="p-2">Role</th>
                <th class="p-2">Status</th>
                <th class="p-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="border-b">
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2">{{ ucfirst($user->role) }}</td>
                    <td class="p-2">
                        {{ $user->active ? 'Ativo' : 'Inativo' }}
                    </td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('users.edit', $user) }}">Editar</a>

                        <form method="POST"
                              {{-- action="{{ route('users.toggle-active', $user) }}" --}}
                              class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit">
                                {{ $user->active ? 'Desativar' : 'Ativar' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
