<?php
$isLoggedIn = session('isLoggedIn') === true;
$authUsername = (string) (session('authUsername') ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A secure point-of-sale management system built with CodeIgniter 4.">
    <title><?= esc($title) ?> | POS System</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script defer src="<?= base_url('assets/js/pos.js') ?>"></script>
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to main content</a>

    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="POS System home">
                <span class="brand-mark" aria-hidden="true">P</span>
                <span class="brand-copy">
                    <strong>POS System</strong>
                    <span>Management console</span>
                </span>
            </a>

            <nav class="sidebar-nav" aria-label="Main navigation">
                <span class="nav-label">Workspace</span>
                <ul class="nav-list">
                    <li>
                        <a class="nav-link<?= $activePage === 'home' ? ' active' : '' ?>" href="<?= site_url('/') ?>"<?= $activePage === 'home' ? ' aria-current="page"' : '' ?>>
                            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 10.5 12 4l8 6.5V20H9v-6h6v6h5M4 10.5V20h3"/></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php if ($isLoggedIn): ?>
                        <li>
                            <a class="nav-link<?= $activePage === 'products' ? ' active' : '' ?>" href="<?= site_url('products') ?>"<?= $activePage === 'products' ? ' aria-current="page"' : '' ?>>
                                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 7h16v13H4zM7 7V4h10v3M8 12h8M8 16h5"/></svg>
                                <span>Products</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link<?= $activePage === 'customers' ? ' active' : '' ?>" href="<?= site_url('customers') ?>"<?= $activePage === 'customers' ? ' aria-current="page"' : '' ?>>
                                <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3.5 19v-1.5A4.5 4.5 0 0 1 8 13h2a4.5 4.5 0 0 1 4.5 4.5V19M16 6h5M18.5 3.5v5"/></svg>
                                <span>Customers</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link<?= $activePage === 'users' ? ' active' : '' ?>" href="<?= site_url('users') ?>"<?= $activePage === 'users' ? ' aria-current="page"' : '' ?>>
                                <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"/><path d="M5.5 20v-2A4.5 4.5 0 0 1 10 13.5h4a4.5 4.5 0 0 1 4.5 4.5v2"/></svg>
                                <span>Staff</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link<?= $activePage === 'record-sale' ? ' active' : '' ?>" href="<?= site_url('sales/new') ?>"<?= $activePage === 'record-sale' ? ' aria-current="page"' : '' ?>>
                                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M5 4h14v16H5zM8 8h8M8 12h3M8 16h8M15 12h1"/></svg>
                                <span>Record Sale</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link<?= $activePage === 'sales' ? ' active' : '' ?>" href="<?= site_url('sales') ?>"<?= $activePage === 'sales' ? ' aria-current="page"' : '' ?>>
                                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 19h16M6 16V9M11 16V5M16 16v-4M20 16V7"/></svg>
                                <span>Sales History</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a class="nav-link<?= $activePage === 'about' ? ' active' : '' ?>" href="<?= site_url('about') ?>"<?= $activePage === 'about' ? ' aria-current="page"' : '' ?>>
                            <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7.5v.5"/></svg>
                            <span>About</span>
                        </a>
                    </li>
                    <?php if (! $isLoggedIn): ?>
                        <li>
                            <a class="nav-link<?= $activePage === 'login' ? ' active' : '' ?>" href="<?= site_url('login') ?>"<?= $activePage === 'login' ? ' aria-current="page"' : '' ?>>
                                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M10 5H5v14h5M13 8l4 4-4 4M8 12h9"/></svg>
                                <span>Staff Login</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="sidebar-meta">
                <span>IT0049</span>
                <strong>Midterm Project</strong>
            </div>
        </aside>

        <div class="workspace">
            <header class="topbar">
                <p class="breadcrumb"><span>POS Management</span><span aria-hidden="true">/</span><strong><?= esc($title) ?></strong></p>
                <div class="topbar-actions">
                    <?php if ($isLoggedIn): ?>
                        <span class="topbar-meta">Signed in as <strong><?= esc($authUsername) ?></strong></span>
                        <form class="logout-form" action="<?= site_url('logout') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="button button-quiet" type="submit">Log out</button>
                        </form>
                    <?php else: ?>
                        <p class="topbar-meta">Public area &middot; CodeIgniter 4</p>
                    <?php endif; ?>
                </div>
            </header>

            <main class="main-content" id="main-content">
