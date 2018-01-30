<?php view('templates/snippets/_header-light', [
    'title' => 'Conditions d\'utilisation',
    'subtitle' => words(10,15),
]) ?>


<p>
    <a class="btn btn-primary" href="<?= params(['view' => 'login']) ?>">
        <i class="material-icons">arrow_back</i> Se connecter
    </a>
</p>

<section class="card card-body">
    <h2><?= words(5) ?></h2>
    <p><?= words(30) ?></p>
    <ul>
        <?php foreach(range(1,4) as $i): ?>
        <li><?= words(10,15) ?></li>
        <?php endforeach ?>
    </ul>
    <h3><?= words(5) ?></h3>
    <p><?= words(30) ?></p>
    <ol>
        <?php foreach(range(1,3) as $i): ?>
        <li><?= words(10,20) ?></li>
        <?php endforeach ?>
    </ol>
    <h4><?= words(5) ?></h4>
    <p><?= words(30) ?></p>
</section>


<?php view('templates/snippets/_footer-light') ?>
