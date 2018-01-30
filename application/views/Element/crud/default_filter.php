<?php
$filters = $this->fetch('filters');
$pagers = $this->fetch('pager');
$baseUrl = $this->fetch('base_url') ?: current_base_url();
?>
<div class="card card-filter mb-4">
    <div class="card-header">
        <?= anchor(
            $baseUrl . '?'.$filters->getActionName().'='.$filters->getResetActionValue(),
            lang('general_action_reset_filters'),
            [
                'class' => 'float-right btn btn-inverse btn-sm'
            ]
        ) ?>
        <?= lang('general_label_total_element') ?> <?= $pagers['total'] ?>
    </div>
    <div class="card-body">
        <?php $preprendId = uniqid(); ?>
        <form action="<?= site_url($baseUrl) ?>" method="get" accept-charset="utf-8">
            <div class="input-group">
                <input type="text" class="form-control" name="search" id="<?= $preprendId ?>search" placeholder="<?= lang('general_label_filter_search') ?>" value="<?= html_escape($filters->getValue('search')) ?>">
                <div class="input-group-append">
                    <button type='submit' value="<?= $filters->getFilterActionValue() ?>" name="<?= $filters->getActionName() ?>" class='btn btn-secondary'>
                        <?= lang('general_action_filter') ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
