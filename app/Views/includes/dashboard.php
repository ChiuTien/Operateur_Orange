<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <style>
        /* (Le style reste exactement identique à ton fichier d'origine) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Roboto, system-ui, sans-serif; background: #f4f7fc; min-height: 100vh; display: flex; }
        .sidebar { width: 280px; background: #0b2b4a; min-height: 100vh; padding: 2rem 0; display: flex; flex-direction: column; box-shadow: 4px 0 20px rgba(0, 0, 0, 0.06); position: sticky; top: 0; height: 100vh; }
        .sidebar-title { padding: 0 1.8rem 1.8rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); margin-bottom: 1.5rem; }
        .sidebar-title h2 { color: white; font-weight: 400; font-size: 1.4rem; letter-spacing: 0.5px; }
        .sidebar-title h2 span { font-weight: 700; color: #93c5fd; }
        .sidebar-menu { list-style: none; padding: 0 1rem; flex: 1; }
        .sidebar-menu li { margin-bottom: 0.3rem; }
        .sidebar-menu a { display: flex; align-items: center; padding: 0.8rem 1.2rem; color: rgba(255, 255, 255, 0.7); text-decoration: none; border-radius: 10px; font-size: 0.95rem; font-weight: 500; transition: 0.2s; border: 1px solid transparent; }
        .sidebar-menu a:hover { background: rgba(255, 255, 255, 0.08); color: white; border-color: rgba(255, 255, 255, 0.05); }
        .menu-icon { display: inline-block; width: 28px; text-align: center; margin-right: 12px; font-weight: 400; color: rgba(255, 255, 255, 0.5); font-size: 1.1rem; }
        .sidebar-footer { padding: 1.5rem 1.8rem 0; border-top: 1px solid rgba(255, 255, 255, 0.06); margin-top: auto; }
        .sidebar-footer a { display: flex; align-items: center; padding: 0.7rem 1.2rem; color: rgba(255, 255, 255, 0.5); text-decoration: none; border-radius: 10px; font-size: 0.85rem; font-weight: 500; transition: 0.2s; }
        .main-content { flex: 1; padding: 2.5rem 3rem; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="sidebar-title">
            <h2>Smooth <span>Operator</span></h2>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="<?= base_url('bareme') ?>">
                    <span class="menu-icon">&#8226;</span> Barème
                </a>
            </li>
            <li>
                <a href="<?= base_url('/prefixe') ?>">
                    <span class="menu-icon">&#8226;</span> Préfixes
                </a>
            </li>
            <li>
                <a href="<?= base_url('gain-frais') ?>">
                    <span class="menu-icon">&#8226;</span> Gain différent frais
                </a>
            </li>
            <li>
                <a href="<?= base_url('compte-client') ?>">
                    <span class="menu-icon">&#8226;</span> Compte client
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="<?= base_url('logout') ?>">
                <span class="menu-icon">&#8226;</span> Déconnexion
            </a>
        </div>
    </nav>

    <!-- Zone dynamique de contenu principal -->
    <main class="main-content">
        <!-- Les vues s'injecteront ici (Optionnel si tu utilises renderSection) -->