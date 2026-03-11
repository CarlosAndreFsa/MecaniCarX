<x-app-layout>
 
    <div class="space-y-6"> {{-- HEADER --}} <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800"> Ordem de Serviço #{{ $service_order->number }} </h2>
                <p class="text-sm text-gray-500"> Criada em {{ $service_order->created_at->format('d/m/Y H:i') }} </p>
            </div>
            <div class="flex gap-2"> <a href="{{ route('service-orders.index') }}"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100"> Voltar </a> <a
                    href="{{ route('service-orders.edit', $service_order->id) }}"
                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600"> Editar </a> </div>
        </div> {{-- CARD DADOS DA ORDEM --}} <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-6"> Informações da Ordem </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6"> {{-- CLIENTE --}} <div>
                    <p class="text-sm text-gray-500">Cliente</p>
                    <p class="text-base font-semibold text-gray-800"> {{ $service_order->customer->name }} </p>
                </div> {{-- STATUS --}} <div>
                    <p class="text-sm text-gray-500">Status</p> <span
                        class="px-3 py-1 text-sm rounded-full bg-gray-200 text-gray-700"> {{ ucfirst($service_order->status) }}
                    </span>
                </div> {{-- DATA DE ENTRADA --}} <div>
                    <p class="text-sm text-gray-500">Data de Entrada</p>
                    <p class="font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($service_order->entry_date)->format('d/m/Y') }} </p>
                </div>
            </div>
        </div> {{-- CARD DETALHES --}} <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4"> Detalhes do Serviço </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Título</p>
                    <p class="text-gray-800 font-medium"> {{ $service_order->title }} </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Descrição</p>
                    <p class="text-gray-800 whitespace-pre-line"> {{ $service_order->description }} </p>
                </div>
            </div>
        </div> {{-- CARD FINANCEIRO --}} <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-6"> Informações Financeiras </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Mão de Obra</p>
                    <p class="text-lg font-semibold text-green-600"> R$
                        {{ number_format($service_order->labor_cost, 2, ',', '.') }} </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Peças</p>
                    <p class="text-lg font-semibold text-blue-600"> R$
                        {{ number_format($service_order->parts_cost, 2, ',', '.') }} </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-xl font-bold text-gray-900"> R$ {{ number_format($service_order->total, 2, ',', '.') }} </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
