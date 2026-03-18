<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 md:px-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Nova Ordem de Serviço</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Inicie um atendimento profissional no MecaniCarX</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('service-orders.index') }}"
                   class="px-5 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-semibold text-sm shadow-sm">
                    Cancelar
                </a>
                <button type="submit" form="main-form"
                        class="px-5 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-600/20 transition font-bold text-sm">
                    Salvar Ordem
                </button>
            </div>
        </div>
    </x-slot>

    <div class="pt-4 pb-8 w-full">
        <div class="px-4 md:px-8">
            <form id="main-form" method="POST" action="{{ route('service-orders.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {{-- COLUNA DA ESQUERDA: IDENTIFICAÇÃO --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-6 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Identificação do Cliente e Veículo
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Cliente --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Cliente Proprietário * </label>
                                    <select name="customer_id" id="customer_id" class="w-full" required placeholder="Buscar por nome ou CPF..."></select>
                                    @error('customer_id') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                {{-- Veículo --}}
                                <div id="vehicle-wrapper">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Veículo * </label>
                                    <div class="flex gap-2">
                                        <select name="vehicle_id" id="vehicle_id" 
                                                class="flex-1 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 disabled:opacity-50 text-sm" 
                                                disabled required>
                                            <option value="">Selecione o cliente primeiro</option>
                                        </select>
                                        
                                        {{-- Botão Novo Veículo --}}
                                        <a href="{{ route('vehicles.create') }}" id="btn-new-vehicle" target="_blank"
                                           title="Cadastrar um novo veículo para este cliente (Abre em uma nova aba)"
                                           class="hidden px-3 py-2 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 rounded-xl border border-orange-200 dark:border-orange-800/50 hover:bg-orange-600 hover:text-white dark:hover:bg-orange-600 dark:hover:text-white transition-all whitespace-nowrap items-center justify-center font-bold text-xs uppercase tracking-wide shadow-sm gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    </a>
                                    </div>
                                    <p id="vehicle-msg" class="text-[10px] text-orange-600 mt-2 hidden font-bold italic uppercase">Este cliente não possui veículos cadastrados!</p>
                                    @error('vehicle_id') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                {{-- Título da OS --}}
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Título / Resumo do Serviço * </label>
                                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Ex: Revisão de 50.000km ou Troca de Embreagem" required
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 shadow-sm">
                                </div>
                            </div>
                        </div>

                        {{-- CARD DESCRIÇÕES --}}
                        <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-6 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Detalhamento Técnico
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Relato do Cliente </label>
                                    <textarea name="customer_description" rows="4" placeholder="O que o cliente relatou ao chegar..."
                                              class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 text-sm">{{ old('customer_description') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2"> Diagnóstico / Observações </label>
                                    <textarea name="technical_description" rows="4" placeholder="Análise técnica inicial..."
                                              class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-gray-700 dark:text-gray-200 text-sm">{{ old('technical_description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- COLUNA DA DIREITA: STATUS E FINANCEIRO --}}
                    <div class="space-y-6">
                        {{-- STATUS E DATAS --}}
                        <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Agendamento</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 italic">Status Inicial</label>
                                    <select name="status" id="status_select" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-orange-500 text-sm font-bold">
                                        <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Aberta</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                                        <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 italic">Data de Entrada</label>
                                    <input type="date" name="entry_date" value="{{ old('entry_date', now()->format('Y-m-d')) }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 italic text-orange-600">Previsão de Saída</label>
                                    <input type="date" id="delivery_date" name="delivery_date" value="{{ old('delivery_date') }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold disabled:opacity-30">
                                </div>
                            </div>
                        </div>

                        {{-- FINANCEIRO --}}
                        <div class="bg-white dark:bg-gray-800 border rounded-2xl shadow-sm p-6 border-gray-100 dark:border-gray-700 border-l-4 border-l-orange-600">
                            <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Custos Previstos</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 italic">Mão de Obra (R$)</label>
                                    <input type="number" step="0.01" id="labor_cost" name="labor_cost" value="{{ old('labor_cost', '0.00') }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl text-right font-mono font-bold">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 italic">Peças (R$)</label>
                                    <input type="number" step="0.01" id="parts_cost" name="parts_cost" value="{{ old('parts_cost', '0.00') }}"
                                           class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl text-right font-mono font-bold">
                                </div>
                                <div class="pt-4 border-t dark:border-gray-700">
                                    <label class="block text-xs font-black text-orange-600 uppercase mb-1 tracking-tighter">Total Geral Previsto</label>
                                    <input type="number" step="0.01" id="total" name="total" value="{{ old('total', '0.00') }}" readonly
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
            // 1. Inicializa o TomSelect para Busca Dinâmica de Clientes
            const customerSelect = new TomSelect('#customer_id', {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                loadThrottle: 400,
                load: function(query, callback) {
                    fetch(`{{ route('customers.search') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(json => callback(json))
                        .catch(() => callback());
                },
                // EVENTO QUANDO SELECIONA O CLIENTE
                onChange: function(customerId) {
                    const vehicleSelect = document.getElementById('vehicle_id');
                    const btnNewVehicle = document.getElementById('btn-new-vehicle');
                    const vehicleMsg = document.getElementById('vehicle-msg');

                    // Reset inicial dos campos de veículo
                    vehicleSelect.innerHTML = '<option value="">Carregando veículos...</option>';
                    vehicleSelect.disabled = true;
                    btnNewVehicle.classList.add('hidden');
                    btnNewVehicle.classList.remove('flex');
                    vehicleMsg.classList.add('hidden');

                    if (!customerId) {
                        vehicleSelect.innerHTML = '<option value="">Selecione o cliente primeiro</option>';
                        return;
                    }

                    // AJAX: Busca veículos do cliente na empresa logada
                    fetch(`/api/customers/${customerId}/vehicles`)
                        .then(res => {
                            if (!res.ok) throw new Error('Erro HTTP: ' + res.status);
                            return res.json();
                        })
                        .then(data => {
                            vehicleSelect.innerHTML = '<option value="">Selecione o veículo</option>';
                            
                            if (data.length > 0) {
                                data.forEach(v => {
                                    vehicleSelect.innerHTML += `<option value="${v.id}">${v.plate.toUpperCase()} - ${v.model}</option>`;
                                });
                                vehicleSelect.disabled = false;
                                btnNewVehicle.classList.remove('hidden'); // Opcional: mostrar para cadastrar outro carro
                                btnNewVehicle.classList.add('flex'); // Exibe o ícone e o texto alinhados

                                // Restaura o veículo selecionado em caso de erro de validação
                                @if(old('vehicle_id'))
                                    if (document.querySelector(`#vehicle_id option[value="{{ old('vehicle_id') }}"]`)) {
                                        vehicleSelect.value = "{{ old('vehicle_id') }}";
                                    }
                                @endif
                            } else {
                                vehicleSelect.innerHTML = '<option value="">Nenhum veículo encontrado</option>';
                                vehicleSelect.disabled = true;
                                // Ativa alerta e botão de novo veículo
                                btnNewVehicle.classList.remove('hidden');
                                btnNewVehicle.classList.add('flex');
                                vehicleMsg.classList.remove('hidden');
                            }
                        })
                        .catch((error) => {
                            console.error('Erro ao buscar veículos:', error);
                            vehicleSelect.innerHTML = '<option value="">Erro ao buscar veículos</option>';
                        });
                },
                render: {
                    option: (data, escape) => `<div class="px-3 py-2 text-gray-800 dark:text-gray-200">${escape(data.name)}</div>`,
                    item: (data, escape) => `<div class="text-gray-800 dark:text-gray-100 font-medium">${escape(data.name)}</div>`
                }
            });

            // 2. Lógica Financeira (Cálculo Automático)
            const laborInput = document.getElementById('labor_cost');
            const partsInput = document.getElementById('parts_cost');
            const totalInput = document.getElementById('total');

            function calculateTotal() {
                const labor = parseFloat(laborInput.value) || 0;
                const parts = parseFloat(partsInput.value) || 0;
                totalInput.value = (labor + parts).toFixed(2);
            }

            [laborInput, partsInput].forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            // 3. Controle de Datas (Habilita apenas se for concluída ou para agendar)
            const statusSelect = document.getElementById('status_select');
            const deliveryDateInput = document.getElementById('delivery_date');

            function handleStatusChange() {
                if (statusSelect.value === 'completed') {
                    if (!deliveryDateInput.value) {
                        deliveryDateInput.value = new Date().toISOString().split('T')[0];
                    }
                }
            }
            statusSelect.addEventListener('change', handleStatusChange);

            // 4. Lógica de Valores Antigos (Old) em caso de erro de validação
            @if(old('customer_id'))
                @php $oldC = \App\Models\Customer::find(old('customer_id')); @endphp
                @if($oldC)
                    customerSelect.addOption({id: '{{ $oldC->id }}', name: '{{ $oldC->name }}'});
                    customerSelect.setValue('{{ $oldC->id }}');
                @endif
            @endif
        });
    </script>
    @endpush
</x-app-layout>