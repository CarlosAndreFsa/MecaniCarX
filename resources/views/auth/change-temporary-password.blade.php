<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Alterar senha temporária</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
            Por segurança, defina uma nova senha antes de acessar o sistema.
        </p>
    </div>

    <form method="POST" action="{{ route('password.change.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Nova senha</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="mt-2 w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Confirmar nova senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="mt-2 w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
        </div>

        <button type="submit"
            class="w-full rounded-xl bg-orange-600 px-4 py-3 text-sm font-bold text-white hover:bg-orange-700">
            Atualizar senha e entrar
        </button>
    </form>
</x-guest-layout>
