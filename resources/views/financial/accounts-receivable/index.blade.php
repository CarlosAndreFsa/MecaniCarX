<x-app-layout>
    <div class="px-4 md:px-8 py-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Contas a Receber</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gerencie parcelas e baixas financeiras</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('accounts-receivable.print', request()->query()) }}" target="_blank"
                   class="px-4 py-2 border rounded-xl text-sm font-bold">Imprimir</a>
                <a href="{{ route('accounts-receivable.print', array_merge(request()->query(), ['format' => 'thermal'])) }}" target="_blank"
                   class="px-4 py-2 border rounded-xl text-sm font-bold">Térmica 80 mm</a>
                <a href="{{ route('accounts-receivable.export.csv', request()->query()) }}"
                   class="px-4 py-2 border rounded-xl text-sm font-bold">CSV</a>
                <a href="{{ route('accounts-receivable.export.pdf', request()->query()) }}" target="_blank"
                   class="px-4 py-2 border rounded-xl text-sm font-bold">PDF</a>
                <a href="{{ route('accounts-receivable.create') }}"
                   class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 text-sm font-bold shadow-sm">
                    + Nova conta
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl">{{ session('success') }}</div>
        @endif

        <form method="GET" class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cliente"
                       class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <select name="customer_id" class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <option value="">Todos os clientes</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="service_order" value="{{ request('service_order') }}" placeholder="Nº da OS"
                       class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <input type="date" name="from" value="{{ request('from') }}" title="Vencimento inicial"
                       class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <input type="date" name="to" value="{{ request('to') }}" title="Vencimento final"
                       class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <select name="status" class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <option value="">Todos os status</option>
                    @foreach(['open' => 'Em aberto (pendentes e parciais)', 'received' => 'Com recebimentos', 'paid' => 'Quitadas', 'canceled' => 'Canceladas'] as $value => $label)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <label class="text-sm font-bold text-gray-600 dark:text-gray-300">Agrupar por</label>
                <select name="group_by" class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <option value="">Sem agrupamento</option>
                    <option value="customer" {{ request('group_by') === 'customer' ? 'selected' : '' }}>Cliente</option>
                    <option value="service_order" {{ request('group_by') === 'service_order' ? 'selected' : '' }}>Ordem de Serviço</option>
                    <option value="due_date" {{ request('group_by') === 'due_date' ? 'selected' : '' }}>Vencimento</option>
                </select>
                <button class="px-5 py-2 bg-gray-800 text-white rounded-xl text-sm font-bold">Aplicar filtros</button>
                <a href="{{ route('accounts-receivable.index') }}" class="text-sm font-bold text-gray-500">Limpar</a>
            </div>
        </form>

        @if($groups)
            @foreach($groups as $groupName => $groupAccounts)
                <div class="space-y-3">
                    <h3 class="font-black text-gray-700 dark:text-gray-200">{{ $groupBy === 'due_date' ? \Carbon\Carbon::parse($groupName)->format('d/m/Y') : $groupName }}</h3>
                    @include('financial.accounts-receivable.partials.table', ['accounts' => $groupAccounts])
                </div>
            @endforeach
        @else
            @include('financial.accounts-receivable.partials.table', ['accounts' => $installments])
        @endif
    </div>
</x-app-layout>
