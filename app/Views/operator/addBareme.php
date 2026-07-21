<?= $this->include('includes/dashboard') ?>

    <h2>Ajouter une tranche de barème</h2>
    
    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; max-width: 500px; margin-top: 20px;">
        <form action="<?= base_url('bareme/create') ?>" method="post">
            
            <div style="margin-bottom: 15px;">
                <label for="min" style="display: block; margin-bottom: 5px; font-weight: 500;">Montant Minimum</label>
                <input type="number" step="any" name="min" id="min" required style="width: 100%; padding: 10px; border: 1px solid #d1d9e6; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="max" style="display: block; margin-bottom: 5px; font-weight: 500;">Montant Maximum</label>
                <input type="number" step="any" name="max" id="max" required style="width: 100%; padding: 10px; border: 1px solid #d1d9e6; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="frais" style="display: block; margin-bottom: 5px; font-weight: 500;">Frais appliqués</label>
                <input type="number" step="any" name="frais" id="frais" required style="width: 100%; padding: 10px; border: 1px solid #d1d9e6; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="idOperation" style="display: block; margin-bottom: 5px; font-weight: 500;">ID Opération (ex: 1 = Dépôt, 2 = Retrait)</label>
                <input type="number" name="idOperation" id="idOperation" required style="width: 100%; padding: 10px; border: 1px solid #d1d9e6; border-radius: 6px;">
            </div>
            
            <button type="submit" style="padding: 10px 20px; background-color: #22c55e; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                Enregistrer le barème
            </button>
            <a href="<?= base_url('bareme') ?>" style="margin-left: 10px; color: #64748b; text-decoration: none;">Annuler</a>
        </form>
    </div>

</main>
</body>
</html>