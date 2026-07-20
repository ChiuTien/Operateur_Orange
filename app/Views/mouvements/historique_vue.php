<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des mouvements</title>
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
            max-width: 1100px;
            margin: 0 auto;
            line-height: 1.5;
        }

        h2 {
            font-weight: 500;
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
            color: #0b2b4a;
            letter-spacing: -0.3px;
        }

        .sous-titre {
            margin-bottom: 1.8rem;
            color: #475569;
            font-size: 1rem;
            border-left: 4px solid #3b82f6;
            padding-left: 1rem;
            background: #eef2f6;
            border-radius: 0 8px 8px 0;
            display: inline-block;
            padding: 0.4rem 1.2rem;
        }

        .sous-titre strong {
            color: #0b2b4a;
            font-weight: 600;
        }

        /* ----- BOUTON RETOUR ----- */
        .btn-retour {
            display: inline-block;
            background: white;
            border: 1px solid #d1d9e6;
            padding: 0.5rem 1.4rem;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #1e293b;
            text-decoration: none;
            transition: 0.2s;
            margin-bottom: 2rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            cursor: pointer;
        }

        .btn-retour:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.03);
        }

        .btn-retour:active {
            transform: translateY(1px);
        }

        /* ----- TABLEAU ----- */
        .table-wrapper {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            border: 1px solid #e9edf2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        thead {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            text-align: left;
            padding: 1rem 1.2rem;
            font-weight: 600;
            color: #334155;
            letter-spacing: 0.3px;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        td {
            padding: 0.9rem 1.2rem;
            border-bottom: 1px solid #f0f3f7;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #fafcff;
        }

        /* Style des types d'opération */
        .badge {
            display: inline-block;
            padding: 0.2rem 0.9rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.2px;
            background: #eef2f6;
            color: #1e293b;
        }

        .badge-depot {
            background: #dbeafe;
            color: #1e4b8a;
        }

        .badge-retrait {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-transfert {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-inconnu {
            background: #f1f5f9;
            color: #475569;
        }

        /* Montant */
        .montant {
            font-weight: 600;
            color: #0b2b4a;
        }

        /* Message "aucune transaction" */
        .aucune {
            text-align: center;
            padding: 2.5rem 1rem !important;
            color: #64748b;
            font-style: italic;
            background: #fafcff;
        }

        /* ----- RESPONSIVE ----- */
        @media (max-width: 600px) {
            body {
                padding: 1rem;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tr {
                margin-bottom: 1rem;
                border: 1px solid #e9edf2;
                border-radius: 12px;
                background: white;
                padding: 0.5rem 0;
            }

            td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 1rem;
                border-bottom: 1px solid #f1f5f9;
            }

            td:last-child {
                border-bottom: none;
            }

            td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #475569;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }

            .aucune {
                display: block !important;
                text-align: center;
            }

            .badge {
                font-size: 0.75rem;
                padding: 0.1rem 0.8rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <h2> Historique de vos transactions</h2>
    <div class="sous-titre">
        Filtre actuellement appliqué : <strong><?= ucfirst($filtreActuel) ?></strong>
    </div>

    <!-- Bouton Retour à l'accueil -->
    <a href="<?= base_url('accueil') ?>" class="btn-retour">
        ⬅ Retour à l'accueil
    </a>

    <!-- Tableau des résultats -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type d'opération</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mouvements) && is_array($mouvements)): ?>
                    <?php foreach ($mouvements as $mouvement): ?>
                        <tr>
                            <td data-label="ID"><?= $mouvement['id'] ?></td>
                            <td data-label="Type d'opération">
                                <?php
                                    $type = 'Inconnu';
                                    $badgeClass = 'badge-inconnu';
                                    if ($mouvement['idOperation'] == 1) {
                                        $type = 'Dépôt';
                                        $badgeClass = 'badge-depot';
                                    } elseif ($mouvement['idOperation'] == 2) {
                                        $type = 'Retrait';
                                        $badgeClass = 'badge-retrait';
                                    } elseif ($mouvement['idOperation'] == 3) {
                                        $type = 'Transfert';
                                        $badgeClass = 'badge-transfert';
                                    }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= $type ?></span>
                            </td>
                            <td data-label="Montant" class="montant">
                                <?= number_format($mouvement['argent'], 2, ',', ' ') ?> MGA
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="aucune" data-label="Aucune transaction">
                            Aucune transaction trouvée pour ce filtre.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>