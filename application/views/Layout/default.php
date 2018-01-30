<!DOCTYPE html>
<html lang='<?= config_item('language.key') ?>'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name='robots' content='noindex, nofollow'>
    <meta name="theme-color" content="#59B5C5">

    <title><?= app()->config->item('name', 'site_settings') ?></title>

    <link rel="icon" href="<?= base_url('/public/images/favicon.png'); ?>" />
    <!-- Styles -->
    <?php $this->asset->printStyles() ?>
</head>
<body>
<?= $this->cell('Navigation::default'); ?>
<main class="Main">
    <?= $this->cell('Navigation::navbar', [], ['page_title' => $this->fetch('page_title'), 'breadcrumb' => $this->fetch('breadcrumb')]); ?>

    <section class="Main-box">
        <div class="container-fluid">
<?php
$breadcrumb = $this->fetch('breadcrumb');
if (!empty($breadcrumb)):
    end($breadcrumb);
    $lastKey = key($breadcrumb);
?>
            <ol class="breadcrumb d-none d-lg-flex">
<?php
$icon = '<i class="material-icons">home</i>';
foreach ($this->fetch('breadcrumb') as $key=> $value):
?>
                <li class="breadcrumb-item">
                    <?= anchor(
                        $value['uri'],
                        $icon . ' ' . lang_libelle($value['label']),
                        [
                            'class' =>  (($key === $lastKey)? ' active' : ''),
                            'title' =>  lang_libelle($value['label']),
                        ]
                    ) ?>
                </li>
<?php
$icon = '';
endforeach;
?>
            </ol>
<?php endif; ?>
    <?= $this->cell('Flash::display'); ?>
    <?= $this->fetch('content') ?>
        </div>
    </section>
</main>

<div class="modal fade" id="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="js-dialog-text"></p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary js-dialog-confirm"><?= lang('general_action_confirm') ?></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('general_action_cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<?= $this->asset->printScript(); ?>
</body>
</html>
