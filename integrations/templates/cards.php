<?php view('templates/snippets/_header', ['current' => $current]) ?>


<div class="text-right mb-4">
    <a class="btn btn-primary" href="#"><i class="material-icons">add</i> Nouvel élément</a>
</div>


<div class="card mb-4">
    <div class="card-header">
        <a class="float-right btn btn-inverse btn-sm" href="<?= params(['filter' => false]) ?>">Réinitialiser</a>
        11 résultats
    </div>
    <div class="card-body">
        <?php $filter = isset($_GET['filter']) ? $_GET['filter'] : null ?>
        <form action="#" method="get">
            <?php foreach (array_diff_key($_GET, array_flip(['filter'])) as $k => $v): ?>
            <input type="hidden" name="<?= $k ?>" value="<?= xss($v) ?>">
            <?php endforeach ?>
            <div class="input-group">
                <input type="text" class="form-control" name="filter" id="filter" placeholder="Filter les résultats…" value="<?= xss($filter) ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Filtrer</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php $page = isset($_GET['page']) ? $_GET['page'] : 1 ?>
<?php view('templates/snippets/pagination', [
    'page' => $page,
    'pages' => 3,
    'order' => 'name',
    'orders' => ['name' => 'Nom', 'date' => 'Date'],
]) ?>



<form class="row mt-4" action="#" method="post">
    <?php view('templates/snippets/actions') ?>
    <?php foreach (range(1,11) as $i): ?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-xl-3">
        <div class="Selectable card mb-4">
            <div class="Selectable-checkbox custom-control custom-checkbox">
                <input<?= attr([
                    'type' => 'checkbox',
                    'name' => 'selection',
                    'class' => 'custom-control-input',
                    'value' => $i,
                    'data-check' => 'cruditems',
                    'id' => $i . 'selectableCheckbox',
                ]) ?>>
                <label class="custom-control-label" for="<?= $i ?>selectableCheckbox"></label>
            </div>
            <div class="card-body">
                <a href="#"><?= words(2, 3) ?></a><br>
                <span class="badge badge-secondary text-lowercase"><?= words(1, 2) ?></span>
            </div>
            <div class="card-footer text-muted">
                January 3, 2017
            </div>
        </div>
    </div>
    <?php endforeach ?>
</form>


<?php view('templates/snippets/pagination', [
    'page' => $page,
    'pages' => 3,
    'order' => 'name',
    'orders' => ['name' => 'Nom', 'date' => 'Date'],
    'dropup' => true,
]) ?>


<?php view('templates/snippets/_footer') ?>
