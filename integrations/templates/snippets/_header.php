<?php extract([
    'current' => 'home',
    'flash' => false,
], EXTR_SKIP) ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Puppet Skilled</title>
    <meta name="robots" content="noindex,nofollow">

    <meta name="theme-color" content="#59B5C5">

    <link href="dist/styles/main.css" rel="stylesheet">
    <link href="dist/styles/flatpickr.css" rel="stylesheet">
    <link href="dist/styles/debug.css" rel="stylesheet">
</head>
<body>

    <!-- Sidebar: account and menu -->
    <input type="checkbox" id="sidenav-token">
    <label for="sidenav-token" class="Sidenav-overlay"></label>
    <section class="Sidenav">
        <header class="Sidenav-header">
            <img class="Sidenav-header-icon" src="dist/images/icon.png" alt="Application icon">
            <div class="Sidenav-header-lang dropdown">
                <button class="btn btn-inverse btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    FR
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item active" href="#">FR</a>
                    <a class="dropdown-item" href="#">EN</a>
                </div>
            </div>
            <div class="Sidenav-header-title">Puppet Skilled</div>
        </header>
        <aside class="Sidenav-account">
            <a href="#"
                class="Sidenav-account-alerts btn btn-warning btn-sm"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Notifications">
                <i class="material-icons">notifications_active</i>
                14
            </a>
            <div class="Sidenav-account-wrap">
                <img class="Sidenav-account-logo" src="dist/images/logo.png" alt="Logo de l'entreprise">
                <div class="dropdown">
                    <button class="Sidenav-account-name dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Marie Poppins
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Mon profil</a>
                        <a class="dropdown-item" href="#">
                            Notifications
                            <span class="badge badge-warning">
                                <i class="material-icons">notifications_active</i>
                                14
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Déconnexion</a>
                    </div>
                </div>
                <span class="Sidenav-account-sitename">Nom de l'entreprise</span>
            </div>
        </aside>
        <nav class="Sidenav-nav">
            <h2>Démos</h2>
            <ul>
                <?php foreach ([
                    'home' => 'Dashboard',
                    'cards' => 'BO cards',
                    'table' => 'BO tableau',
                    'form' => 'Formulaire écriture',
                    'read' => 'Formulaire lecture',
                    'login' => 'Formulaire hors connexion',
                    'legal' => 'Page hors connexion',
                ] as $k => $v): ?>
                <li<?php if ($current == $k) echo ' class="active"' ?>>
                    <a href="<?= params(['view' => $k]) ?>"><?= $v ?></a>
                </li>
                <?php endforeach ?>
            </ul>
            <?php foreach(range(2, 3) as $i): ?>
            <h2>Section <?= $i ?></h2>
            <ul>
                <?php foreach(range(1, $i+1) as $j): ?>
                <li><a href="#">Lien <?= $j ?></a></li>
                <?php endforeach ?>
            </ul>
            <?php endforeach ?>
        </nav>
        <footer class="Sidenav-footer">
            <ul>
                <li><a href="#">Aide utilisateur</a></li>
                <li><a href="#">Conditions d'utilisation</a></li>
                <li><a href="#">Mentions légales</a></li>
            </ul>
            <p>© 2017 <a href="https://github.com/globalis-ms/puppet-skilled-sandbox" target="_blank">Puppet Skilled</a></p>
            <p>Propulsé par <a href="https://www.globalis-ms.com" target="_blank">GLOBALIS</a></p>
        </footer>
    </section>



    <!-- Main container -->
    <?php $search = isset($_GET['q']) ? xss($_GET['q']) : null ?>
    <main class="Main">
        <!-- Navbar: title and search -->
        <header class="Navbar">
            <input type="checkbox" id="search-token"<?= $search ? ' checked': null ?>>
            <label for="sidenav-token" class="Navbar-toggler">
                <i class="material-icons">menu</i>
            </label>
            <h1 class="Navbar-title hidden-md-down">Titre de la page</h1>
            <div class="dropdown hidden-lg-up">
                <button class="Navbar-title dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Titre de la page
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?= params(['view' => 'home']) ?>"><i class="material-icons">home</i> Dashboard</a>
                    <a class="dropdown-item" href="#"><i class="material-icons">arrow_back</i> Page grand-parente</a>
                    <a class="dropdown-item" href="#"><i class="material-icons">arrow_back</i> Page parente</a>
                    <a class="dropdown-item active" href="#"><i class="material-icons">arrow_downward</i> Titre de la page</a>
                </div>
            </div>
            <a href="#"
                class="Navbar-alerts btn btn-warning btn-sm"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Notifications">
                <i class="material-icons">notifications_active</i>
                14
            </a>
            <form class="Navbar-search" method="get" action="#">
                <?php if ($search): ?>
                <a href="<?= params(['q' => false]) ?>" class="Navbar-search-close"><i class="material-icons">arrow_back</i></a>
                <?php else: ?>
                <label for="search-token" class="Navbar-search-close"><i class="material-icons">arrow_back</i></label>
                <?php endif ?>
                <?php foreach (array_diff_key($_GET, array_flip(['q'])) as $k => $v): ?>
                <input type="hidden" name="<?= $k ?>" value="<?= xss($v) ?>">
                <?php endforeach ?>
                <input type="text" name="q" id="search" class="Navbar-search-field" placeholder="Rechercher…" value="<?= $search ?>">
                <button type="submit" class="Navbar-search-button">
                    <i class="material-icons">search</i>
                </button>
            </form>
            <label for="search-token" class="Navbar-search-open" data-focus="#search"><i class="material-icons">search</i></label>
        </header>


        <!-- Flash alerts -->
        <aside class="FlashAlerts">
            <?php if ($flash): ?>
            <?php foreach (['danger', 'warning', 'info', 'success'] as $type): ?>
            <div class="alert alert-<?= $type ?>" data-auto-dismiss="3000">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="material-icons">close</i></button>
                <?= words(10,20) ?>
            </div>
            <?php endforeach ?>
            <?php endif ?>
        </aside>



        <!-- Main box: page content goes here -->
        <section class="Main-box">
            <div class="container-fluid">
                <ol class="breadcrumb hidden-md-down">
                    <li class="breadcrumb-item"><a href="<?= params(['view' => 'home']) ?>"><i class="material-icons">home</i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Page grand-parente</a></li>
                    <li class="breadcrumb-item"><a href="#">Page parente</a></li>
                    <li class="breadcrumb-item active">Titre de la page</li>
                </ol>
