<?php extract([
    'title' => 'Connexion',
    'subtitle' => null,
], EXTR_SKIP) ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Puppet Skilled</title>
    <meta name="robots" content="noindex,nofollow">

    <meta name="theme-color" content="#59B5C5">

    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
    <link href="dist/styles/main.css" rel="stylesheet">
    <link href="dist/styles/flatpickr.css" rel="stylesheet">
</head>
<body>


    <main class="Offline">
        <header class="Offline-header">
            <img class="Offline-logo" src="dist/images/logo.png" width="96" height="96" alt="Puppet Skilled">
            <h1><?= $title ?></h1>
            <?php if ($subtitle): ?>
            <p class="lead"><?= $subtitle ?></p>
            <?php endif ?>
        </header>

        <section class="Offline-wrap container-fluid">
