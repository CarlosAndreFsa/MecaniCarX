<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>OS #{{ $service_order->number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; line-height: 1.4; margin: 0; padding: 0; }
        .container { padding: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table th, .table td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        .header-table { border: none; margin-bottom: 30px; }
        .header-table td { border: none; vertical-align: middle; }
        .bg-gray { background-color: #f3f4f6; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        .logo { width: 80px; height: auto; }
        .orange-text { color: #ea580c; font-weight: bold; }
        .total-box { background-color: #ea580c; color: white; padding: 15px; text-align: right; border-radius: 8px; }
        .signature-table { margin-top: 50px; width: 100%; }
        .signature-table td { border: none; border-top: 1px solid #333; text-align: center; width: 45%; padding-top: 5px; font-weight: bold; text-transform: uppercase; font-size: 9px; }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        {{-- CABEÇALHO --}}
        <table class="header-table" width="100%">
            <tr>
                <td width="90">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="logo">
                    @else
                        <div style="background:#ea580c; color:white; width:70px; height:70px; line-height:70px; text-align:center; font-weight:bold; border-radius:8px; font-size:20px;">
                            MX
                        </div>
                    @endif
                </td>
                <td>
                    <h1 style="margin:0; font-size: 20px; text-transform: uppercase;">{{ $service_order->company->name }}</h1>
                    <div style="font-size: 10px; color: #555;">
                        {{-- CORREÇÃO DO ENDEREÇO --}}
                        @if($service_order->company->address)
                            {{ $service_order->company->address->street }}, {{ $service_order->company->address->number }}
                            @if($service_order->company->address->complement) - {{ $service_order->company->address->complement }} @endif
                            <br>
                            {{ $service_order->company->address->district }} - {{ $service_order->company->address->city }}/{{ $service_order->company->address->state }}
                        @endif
                        <br>
                        CNPJ: {{ $service_order->company->cnpj }} | Tel: {{ $service_order->company->phone }}
                    </div>
                </td>
                <td align="right">
                    <span class="orange-text uppercase">Ordem de Serviço</span><br>
                    <span style="font-size: 24px; font-weight: bold;">#{{ $service_order->number }}</span>
                </td>
            </tr>
        </table>

        {{-- INFO CLIENTE / VEÍCULO --}}
        <table class="table">
            <tr>
                <th class="bg-gray" width="50%">Dados do Cliente</th>
                <th class="bg-gray" width="50%">Dados do Veículo</th>
            </tr>
            <tr>
                <td>
                    <strong>Nome:</strong> {{ $service_order->customer->name }}<br>
                    <strong>CPF/CNPJ:</strong> {{ $service_order->customer->cpf_cnpj ?? '---' }}
                </td>
                <td>
                    <strong>Modelo:</strong> {{ $service_order->vehicle->model }}<br>
                    <strong>Placa:</strong> {{ strtoupper($service_order->vehicle->plate) }}
                </td>
            </tr>
        </table>

        {{-- DATAS --}}
        <table class="table">
            <tr>
                <th class="bg-gray">Data de Entrada</th>
                <th class="bg-gray">Previsão de Saída</th>
                <th class="bg-gray">Status Atual</th>
            </tr>
            <tr>
                <td>{{ \Carbon\Carbon::parse($service_order->entry_date)->format('d/m/Y') }}</td>
                <td>{{ $service_order->delivery_date ? \Carbon\Carbon::parse($service_order->delivery_date)->format('d/m/Y') : '---' }}</td>
                <td><strong>{{ strtoupper($service_order->status) }}</strong></td>
            </tr>
        </table>

        {{-- DESCRIÇÕES --}}
        <table class="table">
            <tr><th class="bg-gray">Relato do Cliente</th></tr>
            <tr><td>{{ $service_order->customer_description }}</td></tr>
            <tr><th class="bg-gray">Parecer Técnico</th></tr>
            <tr><td style="height: 80px; vertical-align: top;">{{ $service_order->technical_description ?? 'Diagnóstico em andamento...' }}</td></tr>
        </table>

        {{-- FINANCEIRO --}}
        <table width="100%">
            <tr>
                <td width="60%"></td>
                <td width="40%">
                    <div class="total-box">
                        <span style="font-size: 9px; text-transform: uppercase;">Total da Ordem de Serviço</span><br>
                        <span style="font-size: 22px; font-weight: bold;">R$ {{ number_format($service_order->total, 2, ',', '.') }}</span>
                    </div>
                </td>
            </tr>
        </table>

        {{-- ASSINATURAS --}}
        <table class="signature-table">
            <tr>
                <td>Assinatura do Cliente</td>
                <td width="10%"></td>
                <td>Responsável Técnico</td>
            </tr>
        </table>
    </div>
</body>
</html>