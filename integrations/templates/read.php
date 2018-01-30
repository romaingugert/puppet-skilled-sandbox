<?php view('templates/snippets/_header', ['current' => $current]) ?>


<div class="text-right mb-4">
    <a class="btn btn-primary" href="<?= params(['view' => 'form']) ?>"><i class="material-icons">edit</i> Modifier</a>
    <a class="btn btn-danger" href="#" data-confirm="Supprimer la fiche ?"><i class="material-icons">delete</i> Supprimer</a>
</div>

<header class="mb-4" id="title">
    <h1>Inscription</h1>
    <p class="lead"><?= words(10,15) ?></p>
</header>


<div class="row">

    <!-- FORM -->
    <form class="col-xs-12 mb-4" action="<?= params(['view' => 'form'], false) ?>" method="POST">
        <!-- identification -->
        <fieldset class="card mb-4">
            <h2 class="card-header bg-dark text-white">Identification</h2>
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label" for="email">Adresse email</label>
                    <p class="form-control-plaintext">user@example.com</p>
                </div>
            </div>
        </fieldset>


        <!-- personnal information -->
        <fieldset class="card mb-4">
            <h2 class="card-header bg-dark text-white">Informations personnelles</h2>
            <div class="card-body">
                <div class="form-group">
                    <p class="col-form-label form-control-plaintext">Civilité</p>
                    <p class="form-control-plaintext">Madame</p>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label" for="lastname">Nom</label>
                        <p class="form-control-plaintext">Poppins</p>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label" for="firstname">Prénom</label>
                        <p class="form-control-plaintext">Marie</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="birthday">Date de naissance</label>
                    <p class="form-control-plaintext">1 janvier 1995</p>
                </div>
            </div>
        </fieldset>


        <!-- application -->
        <fieldset class="card mb-4">
            <h2 class="card-header bg-dark text-white">Candidature</h2>
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label" for="job">Poste</label>
                    <p class="form-control-plaintext">Rédacteur technique</p>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="description">Description brève</label>
                    <p class="form-control-plaintext"><?= words(10,15) ?></p>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="cv">Cirriculum</label>
                    <p class="form-control-plaintext">
                        <a href="#" class="btn btn-primary">Télécharger le fichier (PDF, 378Ko)</a>
                    </p>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="motivation">Motivation</label>
                    <div class="form-control-plaintext card card-body">
                        <h2><?= words(3,7) ?></h2>
                        <p><?= words(20,30) ?></p>
                        <ul>
                            <li><?= words(10,15) ?></li>
                            <li><?= words(10,15) ?></li>
                            <li><?= words(10,15) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</section>


<?php view('templates/snippets/_footer') ?>
