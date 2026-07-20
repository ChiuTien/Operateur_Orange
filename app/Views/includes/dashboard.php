<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
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
        }

        /* ----- SIDEBAR ----- */
        .sidebar {
            width: 280px;
            background: #0b2b4a;
            min-height: 100vh;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            height: 100vh;
        }

        /* ----- TITRE ----- */
        .sidebar-title {
            padding: 0 1.8rem 1.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 1.5rem;
        }

        .sidebar-title h2 {
            color: white;
            font-weight: 400;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }

        .sidebar-title h2 span {
            font-weight: 700;
            color: #93c5fd;
        }

        /* ----- MENU ----- */
        .sidebar-menu {
            list-style: none;
            padding: 0 1rem;
            flex: 1;
        }

        .sidebar-menu li {
            margin-bottom: 0.3rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.2rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: 0.2s;
            border: 1px solid transparent;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            border-color: rgba(255, 255, 255, 0.08);
        }

        /* ----- ICÔNE TEXTE (sans image) ----- */
        .menu-icon {
            display: inline-block;
            width: 28px;
            text-align: center;
            margin-right: 12px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
        }

        .sidebar-menu a:hover .menu-icon {
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar-menu a.active .menu-icon {
            color: #93c5fd;
        }

        /* ----- SEPARATEUR ----- */
        .menu-separator {
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
            margin: 0.8rem 1.2rem;
        }

        /* ----- FOOTER SIDEBAR ----- */
        .sidebar-footer {
            padding: 1.5rem 1.8rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            margin-top: auto;
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            padding: 0.7rem 1.2rem;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar-footer a:hover {
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar-footer .menu-icon {
            font-size: 1rem;
        }

        /* ----- CONTENU PRINCIPAL (exemple) ----- */
        .main-content {
            flex: 1;
            padding: 2.5rem 3rem;
        }

        .main-content h1 {
            font-weight: 500;
            color: #0b2b4a;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .main-content p {
            color: #64748b;
            max-width: 600px;
        }

        /* ----- RESPONSIVE ----- */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
                height: auto;
                position: relative;
                padding: 1.2rem 0;
            }

            .sidebar-title {
                padding: 0 1.5rem 1.2rem;
            }

            .sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                gap: 0.3rem;
                padding: 0 1rem;
            }

            .sidebar-menu li {
                margin-bottom: 0;
                flex: 1 1 auto;
            }

            .sidebar-menu a {
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
                justify-content: center;
            }

            .menu-icon {
                margin-right: 6px;
                width: auto;
            }

            .menu-separator {
                display: none;
            }

            .sidebar-footer {
                display: none;
            }

            .main-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar-menu a {
                font-size: 0.75rem;
                padding: 0.5rem 0.8rem;
            }

            .menu-icon {
                font-size: 0.9rem;
                margin-right: 4px;
            }

            .sidebar-title h2 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <!-- Titre -->
        <div class="sidebar-title">
            <h2>Smooth <span>Operator</span></h2>
        </div>

        <!-- Menu -->
        <ul class="sidebar-menu">
            <li>
                <a href="/operation" class="active">
                    <span class="menu-icon">&#8226;</span> Opérations
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="menu-icon">&#8226;</span> Dashboard
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="menu-icon">&#8226;</span> Transactions
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="menu-icon">&#8226;</span> Clients
                </a>
            </li>
            <li class="menu-separator"></li>
            <li>
                <a href="#">
                    <span class="menu-icon">&#8226;</span> Historique
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="menu-icon">&#8226;</span> Rapports
                </a>
            </li>
        </ul>

        <!-- Footer -->
        <div class="sidebar-footer">
            <a href="#">
                <span class="menu-icon">&#8226;</span> Déconnexion
            </a>
        </div>
    </nav>

    <!-- Contenu principal (exemple) -->
    <main class="main-content">
        <h1>Bienvenue</h1>
        <p>Ceci est un exemple de contenu principal. La sidebar reste fixe sur les grands écrans.</p>
    </main>

</body>
</html>