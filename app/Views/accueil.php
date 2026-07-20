<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
</head>
<body>
    <?php if (session()->getFlashdata('error')):  ?>
        <?= session()->getFlashdata('error') ?>
    <?php endif; ?> 
    
    <h2>C'est un plaisir de vous revoir.</h2>
    
    <!-- Voir solde -->
    <h3><strong>Votre solde actuel :</strong></h3>
    <span><?= $solde ?></span>
    
    <!-- Faire un depot -->
    <h3>Combien allez vous versez ?</h3>
    <form action="/depot" method="post">
        <label for="montant">Le montant à verser</label><br>
        <input type="number" name="montant" placeholder="15000" required><br>
        <button type="submit"> Valider le depot </button>
    </form>

    <!-- Faire un retrait -->
    <h3>Combien allez vous retirez ?</h3>
    <form action="/retrait" method="post">
        <label for="montant">Le montant à retirer</label><br>
        <input type="number" name="montant" placeholder="15000" required><br>
        <button type="submit"> Valider le retrait </button>
    </form>

    <!-- Faire un transfert -->
     <h3>Combien allez vous envoyez ?</h3>
    <form action="/transfert" method="post">
        <label for="montant">Le montant à envoyer</label><br>
        <input type="number" name="montant" placeholder="15000" required><br>
        <label for="beneficiaire">Le numero du beneficiaire</label><br>
        <input type="number" name="beneficiaire" placeholder="0320213411" required><br>
        <button type="submit"> Valider l'envoie </button>
    </form>

    <!-- Voir historique -->
     <h2>Consulter votre historique</h2>
    
    <!-- Formulaire pour choisir le filtre et soumettre -->
    <form action="<?= base_url('historique') ?>" method="post">
        <?= csrf_field() ?>
        <label for="filtre">Filtrer les mouvements par :</label>
        <select name="filtre" id="filtre">
            <option value="tout">Tout afficher</option>
            <option value="depot">Dépôts uniquement</option>
            <option value="retrait">Retraits uniquement</option>
            <option value="transfert">Transferts uniquement</option>
        </select>
        <button type="submit">Voir les résultats</button>
    </form>
</body>
</html>