<x-app-layout>
    <h2 class="text-xl font-semibold mb-4">Editar Usuário</h2>

    <form method="POST"
          action="{{ route('users.update', $user) }}"
          class="bg-white shadow rounded p-4 space-y-4 max-w-3xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Nome</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full border rounded p-2"
                    required
                >
                 @error('name')
                    <div class="alert flex space-x-2 rounded-lg px-4 py-4 text-red-600 text-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full border rounded p-2"
                    required
                >
                 @error('email')
                    <div class="alert flex space-x-2 rounded-lg px-4 py-4 text-red-600 text-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Role</label>
                <select name="role" class="w-full border rounded p-2" required>
                    <option value="admin" @selected(old($user->role) === 'admin')>Administrador</option>
                    <option value="employee" @selected(old($user->role) === 'employee')>Funcionário</option>
                    <option value="client" @selected(old($user->role) === 'client')>Cliente</option>
                </select>
                 @error('role')
                    <div class="alert flex space-x-2 rounded-lg px-4 py-4 text-red-600 text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center pt-6">
                    <input type="hidden" name="active" value="0">

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="active" value="1" @checked($user->active)>
                    <span>Usuário ativo</span>
                </label>
                 @error('active')
                    <div class="alert flex space-x-2 rounded-lg px-4 py-4 text-red-600 text-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('users.index') }}"
               class="px-4 py-2 border rounded">
                Voltar
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                Atualizar
            </button>
        </div>
    </form>
</x-app-layout>
