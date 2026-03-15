<!DOCTYPE html>
<html lang="pt-br">
<head>
    {{-- A tag meta deve ser a primeira coisa no head --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>OS #{{ $service_order->number }}</title>
    <style>
        /* DejaVu Sans é essencial para os acentos funcionarem no DomPDF */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .section-title { background: #eee; padding: 5px; font-weight: bold; margin-top: 20px; text-transform: uppercase; }
        .grid { width: 100%; margin-top: 10px; border-collapse: collapse; }
        .col { width: 50%; vertical-align: top; }
        .total-box { margin-top: 30px; text-align: right; font-size: 16px; font-weight: bold; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>MecaniCarX</h1>
        <p>Oficina Especializada | Feira de Santana - BA</p>
    </div>

    <table class="grid">
        <tr>
            <td class="col">
                <strong>Cliente:</strong> {{ $service_order->customer->name }}<br>
                <strong>OS Nº:</strong> {{ $service_order->number }}
            </td>
            <td class="col" style="text-align: right;">
                <strong>Entrada:</strong> {{ \Carbon\Carbon::parse($service_order->entry_date)->format('d/m/Y') }}<br>
                <strong>Status:</strong> {{ ucfirst($service_order->status) }}
            </td>
        </tr>
    </table>

    <div class="section-title">DETALHES DO SERVIÇO</div>
    <p><strong>Título:</strong> {{ $service_order->title }}</p>
    
    <table class="grid">
        <tr>
            <td class="col">
                <strong>Relato do Cliente:</strong><br>
                {{ $service_order->customer_description }}
            </td>
            <td class="col">
                <strong>Parecer Técnico:</strong><br>
                {{ $service_order->technical_description }}
            </td>
        </tr>
    </table>

    <div class="section-title">FINANCEIRO</div>
    <p>Mão de Obra: R$ {{ number_format($service_order->labor_cost, 2, ',', '.') }}</p>
    <p>Peças: R$ {{ number_format($service_order->parts_cost, 2, ',', '.') }}</p>
    
    <div class="total-box">
        TOTAL: R$ {{ number_format($service_order->total, 2, ',', '.') }}
    </div>
</body>
</html>