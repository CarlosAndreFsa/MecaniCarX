@php
    $labels = ['pending' => 'Pendente', 'partially_paid' => 'Parcial', 'paid' => 'Recebida', 'canceled' => 'Cancelada'];
    $colors = ['pending' => 'bg-yellow-100 text-yellow-700', 'partially_paid' => 'bg-blue-100 text-blue-700', 'paid' => 'bg-green-100 text-green-700', 'canceled' => 'bg-red-100 text-red-700'];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-gray-50 dark:bg-gray-900/30">
            <tr>
                <th class="p-4 text-xs uppercase text-gray-500">Conta</th>
                <th class="p-4 text-xs uppercase text-gray-500">Cliente</th>
                <th class="p-4 text-xs uppercase text-gray-500">Origem</th>
                <th class="p-4 text-xs uppercase text-gray-500">Próximo vencimento</th>
                <th class="p-4 text-xs uppercase text-gray-500">Valor</th>
                <th class="p-4 text-xs uppercase text-gray-500">Recebido</th>
                <th class="p-4 text-xs uppercase text-gray-500">Status</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($accounts as $account)
                @php
                    $nextDue = $account->installments
                        ->where('status', 'pending')
                        ->sortBy(fn ($installment) => $installment->due_date)
                        ->first();
                    $nextDue = $nextDue ?: $account->installments->sortBy('due_date')->first();
                    $received = $account->installments->sum('received_amount');
                @endphp
                <tr>
                    <td class="p-4 font-bold text-gray-800 dark:text-gray-200">#{{ $account->id }}</td>
                    <td class="p-4 text-sm text-gray-700 dark:text-gray-300">{{ $account->customer->name }}</td>
                    <td class="p-4 text-sm">
                        @if($account->serviceOrder)
                            <a href="{{ route('service-orders.show', $account->serviceOrder) }}" class="font-bold text-blue-600">
                                OS #{{ $account->serviceOrder->number }}
                            </a>
                        @else
                            Cadastro direto
                        @endif
                    </td>
                    <td class="p-4 text-sm {{ $nextDue && $nextDue->due_date->isPast() && $account->status !== 'paid' ? 'text-red-600 font-bold' : '' }}">
                        {{ $nextDue?->due_date->format('d/m/Y') ?? $account->issue_date->format('d/m/Y') }}
                    </td>
                    <td class="p-4 font-mono font-bold">R$ {{ number_format($account->total, 2, ',', '.') }}</td>
                    <td class="p-4 font-mono text-green-700">R$ {{ number_format($received, 2, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colors[$account->status] }}">
                            {{ $labels[$account->status] }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('accounts-receivable.show', $account) }}" class="text-orange-600 font-bold text-sm">Ver</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="p-10 text-center text-gray-500">Nenhuma conta encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
