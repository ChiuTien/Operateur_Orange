<?= $this->include('includes/dashboard') ?>

    <h2>Gestion de vos Barèmes</h2>
    
    <div style="margin: 20px 0;">
        <a href="<?= base_url('bareme/ajouter') ?>" style="display: inline-block; text-decoration: none; padding: 10px 20px; background-color: #22c55e; color: white; border-radius: 8px; font-weight: bold;">
            ➕ Ajouter une tranche
        </a>
    </div>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <thead>
            <tr style="background-color: #0b2b4a; color: white; text-align: left;">
                <th>Montant Min</th>
                <th>Montant Max</th>
                <th>Frais</th>
                <th>ID Opération</th>
                <th style="text-align: center; width: 250px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($baremes) && is_array($baremes)): ?>
                <?php foreach ($baremes as $b): ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td><?= number_format($b['min'], 0, ',', ' ') ?> Ar</td>
                        <td><?= number_format($b['max'], 0, ',', ' ') ?> Ar</td>
                        <td><?= number_format($b['frais'], 0, ',', ' ') ?> Ar</td>
                        <td><?= esc($b['idOperation']) ?></td>
                        <td style="text-align: center;">
                            <a href="<?= base_url('bareme/edit/' . $b['id']) ?>" style="display: inline-block; text-decoration: none; padding: 6px 12px; background-color: #3b82f6; color: white; border-radius: 6px; margin-right: 5px;">
                                Modifier
                            </a>
                            <a href="<?= base_url('bareme/delete/' . $b['id']) ?>" style="display: inline-block; text-decoration: none; padding: 6px 12px; background-color: #ef4444; color: white; border-radius: 6px;">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 25px;">
                        Aucun barème configuré pour cet opérateur.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</main>
</body>
</html>