<?php
require_once(__DIR__ . '/settings/databaseconnect.php');
?>

<?php require_once(__DIR__ . '/header.php'); ?>
<!-- Formulaire d'inscription d'utilisateur en prévision d'une partie boutique sur le site !-->
<section class="inscription">
    <!--Les données entrées dans le formulaire sont envoyées sur la page sign-inSubmit.php pour être traitées, pour des raisons de sécurité!-->
    <form class="sign-up" action="sign-inSubmit.php" method="POST">
        <fieldset class="log">
            <legend>S'inscrire</legend>
            <div>
                <label for="name">Nom : </label>
                <input type="text" name="name" id="name" autofocus>
                <label for="prenom">Prénom : </label>
                <input type="text" name="prenom" id="prenom">
            </div>
            <div>
                <label for="">Civilité : </label>
                <span><input type="radio" name="civilite" id="civilite" value="Mr">
                    <label for="civilite">Mr</label>
                    <input type="radio" name="civilite" id="civilite" value="Mme">
                    <label for="civilite">Mme</label></span>
            </div>
            <div>
                <label for="mail">Adresse mail : </label>
                <input class="mail" type="email" name="email" id="email">
            </div>
            <div>
                <label for="password">Mot de passe : </label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <label for="confpassword">Confirmez votre mot de passe : </label>
                <input type="password" name="confpassword" id="confpassword">
            </div>
            <div>
                <label for="tel">Téléphone : </label>
                <input type="tel" name="tel" id="tel">
            </div>
            <div>
                <label for="adresse">Numéro et rue : </label>
                <input class="adresse" type="text" name="adresse" id="adresse">
            </div>
            <div>
                <label for="complement-adresse">Complément d'adresse : </label>
                <input class="complement-adresse" type="text" name="complement-adresse" id="complement-adresse">
            </div>
            <div>
                <label for="ville">Ville : </label>
                <input type="text" name="ville" id="ville">
                <label for="code-postal">Code postal : </label>
                <input type="text" name="code-postal" id="code-postal">
            </div>
            <div>
                <label for="pays">Pays : </label>
                <input type="text" name="pays" id="pays">
            </div>
            <input class="submit-sign-up" type="submit" value="Valider">
        </fieldset>
    </form>
</section>
<?php require_once(__DIR__ . '/footer.php'); ?>