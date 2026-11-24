<x-app-layout>
    <div class="px-4 md:px-8 py-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Contas a Receber</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gerencie parcelas e baixas financeiras</p>
            </div>
            <a href="{{ route('accounts-receivable.create') }}"
               class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 text-sm font-bold shadow-sm">
                + Nova conta
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl">{{ session('success') }}</div>
        @endif

        <form method="GET" class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cliente"
                   class="flex-1 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <select name="status" class="md:w-48 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <option value="">Todos</option>
                @foreach(['pending' => 'Pendente', 'partially_paid' => 'Recebida parcialmente', 'paid' => 'Recebida', 'canceled' => 'Cancelada'] as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button class="px-5 py-2 bg-gray-800 text-white rounded-xl text-sm font-bold">Filtrar</button>
        </form>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-900/30">
                    <tr>
                        <th class="p-4 text-xs uppercase text-gray-500">Conta</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Cliente</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Emissão</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Valor</th>
                        <th class="p-4 text-xs uppercase text-gray-500">Status</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($accounts as $account)
                        @php
                            $labels = ['pending' => 'Pendente', 'partially_paid' => 'Parcial', 'paid' => 'Recebida', 'canceled' => 'Cancelada'];
                            $colors = ['pending' => 'bg-yellow-100 text-yellow-700', 'partially_paid' => 'bg-blue-100 text-blue-700', 'paid' => 'bg-green-100 text-green-700', 'canceled' => 'bg-red-100 text-red-700'];
                        @endphp
                        <tr>
                            <td class="p-4 font-bold text-gray-800 dark:text-gray-200">#{{ $account->id }}</td>
                            <td class="p-4 text-sm text-gray-700 dark:text-gray-300">{{ $account->customer->name }}</td>
                            <td class="p-4 text-sm">{{ $account->issue_date->format('d/m/Y') }}</td>
                            <td class="p-4 font-mono font-bold">R$ {{ number_format($account->total, 2, ',', '.') }}</td>
                            <td class="p-4"><span class="px-3 py-1 rounded-full text-xs font-bold {{ $colors[$account->status] }}">{{ $labels[$account->status] }}</span></td>
                            <td class="p-4 text-right">
                                <a href="{{ route('accounts-receivable.show', $account) }}" class="text-orange-600 font-bold text-sm">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-10 text-center text-gray-500">Nenhuma conta encontrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $accounts->links() }}
    </div>
</x-app-layout>
