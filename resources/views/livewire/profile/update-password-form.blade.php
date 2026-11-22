<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="space-y-6">
    <header class="border-b border-gray-100 dark:border-gray-800 pb-4">
        <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">
            {{ __('Atualizar Senha') }}
        </h2>

        <p class="mt-1 text-xs font-medium text-gray-500 dark:text-gray-400">
            {{ __('Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6" novalidate>
        {{-- Senha Atual --}}
        <div class="space-y-1">
            <label for="update_password_current_password" class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">
                {{ __('Senha Atual') }} <span class="text-red-600 dark:text-red-400" aria-hidden="true">*</span>
            </label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full bg-gray-50 dark:bg-gray-900 border @error('current_password') border-red-500 @else border-gray-200 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-sm font-bold text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" />

            @error('current_password')
                <p class="text-red-600 dark:text-red-400 text-[10px] mt-1 font-black uppercase italic tracking-tighter">
                    * {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Nova Senha --}}
        <div class="space-y-1">
            <label for="update_password_password" class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">
                {{ __('Nova Senha') }} <span class="text-red-600 dark:text-red-400" aria-hidden="true">*</span>
            </label>
            <input wire:model="password" id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full bg-gray-50 dark:bg-gray-900 border @error('password') border-red-500 @else border-gray-200 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-sm font-bold text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" />

            @error('password')
                <p class="text-red-600 dark:text-red-400 text-[10px] mt-1 font-black uppercase italic tracking-tighter">
                    * {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Confirmar Nova Senha --}}
        <div class="space-y-1">
            <label for="update_password_password_confirmation" class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">
                {{ __('Confirmar Nova Senha') }} <span class="text-red-600 dark:text-red-400" aria-hidden="true">*</span>
            </label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full bg-gray-50 dark:bg-gray-900 border @error('password_confirmation') border-red-500 @else border-gray-200 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-sm font-bold text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" />

            @error('password_confirmation')
                <p class="text-red-600 dark:text-red-400 text-[10px] mt-1 font-black uppercase italic tracking-tighter">
                    * {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Botão Salvar + Feedback --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center justify-center px-6 py-2.5 bg-orange-600 hover:bg-orange-500 active:bg-orange-700 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-sm shadow-orange-600/20 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all cursor-pointer">
                <span wire:loading.remove wire:target="updatePassword">{{ __('Salvar Alterações') }}</span>
                <span wire:loading wire:target="updatePassword">{{ __('Salvando...') }}</span>
            </button>

            <x-action-message class="text-xs font-black uppercase tracking-wider text-emerald-600 dark:text-emerald-400" on="password-updated">
                {{ __('✓ Salvo com sucesso.') }}
            </x-action-message>
        </div>
    </form>
</section>