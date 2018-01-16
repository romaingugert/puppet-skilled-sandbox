<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="robots" content="noindex,nofollow">

    <title><?= app()->config->item('name', 'site_settings') ?></title>
    <meta name="theme-color" content="#59B5C5">

    <link rel="icon" href="<?= base_url('/public/images/favicon.png'); ?>" />
    <!-- Styles -->
    <?php $this->asset->printStyles() ?>
</head>
<body>

    <main class="Offline">
        <header class="Offline-header">
           <img class="Offline-logo" src="<?= $this->asset->getImageLink("icon.png") ?>" width="96" height="96" alt="PuppetSkilled">
           <h1><?= lang_libelle($this->fetch('page_title')) ?></h1>
<?php /* LEAD STYLE SI BESOIN  <p class="lead">Adipiscing proin ante justo molestie dolor velit dignissim magna sem eu</p> */ ?>
        </header>
        <section class="Offline-wrap container-fluid">
            <?= $this->cell('Flash::display'); ?>
            <?= $this->fetch('content') ?>
        </section>

        <?= $this->cell('Navigation::offlineFooter') ?>
    </main>
    <?= $this->asset->printScript(); ?>
</body>
</html>
