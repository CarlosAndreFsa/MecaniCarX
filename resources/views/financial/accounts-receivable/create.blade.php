<x-app-layout>
    <div class="px-4 md:px-8 py-6">
        <div class="max-w-3xl mx-auto space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Nova Conta a Receber</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Cadastro direto, independentemente de uma OS</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('accounts-receivable.store') }}" class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-2">Cliente</label>
                    <select name="customer_id" required class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        <option value="">Selecione</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Descrição</label>
                        <input type="text" name="description" value="{{ old('description') }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Valor total</label>
                        <input type="number" step="0.01" min="0.01" name="total" value="{{ old('total') }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Data de emissão</label>
                        <input type="date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Número de parcelas</label>
                        <input type="number" name="installments_count" min="1" max="60" value="{{ old('installments_count', 1) }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Primeiro vencimento</label>
                        <input type="date" name="first_due_date" value="{{ old('first_due_date', date('Y-m-d')) }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Observações</label>
                        <input type="text" name="notes" value="{{ old('notes') }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    </div>
                </div>

                <label class="flex items-center gap-3 font-bold">
                    <input type="checkbox" id="immediate_payment" name="immediate_payment" value="1" {{ old('immediate_payment') ? 'checked' : '' }} class="rounded text-orange-600">
                    Conta já recebida
                </label>
                <div id="payment_method_field" class="hidden">
                    <label class="block text-sm font-bold mb-2">Forma de recebimento</label>
                    <select name="payment_method" class="w-full md:w-64 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        <option value="">Selecione</option>
                        <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Espécie</option>
                        <option value="pix" {{ old('payment_method') === 'pix' ? 'selected' : '' }}>PIX</option>
                        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Cartão</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('accounts-receivable.index') }}" class="px-5 py-2 border rounded-xl font-bold">Cancelar</a>
                    <button class="px-5 py-2 bg-orange-600 text-white rounded-xl font-bold">Salvar conta</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const immediate = document.getElementById('immediate_payment');
        const methodField = document.getElementById('payment_method_field');
        const toggle = () => methodField.classList.toggle('hidden', !immediate.checked);
        immediate.addEventListener('change', toggle);
        toggle();
    </script>
</x-app-layout>
