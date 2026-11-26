<x-app-layout>
    <div class="px-4 md:px-8 py-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Conta a Receber #{{ $account->id }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $account->description }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('accounts-receivable.index') }}" class="px-4 py-2 border rounded-xl text-sm font-bold">Voltar</a>
                <a href="{{ route('accounts-receivable.export.pdf', ['customer_id' => $account->customer_id]) }}" target="_blank"
                   class="px-4 py-2 border rounded-xl text-sm font-bold">PDF</a>
                <button type="button" onclick="document.getElementById('email-report').classList.toggle('hidden')"
                        class="px-4 py-2 border rounded-xl text-sm font-bold">Enviar e-mail</button>
                @if($account->customer->phone)
                    @php
                        $phone = preg_replace('/\D/', '', $account->customer->phone);
                        $phone = str_starts_with($phone, '55') ? $phone : '55' . $phone;
                        $message = urlencode('Olá, ' . $account->customer->name . '. Confira o lançamento da conta #' . $account->id . '.');
                    @endphp
                    <a href="https://wa.me/{{ $phone }}?text={{ $message }}" target="_blank"
                       class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-bold">WhatsApp</a>
                @endif
            </div>
        </div>

        <form id="email-report" method="POST" action="{{ route('accounts-receivable.send-email') }}"
              class="hidden bg-white dark:bg-gray-800 p-4 rounded-2xl border grid grid-cols-1 md:grid-cols-4 gap-3">
            @csrf
            <input type="hidden" name="filters[customer_id]" value="{{ $account->customer_id }}">
            <input type="email" name="email" value="{{ $account->customer->email }}" placeholder="E-mail" required
                   class="md:col-span-1 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <input type="text" name="subject" value="Conta a receber #{{ $account->id }}"
                   class="md:col-span-1 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <input type="text" name="message" value="Segue o relatório da conta a receber."
                   class="md:col-span-1 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <button class="px-4 py-2 bg-orange-600 text-white rounded-xl font-bold">Enviar</button>
        </form>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border">
                <p class="text-xs font-bold uppercase text-gray-500">Cliente</p>
                <p class="font-bold mt-1">{{ $account->customer->name }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border">
                <p class="text-xs font-bold uppercase text-gray-500">Valor total</p>
                <p class="text-xl font-black text-orange-600 mt-1">R$ {{ number_format($account->total, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border">
                <p class="text-xs font-bold uppercase text-gray-500">Origem</p>
                <p class="font-bold mt-1">
                    @if($account->serviceOrder)
                        <a href="{{ route('service-orders.show', $account->serviceOrder) }}" class="text-blue-600 underline">
                            OS #{{ $account->serviceOrder->number }}
                        </a>
                    @else
                        Cadastro direto
                    @endif
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-900/30">
                    <tr>
                        <th class="p-4 text-xs uppercase text-gray-500">Parcela</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Vencimento</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Valor</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Recebido</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Status</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Baixa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($account->installments as $installment)
                        <tr>
                            <td class="p-4 font-bold">{{ $installment->number }}/{{ $account->installments->count() }}</td>
                            <td class="p-4">{{ $installment->due_date->format('d/m/Y') }}</td>
                            <td class="p-4 font-mono">R$ {{ number_format($installment->amount, 2, ',', '.') }}</td>
                            <td class="p-4 font-mono">R$ {{ number_format($installment->received_amount, 2, ',', '.') }}</td>
                            <td class="p-4">
                                @php
                                    $label = ['pending' => 'Pendente', 'paid' => 'Recebida', 'canceled' => 'Cancelada'][$installment->status];
                                @endphp
                                <span class="text-xs font-bold">{{ $label }}</span>
                            </td>
                            <td class="p-4">
                                @if($installment->status === 'pending')
                                    <form method="POST" action="{{ route('accounts-receivable.installments.receive', $installment) }}" class="flex flex-wrap gap-2">
                                        @csrf
                                        <input type="number" name="received_amount" step="0.01" min="0.01"
                                               max="{{ number_format($installment->amount - $installment->received_amount, 2, '.', '') }}"
                                               required value="{{ number_format($installment->amount - $installment->received_amount, 2, '.', '') }}"
                                               class="w-28 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                        <select name="payment_method" required class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                            <option value="cash">Espécie</option>
                                            <option value="pix">PIX</option>
                                            <option value="card">Cartão</option>
                                        </select>
                                        <button class="px-3 py-2 bg-green-600 text-white rounded-xl text-sm font-bold">Dar baixa</button>
                                    </form>
                                @elseif($installment->paid_at)
                                    <span class="text-xs text-gray-500">{{ $installment->paid_at->format('d/m/Y H:i') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($account->status !== 'paid' && $account->status !== 'canceled')
            <form method="POST" action="{{ route('accounts-receivable.cancel', $account) }}" onsubmit="return confirm('Cancelar esta conta a receber?')">
                @csrf
                @method('PATCH')
                <button class="px-5 py-2 bg-red-600 text-white rounded-xl text-sm font-bold">Cancelar conta</button>
            </form>
        @endif
    </div>
</x-app-layout>
