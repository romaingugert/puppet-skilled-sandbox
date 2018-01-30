<?php
$pagerResult = $this->fetch('pager_result');
$currentPage = $pagerResult['page'];
$total = $pagerResult['pageCount']?: 1;
$baseUrl = $this->fetch('base_url') ?: current_base_url();
// Limit choices filtering
$pagerResult['limit_choices_filter'] = array_filter($pagerResult['limit_choices'], function($value) use ($pagerResult) {
    return ($value <= $pagerResult['total']);
});
if (!($pagerResult['total'] < min($pagerResult['limit_choices']))):
?>
<form class="btn-toolbar" action="<?= site_url($baseUrl) ?>" method="get">
    <div class="btn-group d-none d-md-inline-flex">
        <?= anchor(
            $baseUrl.'?page=1',
            '<i class="material-icons">first_page</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == 1 || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_first_page')
            ]
        ) ?>
        <?= anchor(
            $baseUrl.'?page='. ($currentPage-1),
            '<i class="material-icons">navigate_before</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == 1 || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_before')
            ]
        ) ?>
    </div>
    <div class="btn-group d-md-none">
        <?= anchor(
            $baseUrl.'?page='. ($currentPage-1),
            '<i class="material-icons">navigate_before</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == 1 || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_before')
            ]
        ) ?>
    </div>

    <div class="input-group ml-2 mr-2">
        <input type="text" name="page" class="form-control input-xs text-center js-focus-select js-live-submit" value="<?= $pagerResult['page'] ?>" pattern="^[0-9+]$" />
        <span class="input-group-append">
            <span class="input-group-text">
                / <?= $total ?> 
            </span>
        </span>
    </div>

    <div class="btn-group d-md-none">
        <?= anchor(
            $baseUrl.'?page='. ($currentPage+1),
            '<i class="material-icons">navigate_next</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == $total || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_next')
            ]
        ) ?>
    </div>
    <div class="btn-group d-none d-md-inline-flex">
        <?= anchor(
            $baseUrl.'?page='. ($currentPage+1),
            '<i class="material-icons">navigate_next</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == $total || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_next')
            ]
        ) ?>
        <?= anchor(
            $baseUrl.'?page=' . ($pagerResult['pageCount']),
            '<i class="material-icons">last_page</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == $total || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_last_page')
            ]
        ) ?>
    </div>

<?php if (count($pagerResult['limit_choices_filter']) <= 1): ?>
    <div class="btn-group ml-2">
        <button type="button" class="btn btn-secondary d-none d-md-inline-block" disabled>
            <span class="d-none d-md-inline">
                <?= sprintf(lang('general_label_pagination_limit'), $pagerResult['limit']) ?>
            </span>
            <span class="d-md-none">
                <?= $pagerResult['limit'] ?>
            </span>
        </button>
    </div>
<?php else: ?>
    <div class="btn-group dropup ml-2">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="d-none d-md-inline">
                <?= sprintf(lang('general_label_pagination_limit'), $pagerResult['limit']) ?>
            </span>
            <span class="d-md-none">
                <?= $pagerResult['limit'] ?>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
<?php
foreach($pagerResult['limit_choices_filter'] as $limit):
    if ($pagerResult['limit'] != $limit):
?>
            <?= anchor(
                $baseUrl.'?page=1&pagesize=' . $limit,
                $limit,
                [
                    'class' => 'dropdown-item',
                ]
            ) ?>
<?php
    endif;
endforeach;
?>
        </div>
    </div>
<?php endif ?>
</form>
<?php endif; ?>
