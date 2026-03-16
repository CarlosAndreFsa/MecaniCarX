<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
            {{ __('Editar Veículo:') }} <span class="text-orange-600">{{ $vehicle->plate }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden p-8">
                <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                       
                        <div>
                            <label for="customer_id"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cliente
                                Proprietário *</label>
                            <select name="customer_id" id="customer_id" class="w-full" required
                                placeholder="Digite o nome do cliente..."></select>
                        </div>

                        {{-- Placa --}}
                        <div>
                            <label for="plate"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Placa do
                                Veículo *</label>
                            <input type="text" name="plate" id="plate"
                                value="{{ old('plate', $vehicle->plate) }}"
                                class="w-full uppercase rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                required>
                            @error('plate')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Marca --}}
                        <div>
                            <label for="brand_id"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Marca
                                *</label>
                            <select name="brand_id" id="brand_id"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                required>
                                <option value="">Selecione a Marca...</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $vehicle->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Modelo --}}
                        <div>
                            <label for="model"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Modelo
                                *</label>
                            <input type="text" name="model" id="model"
                                value="{{ old('model', $vehicle->model) }}"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                required>
                            @error('model')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ano --}}
                        <div>
                            <label for="year"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Ano de
                                Fabricação</label>
                            <input type="number" name="year" id="year"
                                value="{{ old('year', $vehicle->year) }}"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            @error('year')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Cor --}}
                        <div>
                            <label for="color"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cor do
                                Veículo</label>
                            <input type="text" name="color" id="color"
                                value="{{ old('color', $vehicle->color) }}"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            @error('color')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 gap-4">
                        <a href="{{ route('vehicles.index') }}"
                            class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition shadow-sm">Cancelar</a>
                        <button type="submit"
                            class="px-6 py-2 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition shadow-lg shadow-orange-600/30 hover:scale-105">Atualizar
                            Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        // Pegamos os dados do cliente que já existe no veículo
        const initialCustomer = {
            id: "{{ $vehicle->customer_id }}",
            name: "{{ $vehicle->customer->name ?? '' }}"
        };

        const control = new TomSelect('#customer_id', {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            loadThrottle: 300,
            shouldLoad: (query) => query.length > 2,

            // Configuração para carregar os dados via API
            load: function(query, callback) {
                const url = `{{ route('customers.search') }}?q=${encodeURIComponent(query)}`;
                fetch(url)
                    .then(response => response.json())
                    .then(json => callback(json))
                    .catch(() => callback());
            },

            render: {
                option: (data, escape) =>
                    `<div class="px-3 py-2 text-gray-800 dark:text-gray-200">${escape(data.name)}</div>`,
                item: (data, escape) =>
                    `<div class="text-gray-800 dark:text-gray-100 font-medium">${escape(data.name)}</div>`
            }
        });

        // Se existir um cliente inicial, nós adicionamos e selecionamos ele
        if (initialCustomer.id) {
            control.addOption({
                id: initialCustomer.id,
                name: initialCustomer.name
            });
            control.setValue(initialCustomer.id);
        }
    </script>
</x-app-layout>
