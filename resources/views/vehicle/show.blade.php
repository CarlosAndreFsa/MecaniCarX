<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
                Detalhes do Veículo: <span class="text-orange-600 uppercase">{{ $vehicle->plate }}</span>
            </h2>
            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl text-sm transition-all shadow-lg hover:scale-105">
                Editar Veículo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white">Ficha Técnica e Propriedade</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Informações completas do veículo registrado no sistema.</p>
                </div>
                
                <div class="px-4 py-5 sm:p-0">
                    <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400">Cliente Proprietário</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2 font-medium">{{ $vehicle->customer->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition bg-gray-50/30 dark:bg-gray-800/20">
                            <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400">Placa</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2 uppercase font-bold text-orange-600">{{ $vehicle->plate }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400">Marca / Fabricante</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $vehicle->brand->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition bg-gray-50/30 dark:bg-gray-800/20">
                            <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400">Modelo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $vehicle->model }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400">Ano de Fabricação</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $vehicle->year ?? 'Não Informado' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition bg-gray-50/30 dark:bg-gray-800/20">
                            <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400">Cor</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $vehicle->color ?? 'Não Informada' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400">Data de Cadastro</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $vehicle->created_at ? $vehicle->created_at->format('d/m/Y H:i') : 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <a href="{{ route('vehicles.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition shadow-sm">
                        Voltar para Lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
