<?php
$pagerResult = $this->fetch('pager')->getResult();
$currentPage = $pagerResult['page'];
$total = $pagerResult['pageCount']?: 1;
$baseUrl = $this->fetch('base_url') ?: current_base_url();
$dropup = $this->fetch('dropup');
// Limit choices filtering
sort($pagerResult['limit_choices']);
$pagerResult['limit_choices_filter'] = array_filter($pagerResult['limit_choices'], function($value) use ($pagerResult) {
    static $lastValue;
    $test = $lastValue;
    $lastValue = $value;
    if ($test && $test > $pagerResult['total']) {
        return false;
    }
    return true;
});
if (!($pagerResult['total'] < min($pagerResult['limit_choices']))):
?>
<form class="btn-toolbar" action="<?= site_url($baseUrl) ?>" method="get">
    <div class="btn-group hidden-sm-down">
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
    <div class="btn-group hidden-md-up">
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
        <span class="input-group-addon">/ <?= $total ?></span>
<?php
$sortable = $this->fetch('pager')->getSortable();
if (!empty($sortable)):
?>
        <div class="input-group-btn<?= $dropup?' dropup':'' ?>">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">sort_by_alpha</i>
                <span class="hidden-sm-down"><?= lang('card_filter_label_'.$pagerResult['sort']) ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
<?php
    foreach ($sortable as $queryKey => $v):
        if ($pagerResult['sort'] == $queryKey) :
            if ($pagerResult['direction'] == 'desc') :
?>
                <?= anchor(
                    $baseUrl . '?order=' . $queryKey . '&direction=asc',
                    lang('card_filter_label_'.$queryKey) . ' <i class="material-icons">arrow_drop_up</i>',
                    [
                        'class' => 'dropdown-item active',
                        'title' => lang('card_filter_label_'.$queryKey)
                    ]
                ) ?>
            <?php else: ?>
                <?= anchor(
                    $baseUrl . '?order=' . $queryKey . '&direction=desc',
                    lang('card_filter_label_'.$queryKey) . ' <i class="material-icons">arrow_drop_down</i>',
                    [
                        'class' => 'dropdown-item active',
                        'title' => lang('card_filter_label_'.$queryKey)
                    ]
                ) ?>
            <?php endif; ?>
<?php   else: ?>
            <?= anchor(
                $baseUrl . '?order=' . $queryKey,
                lang('card_filter_label_'.$queryKey),
                [
                    'class' => 'dropdown-item',
                    'title' => lang('card_filter_label_'.$queryKey)
                ]
            ) ?>
<?php
        endif;
    endforeach;
?>
            </div>
        </div>
<?php endif;?>
    </div>

    <div class="btn-group hidden-md-up">
        <?= anchor(
            $baseUrl.'?page='. ($currentPage+1),
            '<i class="material-icons">navigate_next</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == $total || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_next')
            ]
        ) ?>
    </div>
    <div class="btn-group hidden-sm-down">
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

<?php if (count($pagerResult['limit_choices_filter']) <= 1 ): ?>
    <div class="btn-group ml-2">
        <button type="button" class="btn btn-secondary hidden-sm-down" disabled>
            <span class="hidden-sm-down">
                <?= sprintf(lang('general_label_pagination_limit'), $pagerResult['limit']) ?>
            </span>
            <span class="hidden-md-up">
                <?= $pagerResult['limit'] ?>
            </span>
        </button>
    </div>
<?php else: ?>
    <div class="btn-group dropup ml-2">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="hidden-sm-down">
                <?= sprintf(lang('general_label_pagination_limit'), $pagerResult['limit']) ?>
            </span>
            <span class="hidden-md-up">
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
<?php else: ?>
<?php
$sortable = $this->fetch('pager')->getSortable();
if (!empty($sortable)):
?>
<div class="input-group ml-2 mr-2">
    <div class="input-group-btn<?= $dropup?' dropup':'' ?>">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">sort_by_alpha</i>
            <span class="hidden-sm-down"><?= lang('card_filter_label_'.$pagerResult['sort']) ?></span>
        </button>
        <div class="dropdown-menu">
<?php
    foreach ($sortable as $queryKey => $v):
        if ($pagerResult['sort'] == $queryKey) :
            if ($pagerResult['direction'] == 'desc') :
?>
                <?= anchor(
                    $baseUrl . '?order=' . $queryKey . '&direction=asc',
                    lang('card_filter_label_'.$queryKey) . ' <i class="material-icons">arrow_drop_up</i>',
                    [
                        'class' => 'dropdown-item active',
                        'title' => lang('card_filter_label_'.$queryKey)
                    ]
                ) ?>
            <?php else: ?>
                <?= anchor(
                    $baseUrl . '?order=' . $queryKey . '&direction=desc',
                    lang('card_filter_label_'.$queryKey) . '<i class="material-icons">arrow_drop_down</i> ',
                    [
                        'class' => 'dropdown-item active',
                        'title' => lang('card_filter_label_'.$queryKey)
                    ]
                ) ?>
            <?php endif; ?>
<?php   else: ?>
            <?= anchor(
                $baseUrl . '?order=' . $queryKey,
                lang('card_filter_label_'.$queryKey),
                [
                    'class' => 'dropdown-item',
                    'title' => lang('card_filter_label_'.$queryKey)
                ]
            ) ?>
<?php
        endif;
    endforeach;
?>
        </div>
    </div>
</div>
<?php endif;?>
<?php endif; ?>
