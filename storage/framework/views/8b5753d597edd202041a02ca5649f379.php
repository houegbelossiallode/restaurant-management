<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historique des Paiements</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #10B981;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #10B981;
            font-size: 24px;
            margin: 0 0 10px 0;
        }
        
        .header p {
            color: #666;
            margin: 0;
            font-size: 14px;
        }
        
        .info {
            background: #F0FDF4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #10B981;
        }
        
        .info p {
            margin: 5px 0;
            color: #065F46;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        thead {
            background: #10B981;
            color: white;
        }
        
        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 10px;
            border-bottom: 1px solid #E5E7EB;
        }
        
        tbody tr:nth-child(even) {
            background: #F9FAFB;
        }
        
        tbody tr:hover {
            background: #F0FDF4;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .empty {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Historique des Paiements</h1>
        <p>Rapport généré le <?php echo e(now()->format('d/m/Y à H:i')); ?></p>
    </div>
    
    <div class="info">
        <p><strong>Total des paiements :</strong> <?php echo e($paiements->count()); ?></p>
        <p><strong>Montant total :</strong> <?php echo e(number_format($paiements->sum('montant'), 0)); ?> FCFA</p>
    </div>
    
    <?php if($paiements->count() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Serveuse</th>
                    <th>Boisson</th>
                    <th>Quantité</th>
                    <th>Montant (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $paiements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paiement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y H:i') : '-'); ?></td>
                        <td><?php echo e($paiement->serveuse->nom); ?></td>
                        <td><?php echo e($paiement->boisson->nom); ?></td>
                        <td><?php echo e($paiement->quantite); ?></td>
                        <td><?php echo e(number_format($paiement->montant, 0)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty">
            <p>Aucun paiement trouvé</p>
        </div>
    <?php endif; ?>
    
    <div class="footer">
        <p>Système de Gestion de Restaurant - Document généré automatiquement</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views\paiements\pdf.blade.php ENDPATH**/ ?>