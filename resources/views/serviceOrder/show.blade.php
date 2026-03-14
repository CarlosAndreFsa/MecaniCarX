<x-app-layout>
    {{-- Cabeçalho de Impressão --}}
    <div class="hidden print:block text-center mb-10 border-b-2 border-black pb-4">
        <h1 class="text-3xl font-black ">MecaniCarX</h1>
        <p class="text-sm">Oficina Mecânica Especializada</p>
        <p class="text-xs">Feira de Santana - BA | Tel: (75) 99999-9999</p>
    </div>

    <div class="space-y-6"> 
        {{-- Cabeçalho do Sistema (Fora de cards para melhor contraste) --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2 no-print">
            <div>
                <h2 class="text-2xl font-bold text-gray-800"> Ordem de Serviço #{{ $service_order->number }} </h2>
                <p class="text-sm text-gray-500"> Criada em {{ $service_order->created_at->format('d/m/Y H:i') }} </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2"> 
                <a href="{{ route('service-orders.index') }}" class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition"> Voltar </a> 
                <a href="{{ route('service-orders.edit', $service_order->id) }}" class="px-3 py-1.5 bg-yellow-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-600 shadow-sm transition"> Editar </a> 
                
                <button onclick="window.print()" class="px-3 py-1.5 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-black shadow-sm transition flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Imprimir
                </button>

                <a href="{{ route('service-orders.pdf', $service_order) }}" target="_blank" class="px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 shadow-sm transition flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    PDF
                </a>

                @php
                    $telefoneLimpo = preg_replace('/[^0-9]/', '', $service_order->customer->phone);
                    $mensagem = "Olá, " . $service_order->customer->name . "! A sua Ordem de Serviço #" . $service_order->number . " foi atualizada.";
                    $urlWhatsapp = "https://wa.me/55" . $telefoneLimpo . "?text=" . urlencode($mensagem);
                @endphp

                <a href="{{ $urlWhatsapp }}" target="_blank" class="px-3 py-1.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 shadow-sm transition flex items-center gap-1.5">
                    {{-- Ícone simples de mensagem/whatsapp --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    WhatsApp
                </a>
            </div>
        </div>

        {{-- Daqui para baixo seguem os seus cards de Informações Gerais, Detalhamento, etc --}}
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
            {{-- Rodapé de assinatura que também só aparece no papel --}}
        <div class="hidden print:grid grid-cols-2 gap-10 mt-20">
            <div class="border-t border-black text-center pt-2 text-xs text-gray-600">
                Assinatura do Cliente
            </div>
            <div class="border-t border-black text-center pt-2 text-xs text-gray-600">
                Responsável Técnico
            </div>
        </div>
    </div>
</x-app-layout>