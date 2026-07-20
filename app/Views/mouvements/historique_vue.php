<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des mouvements</title>
</head>
<body>
    <h2>Historique de vos transactions</h2>
    <p>Filtre actuellement appliqué : <strong><?= ucfirst($filtreActuel) ?></strong></p>

    <!-- Bouton Retour à l'accueil -->
    <a href="<?= base_url('accueil') ?>">
        <button type="button" style="margin-bottom: 20px; cursor: pointer;">⬅️ Retour à l'accueil</button>
    </a>

    <!-- Tableau des résultats -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Type d'Opération</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($mouvements) && is_array($mouvements)): ?>
                <?php foreach ($mouvements as $mouvement): ?>
                    <tr>
                        <td><?= $mouvement['id'] ?></td>
                        <td>
                            <?php 
                                // On affiche un texte propre selon l'idOperation en base
                                if ($mouvement['idOperation'] == 1) echo "Dépôt";
                                elseif ($mouvement['idOperation'] == 2) echo "Retrait";
                                elseif ($mouvement['idOperation'] == 3) echo "Transfert";
                                else echo "Inconnu";
                            ?>
                        </td>
                        <td style="font-weight: bold;">
                            <?= number_format($mouvement['argent'], 2, ',', ' ') ?> MGA
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center; color: gray;">Aucune transaction trouvée pour ce filtre.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>