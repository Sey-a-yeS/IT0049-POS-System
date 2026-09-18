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
    <header class="site-header">
        <div class="container nav-wrap">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="POS System home">
                <span class="brand-mark" aria-hidden="true">POS</span>
                <span>POS System</span>
            </a>

            <nav aria-label="Main navigation">
                <ul class="nav-list">
                    <li><a class="nav-link<?= $activePage === 'home' ? ' active' : '' ?>" href="<?= site_url('/') ?>"<?= $activePage === 'home' ? ' aria-current="page"' : '' ?>>Home</a></li>
                    <li><a class="nav-link<?= $activePage === 'about' ? ' active' : '' ?>" href="<?= site_url('about') ?>"<?= $activePage === 'about' ? ' aria-current="page"' : '' ?>>About</a></li>
                    <li><a class="nav-link<?= $activePage === 'customers' ? ' active' : '' ?>" href="<?= site_url('customers') ?>"<?= $activePage === 'customers' ? ' aria-current="page"' : '' ?>>Customer Accounts</a></li>
                    <li><a class="nav-link<?= $activePage === 'users' ? ' active' : '' ?>" href="<?= site_url('users') ?>"<?= $activePage === 'users' ? ' aria-current="page"' : '' ?>>User Accounts</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
