<x-app-layout>
    <form method="POST" action="{{ route('service-orders.update', $service_order->id) }}" class="space-y-6"> @csrf
        @method('PUT') {{-- HEADER --}} <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800"> Editar Ordem de Serviço #{{ $service_order->number }} </h2>
            </div>
            <div class="flex gap-2"> <a href="{{ route('service-orders.index') }}"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100"> Cancelar </a> <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"> Atualizar </button> </div>
        </div> {{-- CARD INFORMAÇÕES GERAIS --}} <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-6"> Informações da Ordem </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- CLIENTE --}} <div> <label
                        class="block text-sm text-gray-600 mb-1"> Cliente </label> <select name="customer_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="">Selecione</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id', $service_order->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} </option>
                        @endforeach
                    </select> @error('customer_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> {{-- DATA DE ENTRADA --}} <div> <label class="block text-sm text-gray-600 mb-1"> Data de Entrada
                    </label> <input type="date" name="entry_date"
                        value="{{ old('entry_date', $service_order->entry_date) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm"> @error('entry_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> {{-- TITULO --}} <div> <label class="block text-sm text-gray-600 mb-1"> Título </label>
                    <input type="text" name="title" value="{{ old('title', $service_order->title) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm"> @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> {{-- STATUS --}} <div> <label class="block text-sm text-gray-600 mb-1"> Status </label>
                    <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="open" {{ old('status', $service_order->status) == 'open' ? 'selected' : '' }}>
                            Aberta </option>
                        <option value="in_progress"
                            {{ old('status', $service_order->status) == 'in_progress' ? 'selected' : '' }}> Em andamento
                        </option>
                        <option value="completed"
                            {{ old('status', $service_order->status) == 'completed' ? 'selected' : '' }}> Concluída
                        </option>
                        <option value="canceled"
                            {{ old('status', $service_order->status) == 'canceled' ? 'selected' : '' }}> Cancelada
                        </option>
                    </select> @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div> {{-- CARD DESCRIÇÃO --}} <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4"> Descrição do Serviço </h3>
            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm">{{ old('description', $service_order->description) }}</textarea> @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div> {{-- CARD FINANCEIRO --}} <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-6"> Informações Financeiras </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6"> {{-- MÃO DE OBRA --}} <div> <label
                        class="block text-sm text-gray-600 mb-1"> Mão de Obra </label> <input type="number"
                        step="0.01" name="labor_cost" value="{{ old('labor_cost', $service_order->labor_cost) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm"> @error('labor_cost')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> {{-- PEÇAS --}} <div> <label class="block text-sm text-gray-600 mb-1"> Peças </label>
                    <input type="number" step="0.01" name="parts_cost"
                        value="{{ old('parts_cost', $service_order->parts_cost) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm"> @error('parts_cost')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> {{-- TOTAL --}} <div> <label class="block text-sm text-gray-600 mb-1"> Total </label>
                    <input type="number" step="0.01" name="total"
                        value="{{ old('total', $service_order->total) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm"> @error('total')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
