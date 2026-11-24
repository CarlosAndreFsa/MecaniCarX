<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Contas a Receber</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #111827; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #d1d5db; padding: 7px 5px; text-align: left; }
        th { font-size: 11px; text-transform: uppercase; }
        .right { text-align: right; }
        @media print {
            button { display: none; }
        }
        @if($format === 'thermal')
            @media print { @page { size: 80mm auto; margin: 3mm; } body { font-size: 10px; margin: 0; } table { font-size: 9px; } th:nth-child(3), td:nth-child(3), th:nth-child(4), td:nth-child(4) { display: none; } }
        @endif
    </style>
</head>
<body>
    <button onclick="window.print()">Imprimir</button>
    <h2>Contas a Receber</h2>
    <p>Relatório gerado em {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Conta</th>
                <th>Cliente</th>
                <th>OS</th>
                <th>Vencimento</th>
                <th class="right">Valor</th>
                <th class="right">Recebido</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                @foreach($account->installments as $installment)
                    <tr>
                        <td>#{{ $account->id }}</td>
                        <td>{{ $account->customer->name }}</td>
                        <td>{{ $account->serviceOrder?->number ?? '-' }}</td>
                        <td>{{ $installment->due_date->format('d/m/Y') }}</td>
                        <td class="right">R$ {{ number_format($installment->amount, 2, ',', '.') }}</td>
                        <td class="right">R$ {{ number_format($installment->received_amount, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
