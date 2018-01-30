<?php
extract([
    'order' => false,
    'orders' => false,
    'dropup' => false,
], EXTR_SKIP);
?>
<form class="btn-toolbar">
    <?php foreach (array_diff_key($_GET, array_flip(['page'])) as $k => $v): ?>
    <input type="hidden" name="<?= $k ?>" value="<?= xss($v) ?>">
    <?php endforeach ?>
    <div class="btn-group d-none d-md-inline-flex">
        <a<?= attr([
            'href' => params(['page' => 1]),
            'class' => classes([
                'btn btn-secondary' => true,
                'disabled' => $pages == 1 || $page == 1,
            ]),
        ]) ?>><i class="material-icons">first_page</i></a>
        <a<?= attr([
            'href' => params(['page' => $page-1]),
            'class' => classes([
                'btn btn-secondary' => true,
                'disabled' => $pages == 1 || $page == 1,
            ]),
        ]) ?>><i class="material-icons">navigate_before</i></a>
    </div>
    <div class="btn-group d-md-none">
        <a<?= attr([
            'href' => params(['page' => $page-1]),
            'class' => classes([
                'btn btn-secondary' => true,
                'disabled' => $pages == 1 || $page == 1,
            ]),
        ]) ?>><i class="material-icons">navigate_before</i></a>
    </div>
    <div class="input-group ml-2 mr-2">
        <input<?= attr([
            'type' => 'text',
            'name' => 'page',
            'class' => 'form-control input-xs text-center js-focus-select js-live-submit',
            'value' => xss($page),
            'disabled' => $pages == 1,
            'pattern' => '^[0-9+]$'
        ]) ?> />
        <div class="input-group-append">
            <span class="input-group-text"><?= "de $pages" ?></span>
            <?php if (is_array($orders)): ?>
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">sort_by_alpha</i> <span class="d-none d-md-inline"><?= $orders[$order] ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <?php foreach ($orders as $k => $v): ?>
                    <a class="dropdown-item<?= $order==$k?' active':null ?>" href="<?= params(['order' => $k]) ?>"><?= "Trier par $v" ?></a>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="btn-group d-md-none">
        <a<?= attr([
            'href' => params(['page' => $page+1]),
            'class' => classes([
                'btn btn-secondary' => true,
                'disabled' => $pages == 1 || $page == $pages,
            ]),
        ]) ?>><i class="material-icons">navigate_next</i></a>
    </div>
    <div class="btn-group d-none d-md-inline-flex">
        <a<?= attr([
            'href' => params(['page' => $page+1]),
            'class' => classes([
                'btn btn-secondary' => true,
                'disabled' => $pages == 1 || $page == $pages,
            ]),
        ]) ?>><i class="material-icons">navigate_next</i></a>
        <a<?= attr([
            'href' => params(['page' => $pages]),
            'class' => classes([
                'btn btn-secondary d-none d-md-inline' => true,
                'disabled' => $pages == 1 || $page == $pages,
            ]),
        ]) ?>><i class="material-icons">last_page</i></a>
    </div>
</form>
