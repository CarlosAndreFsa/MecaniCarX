<x-app-layout>
    <h2 class="text-xl font-semibold mb-4">Criar Usuário</h2>

    <form method="POST"
          action="{{ route('users.store') }}"
          class="bg-white shadow rounded p-4 space-y-4 max-w-3xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Nome</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
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
                    value="{{ old('email') }}"
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
                <label class="block text-sm font-medium">Senha</label>
                <input
                    type="password"
                    name="password"
                    class="w-full border rounded p-2"
                    required
                >
                 @error('password')
                    <div class="alert flex space-x-2 rounded-lg px-4 py-4 text-sm  text-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Role</label>
                <select name="role" class="w-full border rounded p-2" required>
                    <option value="">Selecione</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="employee" {{ old('role') === 'employee' ? 'selected' : '' }}>Funcionário</option>
                    <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Cliente</option>
                </select>
                 @error('role')
                    <div class="alert flex space-x-2 rounded-lg px-4 py-4 text-red-600 text-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('users.index') }}"
               class="px-4 py-2 border rounded">
                Cancelar
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                Salvar
            </button>
        </div>
    </form>
</x-app-layout>
