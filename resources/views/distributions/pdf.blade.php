<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historique des Distributions</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #334155; }
        .header { text-align: center; border-bottom: 3px solid #2563EB; padding-bottom: 16px; margin-bottom: 24px; }
        .header h1 { margin: 0 0 8px; color: #1D4ED8; font-size: 22px; }
        .header p { margin: 0; color: #64748B; }
        .info { margin-bottom: 16px; padding: 12px; background: #EFF6FF; color: #1E3A8A; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #2563EB; color: #fff; }
        th, td { padding: 8px; border: 1px solid #CBD5E1; text-align: left; }
        th { font-size: 10px; text-transform: uppercase; }
        .total-row { background: #DBEAFE; font-weight: bold; }
        .total-row td { border-top: 2px solid #2563EB; }
        .empty { padding: 30px; text-align: center; color: #64748B; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Historique des Distributions</h1>
        <p>Rapport généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
    <div class="info">
        <strong>Nombre de distributions :</strong> {{ $distributions->count() }}<br>
        <strong>Montant total :</strong> {{ number_format($totalMontant, 0) }} FCFA
    </div>
    @if($distributions->isNotEmpty())
        <table>
            <thead>
                <tr><th>Date</th><th>Serveuse</th><th>Boisson</th><th>Quantité</th><th>Prix unitaire</th><th>Montant</th></tr>
            </thead>
            <tbody>
                @foreach($distributions as $distribution)
                    <tr>
                        <td>{{ $distribution->date_distribution?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>{{ $distribution->serveuse?->nom ?? '-' }}</td>
                        <td>{{ $distribution->boisson?->nom ?? '-' }}</td>
                        <td>{{ $distribution->quantite }}</td>
                        <td>{{ number_format($distribution->prix_unitaire, 0) }} FCFA</td>
                        <td>{{ number_format($distribution->prix_unitaire * $distribution->quantite, 0) }} FCFA</td>
                    </tr>
                @endforeach
                <tr class="total-row"><td colspan="5">TOTAL DES MONTANTS</td><td>{{ number_format($totalMontant, 0) }} FCFA</td></tr>
            </tbody>
        </table>
    @else
        <div class="empty">Aucune distribution trouvée</div>
    @endif
</body>
</html>