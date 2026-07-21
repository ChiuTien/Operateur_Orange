<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
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
            padding: 2rem 1.5rem;
            color: #1e293b;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ----- ERREUR ----- */
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 1.8rem;
            border-left: 4px solid #dc2626;
        }

        /* ----- TITRES ----- */
        h2 {
            font-weight: 500;
            font-size: 1.8rem;
            color: #0b2b4a;
            margin-bottom: 0.5rem;
            letter-spacing: -0.3px;
        }

        h2:not(:first-of-type) {
            margin-top: 2.5rem;
            border-top: 2px solid #e9edf2;
            padding-top: 2rem;
        }

        h3 {
            font-weight: 500;
            font-size: 1.2rem;
            color: #1e293b;
            margin-top: 1.8rem;
            margin-bottom: 0.5rem;
        }

        /* ----- SOLDE ----- */
        .solde-box {
            background: white;
            padding: 1.2rem 1.8rem;
            border-radius: 16px;
            border: 1px solid #e9edf2;
            display: inline-block;
            margin-bottom: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .solde-box .montant {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0b2b4a;
            letter-spacing: 0.5px;
        }

        .solde-box .devise {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 400;
            margin-left: 0.3rem;
        }

        /* ----- FORMULAIRES ----- */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem 1.8rem 1.8rem;
            margin: 1rem 0 1.5rem;
            border: 1px solid #e9edf2;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            transition: 0.2s;
        }

        .form-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        }

        .form-card label {
            display: block;
            font-weight: 500;
            font-size: 0.9rem;
            color: #334155;
            margin-bottom: 0.3rem;
        }

        .form-card input[type="number"],
        .form-card select {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid #d1d9e6;
            border-radius: 12px;
            font-size: 1rem;
            background: #fafcff;
            transition: 0.2s;
            color: #0b2b4a;
            margin-bottom: 0.8rem;
        }

        .form-card input[type="number"]:focus,
        .form-card select:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
        }

        .form-card input[type="number"]::placeholder {
            color: #94a3b8;
        }

        .form-card select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 1rem;
            cursor: pointer;
        }

        .form-card select option {
            padding: 0.5rem;
        }

        /* ----- BOUTONS ----- */
        .btn {
            background: #0b2b4a;
            color: white;
            border: none;
            padding: 0.7rem 1.8rem;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            letter-spacing: 0.2px;
            box-shadow: 0 2px 8px rgba(11, 43, 74, 0.08);
            display: inline-block;
        }

        .btn:hover {
            background: #1a3f62;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(11, 43, 74, 0.12);
        }

        .btn:active {
            transform: translateY(0px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #1e293b;
            box-shadow: none;
            border: 1px solid #d1d9e6;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* ----- HISTORIQUE (section spécifique) ----- */
        .historique-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem 1.8rem 1.8rem;
            border: 1px solid #e9edf2;
            margin-top: 0.5rem;
        }

        .historique-section .form-row {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 1rem;
        }

        .historique-section .form-row .field {
            flex: 1 1 200px;
        }

        .historique-section .form-row .field label {
            display: block;
            font-weight: 500;
            font-size: 0.9rem;
            color: #334155;
            margin-bottom: 0.3rem;
        }

        .historique-section .form-row .field select {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid #d1d9e6;
            border-radius: 12px;
            font-size: 1rem;
            background: #fafcff;
            transition: 0.2s;
            color: #0b2b4a;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 1rem;
            cursor: pointer;
        }

        .historique-section .form-row .field select:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
        }

        /* ----- RESPONSIVE ----- */
        @media (max-width: 600px) {
            body {
                padding: 1rem;
            }

            .form-card {
                padding: 1.2rem 1rem 1.4rem;
            }

            .historique-section {
                padding: 1.2rem 1rem 1.4rem;
            }

            .historique-section .form-row {
                flex-direction: column;
                gap: 0.8rem;
            }

            .historique-section .form-row .field {
                flex: 1 1 auto;
                width: 100%;
            }

            .solde-box .montant {
                font-size: 1.4rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 400px) {
            .solde-box {
                padding: 1rem 1.2rem;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- Message d'erreur Flashdata -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <h2>C'est un plaisir de vous revoir.</h2>

    <!-- Voir solde -->
    <h3>Votre solde actuel :</h3>
    <div class="solde-box">
        <span class="montant"><?= $solde ?></span> <span class="devise">MGA</span>
    </div>

    <!-- Faire un dépôt -->
    <h3>Combien allez-vous verser ?</h3>
    <div class="form-card">
        <form action="/depot" method="post">
            <label for="montant_depot">Le montant à verser</label>
            <input type="number" id="montant_depot" name="montant" placeholder="15000" required>
            <button type="submit" class="btn">Valider le dépôt</button>
        </form>
    </div>

    <!-- Faire un retrait -->
    <h3>Combien allez-vous retirer ?</h3>
    <div class="form-card">
        <form action="/retrait" method="post">
            <label for="montant_retrait">Le montant à retirer</label>
            <input type="number" id="montant_retrait" name="montant" placeholder="15000" required>
            <button type="submit" class="btn">Valider le retrait</button>
        </form>
    </div>

    <!-- Faire un transfert -->
    <!-- Faire un transfert (Envoi individuel ou multiple avec montants personnalisés) -->
    <!-- 
        un montant pour un numéro puis un autre montant pour tel numéro et ainsi de suite 
        et vérification si le numero du beneficiaire est du même operateur que le client connecté
    -->
    <h3>Effectuer un ou plusieurs transferts</h3>
    <div class="form-card">
        <form action="/transfert" method="post">
            
            <div id="transferts-container">
                <!-- Ligne de transfert par défaut -->
                <div class="transfert-row" style="display: flex; gap: 10px; margin-bottom: 12px; align-items: center;">
                    <div style="flex: 1;">
                        <label>Numéro bénéficiaire</label>
                        <input type="text" name="beneficiaires[]" placeholder="0320213411" required style="margin-bottom: 0;">
                    </div>
                    <div style="flex: 1;">
                        <label>Montant (Ar)</label>
                        <input type="number" name="montants[]" placeholder="15000" required style="margin-bottom: 0;">
                    </div>
                </div>
            </div>

            <!-- Bouton pour ajouter une autre ligne -->
            <button type="button" id="add-transfert-btn" class="btn btn-secondary" style="margin-bottom: 1.2rem; font-size: 0.85rem; padding: 0.5rem 1rem;">
                ➕ Ajouter un autre destinataire
            </button>

            <div>
                <button type="submit" class="btn">Valider l'envoi</button>
            </div>
        </form>
    </div>

    <!-- Script simple pour dupliquer les champs -->
    <script>
        document.getElementById('add-transfert-btn').addEventListener('click', function() {
            const container = document.getElementById('transferts-container');
            const newRow = document.createElement('div');
            newRow.className = 'transfert-row';
            newRow.style = 'display: flex; gap: 10px; margin-bottom: 12px; align-items: center;';
            
            newRow.innerHTML = `
                <div style="flex: 1;">
                    <input type="text" name="beneficiaires[]" placeholder="0320213422" required style="margin-bottom: 0;">
                </div>
                <div style="flex: 1;">
                    <input type="number" name="montants[]" placeholder="10000" required style="margin-bottom: 0;">
                </div>
                <button type="button" class="remove-row" style="background:#ef4444; color:white; border:none; padding:8px 12px; border-radius:8px; cursor:pointer;">❌</button>
            `;

            newRow.querySelector('.remove-row').addEventListener('click', function() {
                newRow.remove();
            });

            container.appendChild(newRow);
        });
    </script>

    <!-- Voir historique -->
    <h2>Consulter votre historique</h2>
    <div class="historique-section">
        <form action="/historique" method="post">
            <?= csrf_field() ?>
            <div class="form-row">
                <div class="field">
                    <label for="filtre">Filtrer les mouvements par :</label>
                    <select name="filtre" id="filtre">
                        <option value="tout">Tout afficher</option>
                        <option value="depot">Dépôts uniquement</option>
                        <option value="retrait">Retraits uniquement</option>
                        <option value="transfert">Transferts uniquement</option>
                    </select>
                </div>
                <div class="field">
                    <button type="submit" class="btn">Voir les résultats</button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>