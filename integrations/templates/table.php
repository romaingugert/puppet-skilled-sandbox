<?php view('templates/snippets/_header', ['current' => $current, 'flash' => true]) ?>


<div class="alert alert-danger">
    <p><b>Attention:</b> <?= words(20) ?></p>
</div>


<div class="text-right mb-4">
    <a class="btn btn-primary" href="#"><i class="material-icons">add</i> Nouvel élément</a>
</div>


<div class="card mb-4">
    <div class="card-header">
      <button class="float-right btn btn-inverse btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Filtrer
          <i class="material-icons">filter_list</i>
      </button>
        11 résultats
    </div>
    <div class="card-body" id="collapseExample">
        <?php $filter = isset($_GET['filter']) ? $_GET['filter'] : null ?>
        <form action="#" method="get">
            <?php foreach (array_diff_key($_GET, array_flip(['filter'])) as $k => $v): ?>
            <input type="hidden" name="<?= $k ?>" value="<?= xss($v) ?>">
            <?php endforeach ?>
            <div class="form-group">
                <input type="text" class="form-control" name="filter" id="filter" placeholder="Filter les résultats…" value="<?= xss($filter) ?>" />
            </div>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <span class="form-check-legend">Actif</span>
                </div>
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="form-check-input custom-control-input" id="customCheck1" />
                        <label class="form-check-label custom-control-label" for="customCheck1">Oui</label>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="form-check-input custom-control-input" id="customCheck2" />
                        <label class="form-check-label custom-control-label" for="customCheck2">Non</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a class="btn btn-link" href="<?= params(['filter' => false]) ?>">Réinitialiser</a>
            </div>
        </form>
    </div>
</div>


<?php $page = isset($_GET['page']) ? $_GET['page'] : 1 ?>
<?php view('templates/snippets/pagination', [
    'page' => $page,
    'pages' => 3,
]) ?>


<div class="table-wrap mt-4 mb-4">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th><a href="#">Nom <i class="material-icons">arrow_drop_up</i></a></th>
                <th>Role</th>
                <th><a href="#">Date <i class="material-icons">arrow_drop_down</i></a></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (range(1,11) as $i): ?>
            <tr>
                <td><?= words(2, 3) ?></td>
                <td><span class="badge badge-secondary"><?= words(1, 2) ?></span></td>
                <td>January 3, 2017</td>
                <td class="table-actions">
                    <?php if ($i%2): ?>
                    <form class="d-inline" action="#" method="post">
                        <button type="submit"
                            class="btn btn-sm btn-success"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Déverrouiller"
                            data-confirm="Déverrouiller l'élément ?">
                            <i class="material-icons">lock_open</i>
                        </button>
                    </form>
                    <?php else: ?>
                    <form class="d-inline" action="#" method="post">
                        <button type="submit"
                            class="btn btn-sm btn-warning"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Verrouiller"
                            data-confirm="Verrouiller l'élément ?">
                            <i class="material-icons">lock</i>
                        </button>
                    </form>
                    <?php endif ?>
                    <form class="d-inline" action="#" method="post">
                        <button type="submit"
                            class="btn btn-sm btn-danger"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Supprimer"
                            data-modal="<?= ROOT, params(['view' => 'modal']) ?>">
                            <i class="material-icons">delete</i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<?php view('templates/snippets/pagination', [
    'page' => $page,
    'pages' => 3,
    'dropup' => true,
]) ?>


<?php view('templates/snippets/_footer', ['debug' => true]) ?>
