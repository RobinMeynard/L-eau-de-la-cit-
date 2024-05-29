<?php
session_start();
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/settings/databaseconnect.php');

/*Condition qui vérifie que la personne qui tente d'accéder à cette page est bien un 
utilisateur connecté, dans le cas contraire, retour à la page index.php */
if (!isset($_SESSION['LOGGED_USER'])) {
    redirectToUrl('index.php');
}

$nameError = $surnameError = $mailError = $pwdError = $telError = $addressError = "";
/*Cette partie permets de mettre à jour les données utilisateur, en prévision d'une partie boutique en ligne */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['change-name'])) {
        if (empty($_POST['name']) || empty($_POST['prenom']) || trim(strip_tags($_POST['name'])) === '' || trim(strip_tags($_POST['prenom'])) === '') {
            $nameError = "Le nom est obligatoire.";
            $surnameError = "Le prénom est obligatoire.";
        } else {
            $name = trim(strip_tags($_POST['name']));
            $surname = trim(strip_tags($_POST['prenom']));

            $changeUser = $mysqlClient->prepare("UPDATE users SET name = :name, surname = :surname WHERE user_id = :user_id");
            $changeUser->execute([
                'name' => $name,
                'surname' => $surname,
                'user_id' => $_SESSION['LOGGED_USER']['user_id']
            ]);
        }
    }

    if (isset($_POST['change-mail'])) {
        if (empty($_POST['email']) || trim(strip_tags($_POST['email'])) === '') {
            $mailError = "Le mail est obligatoire.";
        } else {
            $mail = trim(strip_tags($_POST['email']));

            $changeMail = $mysqlClient->prepare("UPDATE users SET email = :email WHERE user_id = :user_id");
            $changeMail->execute([
                'email' => $mail,
                'user_id' => $_SESSION['LOGGED_USER']['user_id']
            ]);
        }
    }

    if (isset($_POST['change-password'])) {
        if (empty($_POST['password']) || empty($_POST['confpassword']) || trim(strip_tags($_POST['password'])) === '' || trim(strip_tags($_POST['confpassword'])) === '' || $_POST['password'] !== $_POST['confpassword']) {
            $pwdError = "Les mots de passe doivent correspondre et ne peuvent pas être vides.";
        } else {
            $pwd = trim(strip_tags($_POST['password']));

            $changePwd = $mysqlClient->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
            $changePwd->execute([
                'password' => $pwd,
                'user_id' => $_SESSION['LOGGED_USER']['user_id']
            ]);
        }
    }

    if (isset($_POST['change-tel'])) {
        if (empty($_POST['tel']) || trim(strip_tags($_POST['tel'])) === '') {
            $telError = "Le numéro de téléphone est obligatoire.";
        } else {
            $tel = trim(strip_tags($_POST['tel']));

            $changeTel = $mysqlClient->prepare("UPDATE users SET tel = :tel WHERE user_id = :user_id");
            $changeTel->execute([
                'tel' => $tel,
                'user_id' => $_SESSION['LOGGED_USER']['user_id']
            ]);
        }
    }

    if (isset($_POST['change-address'])) {
        if (empty($_POST['adresse'])
            || empty($_POST['ville'])
            || empty($_POST['code-postal'])
            || empty($_POST['pays'])
            || trim(strip_tags($_POST['adresse'])) === ''
            || trim(strip_tags($_POST['ville'])) === ''
            || trim(strip_tags($_POST['code-postal'])) === ''
            || trim(strip_tags($_POST['pays'])) === '') {
            $addressError = "Un champ obligatoire est manquant.";
        } else {
            $address = trim(strip_tags($_POST['adresse']));
            $addresscomp = trim(strip_tags($_POST['complement-adresse']));
            $city = trim(strip_tags($_POST['ville']));
            $cp = trim(strip_tags($_POST['code-postal']));
            $country = trim(strip_tags($_POST['pays']));

            $changeAddress = $mysqlClient->prepare("UPDATE users SET address = :address, addresscomp = :addresscomp, city = :city, cp = :cp, country = :country  WHERE user_id = :user_id");
            $changeAddress->execute([
                'address' => $address,
                'addresscomp' => $addresscomp,
                'city' => $city,
                'cp' => $cp,
                'country' => $country,
                'user_id' => $_SESSION['LOGGED_USER']['user_id']
            ]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="images/miniatureLogoSite.jpg" type="image-miniatureLogoSite">
    <title>L'eau de la cité - Menu</title>
    <link rel="stylesheet" href="stylesheets/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/header.php'); ?>
    <section class="inscription">
        <h2 class="titre-session">Vos coordonnées :</h2>
        <!--Cette section est divisé en plusieurs formulaires indépendants qui permettent 
        de modifier certaines informations sans être obligé de modifier toutes les données !-->
        <div class="modifs">
            <div>
                <?php echo $_SESSION['LOGGED_USER']['gender'] . ' ' . $_SESSION['LOGGED_USER']['name'] . ' ' . $_SESSION['LOGGED_USER']['surname']; ?><br>
                <form class="change-name" action="" method="POST">
                    <fieldset class="change">
                        <div>
                            <label for="name">Nom :</label>
                            <input type="text" name="name" id="name" autofocus>
                            <label for="prenom">Prénom :</label>
                            <input type="text" name="prenom" id="prenom">
                        </div>
                        <div>
                            <input class="submit-sign-up" type="submit" name="change-name" value="Modifier">
                        </div>
                    </fieldset>
                </form>
            </div>
            <div>
                Modification de votre adresse mail :</br>
                <?php echo $_SESSION['LOGGED_USER']['email']; ?><br>
                <form class="change-mail" action="" method="POST">
                    <fieldset class="change">
                        <div>
                            <label for="email">Nouvelle adresse mail : </label>
                            <input class="mail" type="email" name="email" id="email">
                        </div>
                        <div>
                            <input class="submit-sign-up" type="submit" name="change-mail" value="Modifier">
                        </div>
                    </fieldset class="change">
                </form>
                <span class="error"><?php echo $mailError; ?></span>
            </div>
            <div>
                Modification de votre mot de passe :</br>
                <form class="change-password" action="" method="POST">
                    <fieldset class="change">
                        <div>
                            <label for="password">Nouveau mot de passe : </label>
                            <input type="password" name="password" id="password">
                            <label for="confpassword">Confirmez votre nouveau mot de passe : </label>
                            <input type="password" name="confpassword" id="confpassword">
                        </div>
                        <div>
                            <input class="submit-sign-up" type="submit" name="change-password" value="Modifier">
                        </div>
                    </fieldset>
                </form>
                <span class="error"><?php echo $pwdError; ?></span>
            </div>
            <div>
                Modification de votre numéro de téléphone :</br>
                <?php echo $_SESSION['LOGGED_USER']['tel']; ?><br>
                <form class="change-tel" action="" method="POST">
                    <fieldset class="change">
                        <div>
                            <label for="tel">Nouveau numéro : </label>
                            <input type="tel" name="tel" id="tel">
                        </div>
                        <div>
                            <input class="submit-sign-up" type="submit" name="change-tel" value="Modifier">
                        </div>
                    </fieldset>
                </form>
                <span class="error"><?php echo $telError; ?></span>
            </div>
            <div>
                Modification de votre adresse :</br>
                <?php echo $_SESSION['LOGGED_USER']['address'] . ' ' . $_SESSION['LOGGED_USER']['addresscomp']; ?><br>
                <?php echo $_SESSION['LOGGED_USER']['city'] . ' ' . $_SESSION['LOGGED_USER']['cp'] . ' ' . $_SESSION['LOGGED_USER']['country']; ?><br>
                <form class="change-address" action="" method="POST">
                    <fieldset class="change">
                        <div>
                            <label for="adresse">Numéro et rue : </label>
                            <input class="adresse" type="text" name="adresse" id="adresse"></br>
                            <label for="complement-adresse">Complément d'adresse : </label>
                            <input class="complement-adresse" type="text" name="complement-adresse" id="complement-adresse"></br>
                            <label for="ville">Ville : </label>
                            <input type="text" name="ville" id="ville">
                            <label for="code-postal">Code postal : </label>
                            <input type="text" name="code-postal" id="code-postal">
                            <label for="pays">Pays : </label>
                            <input type="text" name="pays" id="pays">
                        </div>
                        <div>
                            <input class="submit-sign-up submit-session" type="submit" name="change-address" value="Modifier">
                        </div>
                    </fieldset>
                </form>
                <span class="error"><?php echo $telError; ?></span>
            </div>
        </div>
    </section>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>

</html>