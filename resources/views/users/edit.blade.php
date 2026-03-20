<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 md:px-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
                    Editar Usuário <span class="text-orange-600">{{ $user->name }}</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Atualize os dados e acessos deste usuário</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('users.index') }}"
                   class="px-5 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-semibold text-sm shadow-sm">
                    Cancelar
                </a>
                <button type="submit" form="main-form"
                        class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm">
                    Atualizar Usuário
                </button>
            </div>
        </div>
    </x-slot>

    <div class="pt-4 pb-8 w-full max-w-7xl mx-auto">
        <div class="px-4 md:px-8">
            <form id="main-form" method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-6 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Dados de Acesso
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nome</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                            @error('name') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                            @error('email') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Permissão (Role)</label>
                            <select name="role" required class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm text-sm">
                                <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrador</option>
                                <option value="employee" @selected(old('role', $user->role) === 'employee')>Funcionário</option>
                                <option value="client" @selected(old('role', $user->role) === 'client')>Cliente</option>
                            </select>
                            @error('role') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center mt-6">
                            <input type="hidden" name="active" value="0">
                            <label class="inline-flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="active" value="1" @checked($user->active) 
                                    class="w-5 h-5 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Usuário está Ativo</span>
                            </label>
                            @error('active') <p class="text-red-600 text-xs mt-1 ml-4 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
