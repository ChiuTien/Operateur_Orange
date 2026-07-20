<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Veuillez taper vos identifiants : </h2>
    <!-- Affichage du message d'erreur Flashdata -->
    <?php if (session()->getFlashdata('error')): ?>
        <div style="color: red; margin-bottom: 15px; font-weight: bold;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <form action="login/auth" method="post">
        <label for="numero">Taper votre numero</label><br>
        <input type="text" name="numero" required><br>
        <small>0334621231</small><br>
        <!-- <label for="mdp">Taper votre mot de passe</label><br>
        <input type="text" name="mdp" required><br>
        <small>123456</small><br> -->
        <button type="submit"> Connexion </button>
    </form>
</body>
</html>