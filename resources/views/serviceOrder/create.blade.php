<x-app-layout>

    <form method="POST" action="{{ route('service-orders.store') }}" class="space-y-6">
        @csrf

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Nova Ordem de Serviço
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('service-orders.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </div>

        {{-- CARD PRINCIPAL --}}
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-700 mb-6">
                Informações Gerais
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Cliente --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Cliente
                    </label>
                    <select name="customer_id"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecione</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Título --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Título
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mão de obra --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Mão de Obra (R$)
                    </label>
                    <input type="number"
                           step="0.00"
                           name="labor_cost"
                           value="{{ old('labor_cost') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('labor_cost')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Peças --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Peças (R$)
                    </label>
                    <input type="number"
                           step="0.00"
                           name="parts_cost"
                           value="{{ old('parts_cost') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('parts_cost')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Data de Entrada --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Data de Entrada
                    </label>
                    <input type="date"
                           name="entry_date"
                           value="{{ old('entry_date') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('entry_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Descrição (linha inteira) --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Descrição
                </label>
                <textarea name="description"
                          rows="4"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </form>

</x-app-layout>
