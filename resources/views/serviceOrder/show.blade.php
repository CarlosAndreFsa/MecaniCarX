@php
    // 1. Lógica do WhatsApp (deve vir antes de tudo)
    $telefoneLimpo = preg_replace('/[^0-9]/', '', $service_order->customer->phone ?? '');
    $mensagem = "Olá, " . ($service_order->customer->name ?? 'Cliente') . "! A sua Ordem de Serviço #" . $service_order->number . " foi atualizada no MecaniCarX.";
    $urlWhatsapp = "https://wa.me/55" . $telefoneLimpo . "?text=" . urlencode($mensagem);

    // 2. Cores de Status
    $statusClasses = [
        'open' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
        'in_progress' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400',
        'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
        'canceled' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400',
    ];
    $statusLabels = [
        'open' => 'Aberta',
        'in_progress' => 'Em andamento',
        'completed' => 'Concluída',
        'canceled' => 'Cancelada'
    ];
@endphp

<x-app-layout>
    {{-- Cabeçalho de Impressão (Só aparece no papel) --}}
    <div class="hidden print:block text-center mb-10 border-b-2 border-black pb-4">
        <h1 class="text-3xl font-black text-black uppercase">MecaniCarX</h1>
        <p class="text-sm text-black">Oficina Mecânica Especializada</p>
        <p class="text-xs text-black italic">Feira de Santana - BA | Comprovante de Ordem de Serviço</p>
    </div>

    <div class="pt-6 pb-12 w-full">
        <div class="px-4 md:px-8 space-y-8">
            
            {{-- CABEÇALHO DE AÇÕES (Botões Alinhados) --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 no-print border-b border-gray-200 dark:border-gray-700 pb-6">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight leading-none"> 
                        OS <span class="text-orange-600">#{{ $service_order->number }}</span> 
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium"> 
                        Registrada em {{ $service_order->created_at->format('d/m/Y H:i') }} 
                    </p>
                </div>
                
                <div class="flex flex-wrap items-center gap-2"> 
                    {{-- Voltar --}}
                    <a href="{{ route('service-orders.index') }}" 
                       class="h-10 px-4 flex items-center justify-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-xs font-black text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition uppercase tracking-wider shadow-sm">
                        Voltar
                    </a>

                    {{-- Editar --}}
                    <a href="{{ route('service-orders.edit', $service_order->id) }}" 
                       class="h-10 px-4 flex items-center justify-center bg-yellow-500 text-white text-xs font-black rounded-xl hover:bg-yellow-600 transition shadow-md shadow-yellow-500/20 uppercase tracking-wider">
                        Editar
                    </a>

                    {{-- Imprimir --}}
                    {{-- Botão Imprimir Profissional --}}
<a href="{{ route('service-orders.print', $service_order) }}" 
   target="_blank" 
   class="h-10 px-4 flex items-center justify-center bg-slate-700 dark:bg-slate-600 text-white text-xs font-black rounded-xl hover:bg-slate-800 transition shadow-md uppercase flex gap-2 tracking-wider">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
    </svg>
    Imprimir
</a>

                    {{-- PDF --}}
                    <a href="{{ route('service-orders.pdf', $service_order) }}" target="_blank" 
                       class="h-10 px-4 flex items-center justify-center bg-red-600 text-white text-xs font-black rounded-xl hover:bg-red-700 transition shadow-md shadow-red-600/20 uppercase flex gap-2 tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF
                    </a>

                    {{-- WhatsApp --}}
                    <a href="{{ $urlWhatsapp }}" target="_blank" 
                       class="h-10 px-4 flex items-center justify-center bg-green-600 text-white text-xs font-black rounded-xl hover:bg-green-700 transition shadow-md shadow-green-600/20 uppercase flex gap-2 tracking-wider">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.29-4.131c1.53.914 3.041 1.362 4.586 1.363h.005c5.42 0 9.834-4.414 9.836-9.835 0-2.628-1.022-5.1-2.878-6.957-1.856-1.857-4.329-2.879-6.957-2.879-5.42 0-9.835 4.415-9.837 9.836-.001 1.77.475 3.42 1.378 4.786l-.887 3.243 3.325-.872zm11.367-5.068c-.266-.134-1.571-.775-1.815-.864-.243-.088-.421-.133-.598.134-.177.266-.685.864-.841 1.04-.155.178-.311.2-.577.067-.266-.134-1.121-.414-2.136-1.319-.79-.705-1.323-1.575-1.478-1.841-.155-.266-.017-.41.117-.544.12-.12.266-.311.4-.466.133-.155.177-.266.266-.443.089-.178.044-.333-.022-.466-.067-.133-.598-1.44-.82-1.972-.216-.52-.439-.448-.598-.456-.155-.008-.332-.01-.51-.01-.177 0-.465.067-.708.333-.243.266-.93.908-.93 2.215 0 1.307.952 2.57 1.085 2.747.133.177 1.874 2.861 4.54 4.01.635.273 1.13.436 1.516.559.638.203 1.218.174 1.677.106.512-.077 1.571-.642 1.793-1.263.221-.621.221-1.153.155-1.263-.066-.11-.243-.177-.51-.311z"/></svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            {{-- GRID DE CONTEÚDO --}}
            <div class="grid grid-cols-1 gap-6">
                
                {{-- CARD 1: INFORMAÇÕES GERAIS --}} 
                <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl shadow-sm p-6 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-1 h-full bg-orange-600"></div>
                    <h3 class="text-lg font-black text-gray-700 dark:text-gray-200 mb-6 flex items-center gap-2 uppercase tracking-tighter"> 
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Informações da Ordem 
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8"> 
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Cliente</p>
                            <p class="text-base font-bold text-gray-800 dark:text-gray-200 truncate"> {{ $service_order->customer->name }} </p>
                        </div> 

                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Data Entrada</p>
                            <p class="text-base text-gray-800 dark:text-gray-300 font-bold">
                                {{ \Carbon\Carbon::parse($service_order->entry_date)->format('d/m/Y') }} 
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Data Saída</p>
                            <p class="text-base text-gray-800 dark:text-gray-300 font-bold">
                                {{ $service_order->delivery_date ? \Carbon\Carbon::parse($service_order->delivery_date)->format('d/m/Y') : '---' }} 
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status OS</p> 
                            <span class="px-3 py-1 text-[10px] font-black rounded-lg uppercase inline-block {{ $statusClasses[$service_order->status] ?? 'bg-gray-100' }}"> 
                                {{ $statusLabels[$service_order->status] ?? $service_order->status }}
                            </span>
                        </div> 
                    </div>
                </div> 

                {{-- CARD 2: TÍTULO E DETALHAMENTO --}} 
                <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl shadow-sm p-6 overflow-hidden">
                    <div class="mb-8">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Título do Serviço</p>
                        <p class="text-2xl text-gray-800 dark:text-white font-black leading-tight"> {{ $service_order->title }} </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t dark:border-gray-700">
                        {{-- Relato do Cliente --}}
                        <div class="bg-gray-50 dark:bg-gray-900/40 p-5 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 mb-3 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-gray-400"></span> Relato do Cliente
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed italic">
                                "{{ $service_order->customer_description ?? 'Nenhuma descrição fornecida.' }}"
                            </p>
                        </div>

                        {{-- Parecer Técnico --}}
                        <div class="bg-orange-50 dark:bg-orange-900/10 p-5 rounded-2xl border border-orange-100 dark:border-orange-900/30">
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-500 mb-3 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-orange-600"></span> Parecer Técnico
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed font-medium">
                                {{ $service_order->technical_description ?? 'Diagnóstico técnico pendente.' }}
                            </p>
                        </div>
                    </div>
                </div> 

                {{-- CARD 3: FINANCEIRO --}} 
                <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl shadow-sm p-6 border-l-4 border-l-orange-600">
                    <h3 class="text-lg font-black text-gray-700 dark:text-gray-200 mb-6 uppercase tracking-tighter">Resumo Financeiro</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border dark:border-gray-700">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Mão de Obra</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-gray-200 font-mono"> R$ {{ number_format($service_order->labor_cost, 2, ',', '.') }} </p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border dark:border-gray-700">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Peças</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-gray-200 font-mono"> R$ {{ number_format($service_order->parts_cost, 2, ',', '.') }} </p>
                        </div>
                        <div class="p-4 bg-orange-600 rounded-xl shadow-lg shadow-orange-600/30">
                            <p class="text-[10px] font-black text-orange-100 uppercase tracking-widest mb-1">Total Geral da OS</p>
                            <p class="text-3xl font-black text-white font-mono leading-none"> R$ {{ number_format($service_order->total, 2, ',', '.') }} </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rodapé de Assinatura (Apenas Papel) --}}
            <div class="hidden print:grid grid-cols-2 gap-20 mt-32 px-10">
                <div class="border-t border-black text-center pt-3 text-xs font-black text-black uppercase tracking-widest">
                    Assinatura do Cliente
                </div>
                <div class="border-t border-black text-center pt-3 text-xs font-black text-black uppercase tracking-widest">
                    Responsável MecaniCarX
                </div>
            </div>
        </div>
    </div>
</x-app-layout>