<?php view('templates/snippets/_header-light', [
    'title' => 'Connexion',
    'subtitle' => words(10,15),
]) ?>


<div class="alert alert-danger">
    <p>Les champs suivants nécessitent votre attention :</p>
    <ul>
        <li><b>Adresse email</b> : Aucun compte ne correspond à cette adresse email.</li>
    </ul>
</div>


<!-- FORM -->
<form action="<?= params(['view' => 'home'], false) ?>" method="POST">

    <!-- identification -->
    <fieldset class="card mb-4">
        <h2 class="card-header bg-dark text-white">Identification</h2>
        <div class="card-body">
            <div class="form-group">
                <label class="col-form-label" for="email">Adresse email</label>
                <input type="email" name="email" class="form-control is-invalid" id="email" aria-describedby="email-help" placeholder="exemple@tonton.biz" value="user@example.com">
                <div class="invalid-feedback">
                    <i class="material-icons">warning</i>
                    Aucun compte ne correspond à cette adresse email.
                </div>
                <small id="email-help" class="form-text text-muted">Votre adresse email doit être valide.</small>
            </div>
            <div class="form-group">
                <label class="col-form-label" for="password">Mot de passe</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" aria-describedby="password-help">
                <a href="#" id="password-help" class="form-text text-muted small">Mot de passe oublié ?</a>
            </div>
        </div>
    </fieldset>


    <!-- submit -->
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Se connecter</button>
        <a href="#" class="btn btn-link">Créer un compte utilisateur</a>
    </div>
</form>


<?php view('templates/snippets/_footer-light') ?>
