<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1f2937; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .muted { color: #6b7280; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { background: #f3f4f6; text-transform: uppercase; font-size: 9px; }
        th, td { border: 1px solid #d1d5db; padding: 6px; text-align: left; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p class="muted">Gerado em {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Conta</th>
                <th>Cliente</th>
                <th>OS</th>
                <th>Descrição</th>
                <th>Vencimento</th>
                <th class="right">Valor</th>
                <th class="right">Recebido</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                @foreach($account->installments as $installment)
                    <tr>
                        <td>#{{ $account->id }}</td>
                        <td>{{ $account->customer->name }}</td>
                        <td>{{ $account->serviceOrder?->number ?? '-' }}</td>
                        <td>{{ $account->description }}</td>
                        <td>{{ $installment->due_date->format('d/m/Y') }}</td>
                        <td class="right">R$ {{ number_format($installment->amount, 2, ',', '.') }}</td>
                        <td class="right">R$ {{ number_format($installment->received_amount, 2, ',', '.') }}</td>
                        <td>{{ $installment->status }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
