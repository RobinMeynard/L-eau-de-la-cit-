<?php
session_start();
require_once(__DIR__ . '/settings/databaseconnect.php');
require_once(__DIR__ . '/functions.php');
$error_msg = FALSE;

/*Lors de la connexion (du POST) on vérifie que les champs ne soit pas vide (avec le retrait des caractères spéciaux afin d'éviter des injections SQL)*/
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST['email'])
        || empty($_POST['password']
        || trim(strip_tags($_POST['email'])) === ''
        || trim(strip_tags($_POST['password'])) === '')
        ){
            $error_msg = TRUE;
        }

    $email = $_POST['email'];
    $password = $_POST['password'];
    /*Vérification de la correspondance entre les identifiants rentrés et ceux de la BDD*/
    if($email != "" && $password != ""){
        $req = $mysqlClient->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
        $rep = $req->fetch();
        /*Si les identifiants correspondent à une entrée de la BDD, 
        on récupère les données d'utilisateur pour les stocker dans la super globale $_SESSION*/
        if($rep['user_id'] != ""){
            $_SESSION['LOGGED_USER'] = [
                'name' => $rep['name'],
                'surname' => $rep['surname'],
                'email' => $rep['email'],
                'user_id' => $rep['user_id'],
                'admin' => $rep['admin'],
                'gender' => $rep['gender'],
                'password' => $rep['password'],
                'tel' => $rep['tel'],
                'address' => $rep['address'],
                'addresscomp' => $rep['addresscomp'],
                'city' => $rep['city'],
                'cp' => $rep['cp'],
                'country' => $rep['country']
            ];
            redirectToUrl('index.php');
        }
        else{
            $error_msg = TRUE;
        }
    }
}
?>
<?php require_once(__DIR__ . '/header.php'); ?>
<section class="connexion">
    <form class="login" action="" method="POST">
        <fieldset class="log">
            <legend>Se connecter</legend>
            <div>
                <label for="email">Adresse mail : </label>
                <input type="email" name="email" id="email" autofocus>
            </div>
            <div>
                <label for="password">Mot de passe : </label>
                <input type="password" name="password" id="password">
            </div>
            <?php if($error_msg){
                echo '<p style = "color:#FF0000">Email ou mot de passe incorrect !</p>';
            } ?>
            <input class="submit-log-in" type="submit" value="Se connecter">
        </fieldset>
        <p class="sign-up-link">Pas de compte ? <a class="lien-inscription" href="sign-in.php">Inscrivez-vous !</a></p>
    </form>
</section>
<?php require_once(__DIR__ . '/footer.php'); ?>
