<?= $this->include('includes/dashboard') ?>

    <h2>Ajouter un nouveau préfixe</h2>
    
    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; max-width: 500px; margin-top: 20px;">
        <form action="<?= base_url('prefixe/create') ?>" method="post">
            <div style="margin-bottom: 15px;">
                <label for="sequence" style="display: block; margin-bottom: 5px; font-weight: 500;">Séquence du préfixe (ex: 034)</label>
                <input type="text" name="sequence" id="sequence" required style="width: 100%; padding: 10px; border: 1px solid #d1d9e6; border-radius: 6px;">
            </div>
            
            <button type="submit" style="padding: 10px 20px; background-color: #22c55e; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                Enregistrer le préfixe
            </button>
            <a href="<?= base_url('prefixe') ?>" style="margin-left: 10px; color: #64748b; text-decoration: none;">Annuler</a>
        </form>
    </div>

</main>
</body>
</html>