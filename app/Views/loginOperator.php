<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login operateur</title>
    <style>
        /* ----- RESET & BASE ----- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
            background: #f4f7fc;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            color: #1e293b;
        }

        /* ----- CARD ----- */
        .login-card {
            background: white;
            max-width: 420px;
            width: 100%;
            padding: 2.5rem 2rem 2.2rem;
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid #e9edf2;
            transition: 0.2s;
        }

        .login-card:hover {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.08);
        }

        h2 {
            font-weight: 500;
            font-size: 1.6rem;
            color: #0b2b4a;
            margin-bottom: 0.2rem;
            letter-spacing: -0.3px;
        }

        .sous-titre {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            border-left: 3px solid #3b82f6;
            padding-left: 0.8rem;
        }

        /* ----- FORMULAIRE ----- */
        form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        label {
            font-weight: 500;
            font-size: 0.9rem;
            color: #334155;
        }

        input[type="text"],
        input[type="password"] {
            padding: 0.75rem 1rem;
            border: 1.5px solid #d1d9e6;
            border-radius: 12px;
            font-size: 1rem;
            background: #fafcff;
            transition: 0.2s;
            color: #0b2b4a;
            width: 100%;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: #94a3b8;
        }

        .hint {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 0.2rem;
            display: block;
        }

        /* ----- BOUTON ----- */
        button {
            background: #0b2b4a;
            color: white;
            border: none;
            padding: 0.85rem 1.2rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 0.8rem;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 8px rgba(11, 43, 74, 0.10);
        }

        button:hover {
            background: #1a3f62;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(11, 43, 74, 0.15);
        }

        button:active {
            transform: translateY(0px);
            box-shadow: 0 2px 4px rgba(11, 43, 74, 0.10);
        }

        /* ----- RESPONSIVE ----- */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.2rem 1.8rem;
            }

            h2 {
                font-size: 1.4rem;
            }

            input[type="text"],
            input[type="password"] {
                padding: 0.7rem 0.9rem;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Connexion operateur</h2>
        <div class="sous-titre">Veuillez entrer vos identifiants</div>

        <form action="" method="post">
            <div class="form-group">
                <label for="nom">Entrer votre nom</label>
                <input type="text" id="nom" name="nom" placeholder="Yas" required>
            </div>

            <div class="form-group">
                <label for="mdp">Entrer votre mot de passe</label>
                <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required>
            </div>

            <button type="submit">Connexion</button>
        </form>
    </div>

</body>
</html>