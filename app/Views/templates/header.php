<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A basic point-of-sale system built with CodeIgniter 4.">
    <title><?= esc($title) ?> | POS System</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
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
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link<?= $activePage === 'customers' ? ' active' : '' ?>" href="<?= site_url('customers') ?>"<?= $activePage === 'customers' ? ' aria-current="page"' : '' ?>>
                            <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3.5 19v-1.5A4.5 4.5 0 0 1 8 13h2a4.5 4.5 0 0 1 4.5 4.5V19M16 6h5M18.5 3.5v5"/></svg>
                            <span>Customer Accounts</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link<?= $activePage === 'users' ? ' active' : '' ?>" href="<?= site_url('users') ?>"<?= $activePage === 'users' ? ' aria-current="page"' : '' ?>>
                            <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"/><path d="M5.5 20v-2A4.5 4.5 0 0 1 10 13.5h4a4.5 4.5 0 0 1 4.5 4.5v2"/></svg>
                            <span>User Accounts</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link<?= $activePage === 'about' ? ' active' : '' ?>" href="<?= site_url('about') ?>"<?= $activePage === 'about' ? ' aria-current="page"' : '' ?>>
                            <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7.5v.5"/></svg>
                            <span>About</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-meta">
                <span>IT0049</span>
                <strong>Technical Formative Assessment 2</strong>
            </div>
        </aside>

        <div class="workspace">
            <header class="topbar">
                <p class="breadcrumb"><span>POS Management</span><span aria-hidden="true">/</span><strong><?= esc($title) ?></strong></p>
                <p class="topbar-meta">CodeIgniter 4 &middot; MySQL</p>
            </header>

            <main class="main-content" id="main-content">
