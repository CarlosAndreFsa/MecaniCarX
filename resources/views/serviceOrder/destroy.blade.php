<x-app-layout>
    <div class="space-y-6"> 
        {{-- HEADER --}} 
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800"> Ordem de Serviço #{{ $service_order->number }} </h2>
                <p class="text-sm text-gray-500"> Criada em {{ $service_order->created_at->format('d/m/Y H:i') }} </p>
            </div>
            <div class="flex gap-2"> 
                <a href="{{ route('service-orders.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition"> Voltar </a> 
                <a href="{{ route('service-orders.edit', $service_order->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 shadow-sm transition"> Editar </a> 
            </div>
        </div> 

        {{-- CARD INFORMAÇÕES GERAIS --}} 
        <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-2"> Informações da Ordem </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6"> 
                {{-- CLIENTE --}} 
                <div>
                    <p class="text-sm font-medium text-gray-500">Cliente</p>
                    <p class="text-base font-semibold text-gray-800"> {{ $service_order->customer->name }} </p>
                </div> 

                {{-- DATA DE ENTRADA --}} 
                <div>
                    <p class="text-sm font-medium text-gray-500">Data de Entrada</p>
                    <p class="text-base text-gray-800">
                        {{ \Carbon\Carbon::parse($service_order->entry_date)->format('d/m/Y') }} 
                    </p>
                </div>

                {{-- DATA DE SAÍDA --}} 
                <div>
                    <p class="text-sm font-medium text-gray-500">Data de Saída</p>
                    <p class="text-base text-gray-800">
                        {{ $service_order->delivery_date ? \Carbon\Carbon::parse($service_order->delivery_date)->format('d/m/Y') : '---' }} 
                    </p>
                </div>

                {{-- STATUS --}} 
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Status</p> 
                    @php
                        $statusColors = [
                            'open' => 'bg-gray-100 text-gray-700',
                            'in_progress' => 'bg-yellow-100 text-yellow-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'canceled' => 'bg-red-100 text-red-700',
                        ];
                        $statusLabels = [
                            'open' => 'Aberta',
                            'in_progress' => 'Em andamento',
                            'completed' => 'Concluída',
                            'canceled' => 'Cancelada',
                        ];
                    @endphp
                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusColors[$service_order->status] ?? 'bg-gray-100' }}"> 
                        {{ $statusLabels[$service_order->status] ?? $service_order->status }}
                    </span>
                </div> 
            </div>
        </div> 

        {{-- CARD TÍTULO E DESCRIÇÕES LADO A LADO --}} 
        <div class="bg-white border rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <p class="text-sm font-medium text-gray-500">Título do Serviço</p>
                <p class="text-lg text-gray-800 font-semibold"> {{ $service_order->title }} </p>
            </div>

            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-2"> Detalhamento do Serviço </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Relato do Cliente --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Relato do Cliente</p>
                    <p class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">
                        {{ $service_order->customer_description ?? 'Nenhuma descrição fornecida.' }}
                    </p>
                </div>

                {{-- Parecer Técnico --}}
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <p class="text-sm font-bold text-blue-800 mb-2 uppercase tracking-wider">Parecer Técnico</p>
                    <p class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">
                        {{ $service_order->technical_description ?? 'Diagnóstico ainda não realizado.' }}
                    </p>
                </div>
            </div>
        </div> 

        {{-- CARD FINANCEIRO --}} 
        <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-2"> Informações Financeiras </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Mão de Obra</p>
                    <p class="text-xl font-bold text-gray-800"> R$ {{ number_format($service_order->labor_cost, 2, ',', '.') }} </p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Peças</p>
                    <p class="text-xl font-bold text-gray-800"> R$ {{ number_format($service_order->parts_cost, 2, ',', '.') }} </p>
                </div>
                <div class="p-3 bg-blue-600 rounded-lg shadow-inner">
                    <p class="text-sm font-medium text-blue-100">Total Geral</p>
                    <p class="text-2xl font-black text-white"> R$ {{ number_format($service_order->total, 2, ',', '.') }} </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>