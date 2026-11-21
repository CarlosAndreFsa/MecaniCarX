<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-xl text-gray-900 dark:text-white uppercase tracking-tight leading-tight">
                {{ __('Configurações de Perfil') }}
            </h2>
            <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-500/20">
                Minha Conta
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Card 1: Dados do Perfil --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-lg dark:shadow-black/40 rounded-2xl">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            {{-- Card 2: Alterar Senha --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-lg dark:shadow-black/40 rounded-2xl">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            {{-- Card 3: Excluir Conta --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-red-200/60 dark:border-red-900/40 shadow-lg dark:shadow-black/40 rounded-2xl">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>