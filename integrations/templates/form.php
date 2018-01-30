<?php view('templates/snippets/_header', ['current' => $current]) ?>

<?php // var_dump($_POST) ?>

<header class="mb-4" id="title">
    <h1>Inscription</h1>
    <p class="lead"><?= words(10,15) ?></p>
    <a href="#notes" class="btn btn-secondary btn-sm d-lg-none">
        <i class="material-icons">help</i>
        Accéder à l'aide
    </a>
</header>


<div class="alert alert-danger">
    <p>Les champs suivants nécessitent votre attention :</p>
    <ul>
        <li><b>Adresse email</b> : Cette addresse email est déjà utilisée.</li>
        <li><b>Civilité</b> : Ce champ est requis.</li>
    </ul>
</div>


<div class="row">

    <!-- FORM -->
    <form class="col-lg-8 mb-4" action="<?= params(['view' => 'form'], false) ?>" method="POST">

        <!-- autocomplete -->
        <fieldset class="card mb-4">
            <h2 class="card-header bg-dark text-white">Autocomplete</h2>
            <div class="card-body">
                <div class="form-group">
                    <?php $val = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : null ?>
                    <label class="col-form-label" for="country">Votre pays préféré :</label>
                    <input type="text"
                        id="country"
                        name="country"
                        class="form-control"
                        value="<?= $val ?>"
                    />
                </div>
                <div class="form-group">
                    <?php $val = isset($_POST['fruit']) ? htmlspecialchars($_POST['fruit']) : null ?>
                    <label class="col-form-label" for="fruit">Votre fruit préféré :</label>
                    <select
                        id="fruit"
                        name="fruit"
                        class="form-control"
                    >
                        <option class="autocomplete-skip">Choisir un fruit</option>
                        <?php $fruits = ['Orange', 'Banane', 'Kiwi', 'Poire', 'Pomme', 'Pastèque', 'Melon', 'Litchi', 'Cerise', 'Fraise', 'Framboise', 'Noix de coco']; ?>
                        <?php foreach($fruits as $i => $item): ?>
                        <option value="fruit-<?= $i ?>"
                            <?= $val == 'fruit-' . $i ? 'selected="true"' : null ?>>
                            <?= $item ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </fieldset>

        <!-- identification -->
        <fieldset class="card mb-4">
            <h2 class="card-header bg-dark text-white">Identification</h2>
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label" for="email">Adresse email</label>
                    <input type="email" name="email" class="form-control is-invalid" id="email" aria-describedby="email-help" placeholder="exemple@tonton.biz" value="user@example.com">
                    <div class="invalid-feedback">
                        <i class="material-icons">warning</i>
                        Cette addresse email est déjà utilisée.
                    </div>
                    <small id="email-help" class="form-text text-muted">Votre adresse email doit être valide.</small>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="password">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                </div>
            </div>
        </fieldset>


        <!-- personnal information -->
        <fieldset class="card mb-4">
            <h2 class="card-header bg-dark text-white">Informations personnelles</h2>
            <div class="card-body">
                <div class="form-group">
                    <p class="col-form-label form-control-plaintext">Civilité</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input is-invalid" type="radio" name="sex" value="Madame">
                        <label class="form-check-label">
                            Madame
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input is-invalid" type="radio" name="sex" value="Monsieur">
                        <label class="form-check-label">
                            Monsieur
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input is-invalid" type="radio" name="sex" value="Autre">
                        <label class="form-check-label">
                            Autre
                        </label>
                    </div>
                    <div class="invalid-feedback d-flex">
                        <i class="material-icons">warning</i>
                        Ce champ est obligatoire.
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label" for="lastname">Nom</label>
                        <input type="text" name="lastname" class="form-control is-valid" id="lastname" placeholder="Poppins" value="Poppins">
                        <div class="valid-feedback">
                            <i class="material-icons">check</i>
                            Bien entendu.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label" for="firstname">Prénom</label>
                        <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Marie">
                    </div>
                </div>
            </div>
        </fieldset>


        <!-- application -->
        <fieldset class="card mb-4">
            <h2 class="card-header bg-dark text-white">Candidature</h2>
            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label" for="job">Poste</label>
                    <select class="form-control" name="job" id="job">
                        <option>Choisir le poste</option>
                        <option>Développeur front-end junior</option>
                        <option>Développeur back-end junior</option>
                        <option>Technicien WordPress</option>
                        <option>Rédacteur technique</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="description">Description brève</label>
                    <textarea class="form-control" name="description" id="description" aria-describedby="description-help" rows="3"></textarea>
                    <a class="form-text small" data-toggle="collapse" href="#description-help" aria-expanded="false" aria-controls="description-help">
                        <i class="material-icons">help</i>
                        Aide complémentaire
                    </a>
                    <div class="collapse" id="description-help">
                        <small class="form-text text-muted">
                            <?= words(20,30) ?>
                        </small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="cv">Cirriculum</label>
                    <input type="file" name="cv" class="form-control-file" id="cv" aria-describedby="cv-help">
                    <small id="cv-help" class="form-text text-muted">Format PDF, maximum 1Mo.</small>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="motivation">Motivation</label>
                    <textarea class="form-control js-markdown" rows="6" name="motivation" id="motivation" aria-describedby="motivation-help"></textarea>
                    <small id="motivation-help" class="form-text text-muted">Le format <a href="#">Markdown</a> est autorisé.</small>
                </div>
            </div>
        </fieldset>


        <!-- submit -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </div>
    </form>



    <!-- NOTES -->
    <aside class="col-lg-4" id="notes">
        <a href="#title" class="btn btn-secondary btn-sm d-lg-none mb-2">
            <i class="material-icons">arrow_upward</i>
            Retour en haut de page
        </a>
        <h2>Aide générale</h2>
        <p><?= words(30,50) ?></p>
        <h2>Notes complémentaires</h2>
        <ul>
            <li><?= words(10,15) ?></li>
            <li><?= words(10,15) ?></li>
            <li><?= words(10,15) ?></li>
        </ul>
    </aside>
</section>


<?php view('templates/snippets/_footer') ?>
