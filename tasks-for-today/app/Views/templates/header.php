<?php
$isLoggedIn = session('isLoggedIn') === true;
$authUsername = (string) (session('authUsername') ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tasks for Today Management System built with CodeIgniter 4.">
    <title><?= esc($title) ?> | Tasks for Today</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to main content</a>

    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="Tasks for Today home">
                <span class="brand-mark" aria-hidden="true">T</span>
                <span class="brand-copy">
                    <strong>Tasks for Today</strong>
                    <span>Daily task manager</span>
                </span>
            </a>

            <nav class="sidebar-nav" aria-label="Main navigation">
                <span class="nav-label">Workspace</span>
                <ul class="nav-list">
                    <li>
                        <a class="nav-link<?= $activePage === 'home' ? ' active' : '' ?>" href="<?= site_url('/') ?>"<?= $activePage === 'home' ? ' aria-current="page"' : '' ?>>
                            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 10.5 12 4l8 6.5V20H9v-6h6v6h5M4 10.5V20h3"/></svg>
                            <span>Today</span>
                        </a>
                    </li>
                    <?php if ($isLoggedIn): ?>
                        <li>
                            <a class="nav-link<?= $activePage === 'new-task' ? ' active' : '' ?>" href="<?= site_url('tasks/new') ?>"<?= $activePage === 'new-task' ? ' aria-current="page"' : '' ?>>
                                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                                <span>New Task</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a class="nav-link<?= $activePage === 'tasks' ? ' active' : '' ?>" href="<?= site_url('tasks') ?>"<?= $activePage === 'tasks' ? ' aria-current="page"' : '' ?>>
                            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M9 6h11M9 12h11M9 18h11M4 6h.01M4 12h.01M4 18h.01"/></svg>
                            <span>All Tasks</span>
                        </a>
                    </li>
                    <?php if (! $isLoggedIn): ?>
                        <li>
                            <a class="nav-link<?= $activePage === 'login' ? ' active' : '' ?>" href="<?= site_url('login') ?>"<?= $activePage === 'login' ? ' aria-current="page"' : '' ?>>
                                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M10 5H5v14h5M13 8l4 4-4 4M8 12h9"/></svg>
                                <span>Login</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a class="nav-link<?= $activePage === 'profile' ? ' active' : '' ?>" href="<?= site_url('profile') ?>"<?= $activePage === 'profile' ? ' aria-current="page"' : '' ?>>
                            <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"/><path d="M5.5 20v-2A4.5 4.5 0 0 1 10 13.5h4a4.5 4.5 0 0 1 4.5 4.5v2"/></svg>
                            <span>Profile</span>
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
                <strong>Technical Summative Assessment 2</strong>
            </div>
        </aside>

        <div class="workspace">
            <header class="topbar">
                <p class="breadcrumb"><span>Task Management</span><span aria-hidden="true">/</span><strong><?= esc($title) ?></strong></p>
                <div class="topbar-actions">
                    <?php if ($isLoggedIn): ?>
                        <span class="topbar-meta">Signed in as <strong><?= esc($authUsername) ?></strong></span>
                        <form class="logout-form" action="<?= site_url('logout') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="button button-quiet" type="submit">Log out</button>
                        </form>
                    <?php else: ?>
                        <p class="topbar-meta">Public task view &middot; CodeIgniter 4</p>
                    <?php endif; ?>
                </div>
            </header>

            <main class="main-content" id="main-content">
