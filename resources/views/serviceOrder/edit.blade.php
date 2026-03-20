<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 md:px-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
                    Editar Ordem de Serviço <span class="text-orange-600">#{{ $service_order->number }}</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Atualize os dados do atendimento no MecaniCarX</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('service-orders.index') }}"
                   class="px-5 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-semibold text-sm shadow-sm">
                    Cancelar
                </a>
                <button type="submit" form="main-form"
                        class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm">
                    Atualizar Ordem
                </button>
            </div>
        </div>
    </x-slot>

    <div class="pt-4 pb-8 w-full">
        <div class="px-4 md:px-8">
            <form id="main-form" method="POST" action="{{ route('service-orders.update', $service_order) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {{-- COLUNA DA ESQUERDA --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-6 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Identificação
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Cliente --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Cliente Proprietário </label>
<select name="customer_id" id="customer_id" class="w-full" required placeholder="Pesquisar cliente..."></select>                                    @error('customer_id') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                {{-- Veículo --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Veículo </label>
                                    <select name="vehicle_id" id="vehicle_id" 
                                            class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 text-sm font-semibold" 
                                            required>
                                        <option value="">Selecione o veículo</option>
                                    </select>
                                    @error('vehicle_id') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                {{-- Título --}}
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Título da Ordem </label>
                                    <input type="text" name="title" value="{{ old('title', $service_order->title) }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm">
                                </div>
                            </div>
                        </div>

                        {{-- CARD DESCRIÇÕES --}}
                        <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-6 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Detalhamento
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Relato do Cliente </label>
                                    <textarea name="customer_description" rows="5"
                                              class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 text-sm">{{ old('customer_description', $service_order->customer_description) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Diagnóstico Técnico </label>
                                    <textarea name="technical_description" rows="5"
                                              class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 text-sm">{{ old('technical_description', $service_order->technical_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- COLUNA DA DIREITA --}}
                    <div class="space-y-6">
                        {{-- STATUS E DATAS --}}
                        <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                            <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Gerenciamento</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <select name="status" id="status_select" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-sm font-bold">
                                        <option value="open" {{ old('status', $service_order->status) == 'open' ? 'selected' : '' }}>Aberta</option>
                                        <option value="in_progress" {{ old('status', $service_order->status) == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                                        <option value="completed" {{ old('status', $service_order->status) == 'completed' ? 'selected' : '' }}>Concluída</option>
                                        <option value="canceled" {{ old('status', $service_order->status) == 'canceled' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1">Data de Entrada</label>
                                    <input type="date" name="entry_date" value="{{ old('entry_date', $service_order->entry_date) }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold text-gray-700 dark:text-gray-200">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1">Data de Saída</label>
                                    <input type="date" id="delivery_date" name="delivery_date" 
                                           max="{{ date('Y-m-d') }}"
                                           value="{{ old('delivery_date', $service_order->delivery_date) }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold text-gray-700 dark:text-gray-200 disabled:opacity-30">
                                </div>
                            </div>
                        </div>

                        {{-- FINANCEIRO --}}
                        <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700 border-l-4 border-l-orange-600">
                            <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Financeiro</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1">Mão de Obra (R$)</label>
                                    <input type="number" step="0.01" id="labor_cost" name="labor_cost" 
                                           value="{{ number_format(old('labor_cost', $service_order->labor_cost), 2, '.', '') }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl text-right font-mono font-bold">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1">Peças (R$)</label>
                                    <input type="number" step="0.01" id="parts_cost" name="parts_cost" 
                                           value="{{ number_format(old('parts_cost', $service_order->parts_cost), 2, '.', '') }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl text-right font-mono font-bold">
                                </div>
                                <div class="pt-4 border-t dark:border-gray-700">
                                    <label class="block text-xs font-black text-orange-600 uppercase mb-1">Total Geral</label>
                                    <input type="number" step="0.01" id="total" name="total" 
                                           value="{{ number_format(old('total', $service_order->total), 2, '.', '') }}" readonly
                                           class="w-full bg-orange-50 dark:bg-orange-900/20 border-orange-200 dark:border-orange-800 font-black text-orange-600 rounded-xl text-right text-lg font-mono">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const vehicleSelect = document.getElementById('vehicle_id');

        // 1. Inicializa o TomSelect com permissão para apagar (plugins: ['clear_button'])
        const customerSelect = new TomSelect('#customer_id', {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: 'Pesquisar cliente...',
            allowEmptyOption: true,
            loadThrottle: 400,
            load: function(query, callback) {
                fetch(`{{ route('customers.search') }}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(json => callback(json))
                    .catch(() => callback());
            },
            onChange: function(customerId) {
                // Sempre que mudar ou apagar o cliente, recarrega os veículos
                loadVehicles(customerId);
            },
            render: {
                option: (data, escape) => `<div class="px-3 py-2 text-gray-800 dark:text-gray-200">${escape(data.name)}</div>`,
                item: (data, escape) => `<div class="text-gray-800 dark:text-gray-100 font-medium">${escape(data.name)}</div>`
            }
        });

        // 2. Função Robusta para carregar veículos
        function loadVehicles(customerId, selectedVehicleId = null) {
            // Se apagar o cliente, limpa o veículo
            if (!customerId) {
                vehicleSelect.innerHTML = '<option value="">Selecione o cliente primeiro</option>';
                vehicleSelect.disabled = true;
                return;
            }

            vehicleSelect.disabled = true;
            vehicleSelect.innerHTML = '<option value="">Buscando veículos...</option>';

            // URL absoluta para evitar erros de diretório
            fetch(`/api/customers/${customerId}/vehicles`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                vehicleSelect.innerHTML = '<option value="">Selecione o veículo</option>';
                
                if (data.length > 0) {
                    data.forEach(v => {
                        const isSelected = (selectedVehicleId == v.id) ? 'selected' : '';
                        vehicleSelect.innerHTML += `<option value="${v.id}" ${isSelected}>${v.plate.toUpperCase()} - ${v.model}</option>`;
                    });
                    vehicleSelect.disabled = false;
                } else {
                    vehicleSelect.innerHTML = '<option value="">Cliente sem veículos cadastrados</option>';
                }
            })
            .catch(err => {
                console.error("Erro AJAX:", err);
                vehicleSelect.innerHTML = '<option value="">Erro ao carregar veículos</option>';
            });
        }

        // 3. CARGA INICIAL (Pulo do Gato para o Edit)
        // Pegamos os dados que já existem na OS do banco
        const initialCustomerId = "{{ $service_order->customer_id }}";
        const initialCustomerName = "{{ $service_order->customer->name }}";
        const initialVehicleId = "{{ $service_order->vehicle_id }}";

        if (initialCustomerId) {
            // Adiciona o cliente atual como opção e seleciona
            customerSelect.addOption({id: initialCustomerId, name: initialCustomerName});
            customerSelect.setValue(initialCustomerId);
            
            // Carrega os veículos e já deixa o veículo da OS marcado
            loadVehicles(initialCustomerId, initialVehicleId);
        }
    });
</script>
@endpush
</x-app-layout>