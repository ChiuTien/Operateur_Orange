<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du rôle</title>
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
        .role-card {
            background: white;
            max-width: 480px;
            width: 100%;
            padding: 2.8rem 2rem 2.5rem;
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid #e9edf2;
            text-align: center;
            transition: 0.2s;
        }

        .role-card:hover {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.08);
        }

        h2 {
            font-weight: 500;
            font-size: 1.6rem;
            color: #0b2b4a;
            margin-bottom: 0.5rem;
            letter-spacing: -0.3px;
        }

        .sous-titre {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
            border-left: 3px solid #3b82f6;
            padding-left: 0.8rem;
            display: inline-block;
        }

        /* ----- BOUTONS ----- */
        .role-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-role {
            display: block;
            padding: 1rem 1.5rem;
            border-radius: 14px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: 0.2s;
            text-align: center;
            border: 2px solid transparent;
            letter-spacing: 0.3px;
        }

        .btn-client {
            background: #0b2b4a;
            color: white;
            border-color: #0b2b4a;
        }

        .btn-client:hover {
            background: #1a3f62;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(11, 43, 74, 0.25);
            border-color: #1a3f62;
        }

        .btn-operator {
            background: #0b2b4a;
            color: white;
            border-color: #0b2b4a;
        }

        .btn-operator:hover {
            background: #1a3f62;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(11, 43, 74, 0.25);
            border-color: #1a3f62;
        }

        .btn-role:active {
            transform: translateY(0px);
        }

        /* ----- SEPARATEUR ----- */
        .separator {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0.5rem 0 0.8rem;
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .separator::before,
        .separator::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* ----- RESPONSIVE ----- */
        @media (max-width: 480px) {
            .role-card {
                padding: 2rem 1.2rem 1.8rem;
            }

            h2 {
                font-size: 1.4rem;
            }

            .btn-role {
                font-size: 1rem;
                padding: 0.9rem 1.2rem;
            }
        }
    </style>
</head>
<body>

    <div class="role-card">
        <h2>Choisissez votre rôle</h2>
        <div class="sous-titre">Voulez-vous vous connecter en tant que :</div>

        <div class="role-buttons">
            <a href="/client" class="btn-role btn-client">Client</a>
            
            <div class="separator">ou</div>
            
            <a href="/operator" class="btn-role btn-operator">Opérateur</a>
        </div>
    </div>

</body>
</html>