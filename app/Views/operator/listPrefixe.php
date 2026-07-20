<?= $this->include('includes/dashboard') ?>

    <h2>Gestion de vos Préfixes</h2>
    
    <!-- Bouton ajouter au début de la zone de liste -->
    <div style="margin: 20px 0;">
        <button type="button" style="padding: 10px 20px; background-color: #22c55e; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
            ➕ Ajouter un préfixe
        </button>
    </div>
 
    <!-- Tableau d'affichage réorganisé -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <thead>
            <tr style="background-color: #0b2b4a; color: white; text-align: left;">
                <th>Séquence Réseau</th>
                <th style="text-align: center; width: 250px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($prefixes) && is_array($prefixes)): ?>
                <?php foreach ($prefixes as $prefixe): ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <!-- Affichage uniquement de la séquence (pas d'ID visible ici) -->
                        <td style="font-size: 1.05rem; font-weight: 500;">
                            <?= esc($prefixe['sequence']) ?>
                        </td>
                        
                        <!-- Boutons d'actions requis en fin de ligne (inactifs pour l'instant) -->
                        <td style="text-align: center;">
                            <button type="button" style="padding: 6px 12px; background-color: #3b82f6; color: white; border: none; border-radius: 6px; cursor: pointer; margin-right: 5px;">
                                Modifier
                            </button>
                            <button type="button" style="padding: 6px 12px; background-color: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="text-align: center; color: #94a3b8; padding: 25px;">
                        Aucun préfixe configuré pour cet opérateur.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</main>
</body>
</html>