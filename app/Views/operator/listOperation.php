<?= $this->include('includes/dashboard') ?>

    <h2>Gestion de l'Opérateur</h2>
    
    <!-- Bouton ajouter au début de la zone de liste -->
    <div style="margin: 20px 0;">
        <button type="button" style="padding: 10px 20px; background-color: #22c55e; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
            ➕ Ajouter
        </button>
    </div>

    <!-- Tableau d'affichage de la liste -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <thead>
            <tr style="background-color: #0b2b4a; color: white; text-align: left;">
                <!-- Les entêtes s'adapteront selon ce que tu envoies (Exemple générique) -->
                <th>Donnée / Valeur</th>
                <th>Détails complémentaires</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($donneesListe) && is_array($donneesListe)): ?>
                <?php foreach ($donneesListe as $ligne): ?>
                    <tr>
                        <!-- 
                          On n'affiche JAMAIS $ligne['id'] ici !
                          On affiche uniquement les données internes.
                        -->
                        <td>
                            <?= isset($ligne['sequence']) ? $ligne['sequence'] : (isset($ligne['min']) ? $ligne['min'] . ' - ' . $ligne['max'] : 'N/A') ?>
                        </td>
                        <td>
                            <?= isset($ligne['frais']) ? 'Frais : ' . $ligne['frais'] . ' MGA' : 'Préfixe opérateur' ?>
                        </td>
                        
                        <!-- Boutons d'actions en fin de chaque ligne -->
                        <td style="text-align: center; gap: 10px;">
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
                    <td colspan="3" style="text-align: center; color: #94a3b8; padding: 20px;">Aucun enregistrement trouvé. Cliquez sur "Ajouter" pour commencer.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</main> <!-- Fermeture de la balise principale ouverte dans le dashboard -->
</body>
</html>