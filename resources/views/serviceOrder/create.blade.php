<x-app-layout>
    <form method="POST" action="{{ route('service-orders.store') }}" class="space-y-6">
        @csrf

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800"> Nova Ordem de Serviço </h2>
                <p class="text-sm text-gray-500"> Inicie um novo atendimento no MecaniCarX </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('service-orders.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition">
                    Salvar Ordem
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            {{-- CARD INFORMAÇÕES GERAIS --}}
            <div class="bg-white border rounded-xl shadow-sm p-6 border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-2"> Informações da Ordem </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Cliente --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Cliente </label>
                        <select name="customer_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500">
                            <option value="">Selecione o Cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Título --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Título </label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Ex: Troca de pastilhas"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500">
                        @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- DATAS E STATUS (GRID 3 COLUNAS) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:col-span-2">
                        {{-- Data de Entrada --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1"> Data de Entrada </label>
                            <input type="date" name="entry_date" value="{{ old('entry_date', now()->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm">
                            @error('entry_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Data de Saída --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1"> Data de Saída </label>
                            <input type="date" id="delivery_date" name="delivery_date" max="{{ date('Y-m-d') }}" value="{{ old('delivery_date') }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm disabled:bg-gray-100 disabled:cursor-not-allowed">
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1"> Status Inicial </label>
                            <select name="status" id="status_select" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500">
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Aberta</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                                <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD DESCRIÇÕES LADO A LADO --}}
            <div class="bg-white border rounded-xl shadow-sm p-6 border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-2"> Detalhamento do Serviço </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Descrição Cliente --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Descrição Cliente </label>
                        <textarea name="customer_description" rows="4" placeholder="Relato do cliente..."
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500">{{ old('customer_description') }}</textarea>
                                   @error('customer_description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    {{-- Descrição Técnico --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Descrição Técnico </label>
                        <textarea name="technical_description" rows="4" placeholder="Diagnóstico inicial..."
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500">{{ old('technical_description') }}</textarea>
                                                          @error('technical_description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

                    </div>
                </div>
            </div>

            {{-- CARD FINANCEIRO --}}
            <div class="bg-white border rounded-xl shadow-sm p-6 border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-2"> Informações Financeiras </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Mão de Obra (R$) </label>
                        <input type="number" step="0.01" id="labor_cost" name="labor_cost" value="{{ old('labor_cost', '0.00') }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Peças (R$) </label>
                        <input type="number" step="0.01" id="parts_cost" name="parts_cost" value="{{ old('parts_cost', '0.00') }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-blue-700 mb-1"> Total Previsto (R$) </label>
                        <input type="number" step="0.01" id="total" name="total" value="{{ old('total', '0.00') }}"
                               class="w-full bg-blue-50 border-blue-200 font-bold text-blue-800 rounded-lg shadow-sm focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const laborInput = document.getElementById('labor_cost');
        const partsInput = document.getElementById('parts_cost');
        const totalInput = document.getElementById('total');
        const statusSelect = document.getElementById('status_select');
        const deliveryDateInput = document.getElementById('delivery_date');

        // Formata para 2 casas decimais (ex: 10 -> 10.00)
        function formatValue(input) {
            if (input.value) {
                input.value = parseFloat(input.value).toFixed(2);
            }
        }

        function calculateTotal() {
            const labor = parseFloat(laborInput.value) || 0;
            const parts = parseFloat(partsInput.value) || 0;
            totalInput.value = (labor + parts).toFixed(2);
        }

        function handleStatusChange() {
            const today = new Date().toISOString().split('T')[0];
            if (statusSelect.value === 'completed') {
                deliveryDateInput.disabled = false;
                deliveryDateInput.setAttribute('max', today);
                if (!deliveryDateInput.value) deliveryDateInput.value = today;
            } else {
                deliveryDateInput.disabled = true;
                deliveryDateInput.value = ''; 
            }
        }

        // Eventos Financeiros
        [laborInput, partsInput].forEach(input => {
            input.addEventListener('input', calculateTotal);
            input.addEventListener('blur', function() {
                formatValue(this);
                calculateTotal();
            });
        });

        // Evento de Status
        statusSelect.addEventListener('change', handleStatusChange);

        // Impedir data futura manualmente
       deliveryDateInput.addEventListener('change', function() {
    const localToday = new Date().toLocaleDateString('en-CA');
    
    if (this.value > localToday) {
        alert('A data de saída não pode ser futura.');
        this.value = localToday;
    }
});

        // Inicialização
        handleStatusChange();
        calculateTotal();
    });
</script>
</x-app-layout>