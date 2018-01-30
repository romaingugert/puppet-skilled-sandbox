<?php
$pager = $this->fetch('pager');
$pagerResult = $pager->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();
$contentFunction = $this->fetch('content');
$footerFunction = $this->fetch('footer');
$actions = $this->fetch('actions');
?>
<?= $this->element('card/pagination', ['pager' => $pager]); ?>
<form class="row mt-4 card-list" action="<?= $baseUrl ?>" method="post">
<?= form_csrf_input() ?>
<?php if ($actions): ?>
    <div class="Selectable-actions clearfix">
        <div class="float-left">
            <button type="button" class="btn btn-inverse btn-sm" data-check-cancel="cruditems">
                <i class="material-icons">close</i>
                <span class="d-none d-md-inline"><?= lang('general_label_selection') ?></span>
                <span class="badge badge-secondary" data-check-count="cruditems">0</span>
            </button>
        </div>
        <div class="float-right">
<?php
foreach ($actions as $key => $value) :
    $attributes = [
        'type' => "submit",
        'formaction' => site_url($value['url']),
        'class' => "btn btn-success btn-sm",
        'data-check-data' => "cruditems",
    ];
    if (isset($value['extra'])) {
        $attributes = $value['extra'] + $attributes;
    }
?>
    <button <?= _attributes_to_string($attributes) ?>>
        <?= $value['label'] ?>
    </button>
<?php
    endforeach;
?>
        </div>
    </div>
<?php
endif;
?>
<?php
if (empty($pagerResult['result'])) :
?>
<p><?= lang_libelle('lang:general_label_no-result-found') ?></p>
<?php
else :
    foreach ($pagerResult['result'] as $item) :
?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-xl-3">
        <div class="Selectable card mb-4">
<?php if ($actions): ?>
            <label class="Selectable-checkbox custom-control custom-checkbox">
                <input <?= _attributes_to_string([
                    'type' => 'checkbox',
                    'name' => 'selected[]',
                    'class' => 'custom-control-input',
                    'value' => $item->getRouteKey(),
                    'data-check' => 'cruditems',
                ]) ?>>
                <span class="custom-control-label"></span>
            </label>
<?php endif; ?>
            <div class="card-body">
                <?= $contentFunction($item) ?>
            </div>
<?php if ($footerFunction): ?>
            <div class="card-footer text-muted">
                <?= $footerFunction($item) ?>
            </div>
<?php endif; ?>
        </div>
    </div>
<?php
    endforeach;
endif;
?>
</form>
<?= $this->element('card/pagination', ['pager' => $pager, 'dropup' => true]); ?>
