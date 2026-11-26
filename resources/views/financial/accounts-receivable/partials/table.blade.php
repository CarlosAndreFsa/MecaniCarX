@php
    $labels = ['pending' => 'Pendente', 'paid' => 'Recebida', 'canceled' => 'Cancelada'];
    $colors = ['pending' => 'bg-yellow-100 text-yellow-700', 'paid' => 'bg-green-100 text-green-700', 'canceled' => 'bg-red-100 text-red-700'];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-gray-50 dark:bg-gray-900/30">
            <tr>
                <th class="p-4 text-xs uppercase text-gray-500">Conta / Parcela</th>
                <th class="p-4 text-xs uppercase text-gray-500">Cliente</th>
                <th class="p-4 text-xs uppercase text-gray-500">Origem</th>
                <th class="p-4 text-xs uppercase text-gray-500">Vencimento</th>
                <th class="p-4 text-xs uppercase text-gray-500">Valor da parcela</th>
                <th class="p-4 text-xs uppercase text-gray-500">Recebido</th>
                <th class="p-4 text-xs uppercase text-gray-500">Saldo</th>
                <th class="p-4 text-xs uppercase text-gray-500">Status</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($accounts as $installment)
                @php
                    $account = $installment->accountReceivable;
                    $statusLabel = $installment->received_amount > 0 && $installment->status === 'pending'
                        ? 'Parcial'
                        : $labels[$installment->status];
                    $statusColor = $installment->received_amount > 0 && $installment->status === 'pending'
                        ? 'bg-blue-100 text-blue-700'
                        : $colors[$installment->status];
                    $balance = max(0, (float) $installment->amount - (float) $installment->received_amount);
                @endphp
                <tr data-installment-row="{{ $installment->id }}">
                    <td class="p-4 font-bold text-gray-800 dark:text-gray-200">
                        #{{ $account->id }} <span class="text-xs text-gray-500">{{ $installment->number }}/{{ $account->installments->count() }}</span>
                    </td>
                    <td class="p-4 text-sm text-gray-700 dark:text-gray-300">{{ $account->customer->name }}</td>
                    <td class="p-4 text-sm">
                        @if($account->serviceOrder)
                            <a href="{{ route('service-orders.show', $account->serviceOrder) }}"
                               target="_blank" rel="noopener noreferrer" class="font-bold text-blue-600">
                                OS #{{ $account->serviceOrder->number }}
                            </a>
                        @else
                            Cadastro direto
                        @endif
                    </td>
                    <td class="p-4 text-sm {{ $installment->due_date->isPast() && $balance > 0 ? 'text-red-600 font-bold' : '' }}">
                        {{ $installment->due_date->format('d/m/Y') }}
                    </td>
                    <td class="p-4 font-mono font-bold">R$ {{ number_format($installment->amount, 2, ',', '.') }}</td>
                    <td class="p-4 font-mono text-green-700">R$ {{ number_format($installment->received_amount, 2, ',', '.') }}</td>
                    <td class="p-4 font-mono">R$ {{ number_format($balance, 2, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('accounts-receivable.show', $account) }}" class="text-orange-600 font-bold text-sm">Ver</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="p-10 text-center text-gray-500">Nenhuma parcela encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
