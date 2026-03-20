<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #ea580c;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-collapse: collapse;
        }

        .logo {
            width: 70px;
            height: 70px;
        }

        .company-info {
            padding-left: 15px;
            vertical-align: middle;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin: 0;
            text-transform: uppercase;
        }

        .os-badge {
            text-align: right;
            vertical-align: middle;
        }

        .os-label {
            color: #ea580c;
            font-weight: bold;
            font-size: 12px;
            display: block;
        }

        .os-number {
            font-size: 24px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table th {
            background-color: #f3f4f6;
            color: #374151;
            font-size: 9px;
            text-transform: uppercase;
            padding: 6px 10px;
            border: 1px solid #d1d5db;
            text-align: left;
        }

        .table td {
            padding: 8px 10px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }

        .label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }

        .value {
            font-size: 11px;
            font-weight: bold;
            color: #111;
        }

        .footer-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .total-card {
            background-color: #ea580c;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: right;
        }

        .total-text {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .total-amount {
            font-size: 22px;
            font-weight: bold;
            display: block;
        }

        .signatures {
            margin-top: 50px;
            width: 100%;
            border-collapse: collapse;
        }

        .sig-box {
            border-top: 1px solid #000;
            width: 45%;
            text-align: center;
            padding-top: 5px;
            font-size: 9px;
            font-weight: bold;
        }
    </style>
</head>

<body>

   <table class="header-table">
    <tr>
        <td width="80">
            @if(isset($logoBase64) && $logoBase64)
                <img src="{{ $logoBase64 }}" class="logo">
            @else
                {{-- Fallback caso a logo falhe --}}
                <div style="background:#ea580c; color:white; width:70px; height:70px; line-height:70px; text-align:center; font-weight:bold; border-radius:8px; font-size:20px;">MX</div>
            @endif
        </td>
        <td class="company-info">
            <h1 class="company-name">{{ $service_order->company->name ?? 'OFICINA DEMO' }}</h1>
            <div style="font-size: 10px; color: #555;">
                {{-- AJUSTE DO ENDEREÇO: Acessando os campos do objeto --}}
                @if($service_order->company->address)
                    {{ $service_order->company->address->street }}, {{ $service_order->company->address->number }}
                    @if($service_order->company->address->complement) - {{ $service_order->company->address->complement }} @endif
                    <br>
                    {{ $service_order->company->address->district }} - {{ $service_order->company->address->city }}/{{ $service_order->company->address->state }}
                @else
                    Endereço não cadastrado
                @endif
                <br>
                CNPJ: {{ $service_order->company->cnpj ?? '00.000.000/0001-00' }} | Contato: {{ $service_order->company->phone ?? '(75) 99999-9999' }}
            </div>
        </td>
        <td class="os-badge">
            <span class="os-label">ORDEM DE SERVIÇO</span>
            <span class="os-number">#{{ $service_order->number }}</span>
        </td>
    </tr>
</table>

    {{-- CLIENTE E VEÍCULO --}}
    <table class="table">
        <thead>
            <tr>
                <th width="50%">INFORMAÇÕES DO CLIENTE</th>
                <th width="50%">INFORMAÇÕES DO VEÍCULO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span class="label">Nome</span>
                    <span class="value">{{ $service_order->customer->name }}</span>
                    <br><br>
                    <span class="label">Telefone</span>
                    <span class="value">{{ $service_order->customer->phone ?? '---' }}</span>
                </td>
                <td>
                    <span class="label">Modelo / Marca</span>
                    <span class="value">{{ $service_order->vehicle->model }}</span>
                    <br><br>
                    <span class="label">Placa</span>
                    <span class="value"
                        style="background: #eee; padding: 2px 5px; border-radius: 3px;">{{ strtoupper($service_order->vehicle->plate) }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- DATAS E STATUS --}}
    <table class="table">
        <thead>
            <tr>
                <th width="33%">DATA DE ENTRADA</th>
                <th width="33%">PREVISÃO DE SAÍDA</th>
                <th width="33%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="value">{{ \Carbon\Carbon::parse($service_order->entry_date)->format('d/m/Y') }}</td>
                <td class="value">
                    {{ $service_order->delivery_date ? \Carbon\Carbon::parse($service_order->delivery_date)->format('d/m/Y') : '---' }}
                </td>
                <td class="value" style="text-transform: uppercase;">{{ $service_order->status }}</td>
            </tr>
        </tbody>
    </table>

    {{-- DESCRIÇÃO --}}
    <table class="table">
        <thead>
            <tr>
                <th>DESCRIÇÃO DOS SERVIÇOS E DIAGNÓSTICO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height: 100px;">
                    <span class="label">Problema Relatado:</span>
                    <p style="margin-top:5px;">{{ $service_order->customer_description }}</p>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 10px 0;">
                    <span class="label">Parecer Técnico:</span>
                    <p style="margin-top:5px;">
                        {{ $service_order->technical_description ?? 'Diagnóstico em andamento.' }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- FINANCEIRO --}}
    <table class="footer-table">
        <tr>
            <td width="55%" style="vertical-align: bottom;">
                <p style="font-size: 8px; color: #888;">Documento oficial MecaniCarX - Gerado em
                    {{ date('d/m/Y H:i') }}</p>
            </td>
            <td width="45%">
                <div class="total-card">
                    <span class="total-text">Valor Total do Serviço</span>
                    <span class="total-amount">R$ {{ number_format($service_order->total, 2, ',', '.') }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ASSINATURAS --}}
    <table class="signatures">
        <tr>
            <td class="sig-box" style="padding-right: 10%;">ASSINATURA DO CLIENTE</td>
            <td class="sig-box">RESPONSÁVEL TÉCNICO</td>
        </tr>
    </table>

</body>

</html>
