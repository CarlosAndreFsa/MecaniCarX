<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="space-y-6">
    <header class="border-b border-gray-100 dark:border-gray-800 pb-4">
        <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">
            {{ __('Informações do Perfil') }}
        </h2>

        <p class="mt-1 text-xs font-medium text-gray-500 dark:text-gray-400">
            {{ __('Atualize as informações de cadastro e o endereço de e-mail da sua conta.') }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6" novalidate>
        {{-- Nome --}}
        <div class="space-y-1">
            <label for="name" class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">
                {{ __('Nome Completo') }} <span class="text-red-600 dark:text-red-400" aria-hidden="true">*</span>
            </label>
            <input wire:model="name" id="name" name="name" type="text" autofocus autocomplete="name"
                class="w-full bg-gray-50 dark:bg-gray-900 border @error('name') border-red-500 @else border-gray-200 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-sm font-bold text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" />

            @error('name')
                <p class="text-red-600 dark:text-red-400 text-[10px] mt-1 font-black uppercase italic tracking-tighter">
                    * {{ $message }}
                </p>
            @enderror
        </div>

        {{-- E-mail --}}
        <div class="space-y-1">
            <label for="email" class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">
                {{ __('E-mail de Acesso') }} <span class="text-red-600 dark:text-red-400" aria-hidden="true">*</span>
            </label>
            <input wire:model="email" id="email" name="email" type="email" autocomplete="username"
                class="w-full bg-gray-50 dark:bg-gray-900 border @error('email') border-red-500 @else border-gray-200 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-sm font-bold text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" />

            @error('email')
                <p class="text-red-600 dark:text-red-400 text-[10px] mt-1 font-black uppercase italic tracking-tighter">
                    * {{ $message }}
                </p>
            @enderror

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50">
                    <p class="text-xs font-medium text-amber-800 dark:text-amber-300">
                        {{ __('Seu endereço de e-mail ainda não foi verificado.') }}

                        <button wire:click.prevent="sendVerification" type="button"
                            class="underline font-bold text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 focus:outline-none">
                            {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-emerald-600 dark:text-emerald-400">
                            {{ __('Um novo link de verificação foi enviado para o seu e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Botão Salvar + Feedback --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center justify-center px-6 py-2.5 bg-orange-600 hover:bg-orange-500 active:bg-orange-700 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-sm shadow-orange-600/20 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all cursor-pointer">
                <span wire:loading.remove wire:target="updateProfileInformation">{{ __('Salvar Alterações') }}</span>
                <span wire:loading wire:target="updateProfileInformation">{{ __('Salvando...') }}</span>
            </button>

            <x-action-message class="text-xs font-black uppercase tracking-wider text-emerald-600 dark:text-emerald-400" on="profile-updated">
                {{ __('✓ Salvo com sucesso.') }}
            </x-action-message>
        </div>
    </form>
</section>