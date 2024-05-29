<?php
    /*Récuperation des données de la session en cours s'il y en a une*/
    if(isset($_SESSION['LOGGED_USER'])){
        $surname = $_SESSION['LOGGED_USER']['surname'];
        $name = $_SESSION['LOGGED_USER']['name'];
        $admin = $_SESSION['LOGGED_USER']['admin'];
    }

    require_once(__DIR__ . '/settings/databaseconnect.php');


    $reqTypes = $mysqlClient->query("SELECT DISTINCT type FROM products");
    $typesList = $reqTypes->fetchAll(PDO::FETCH_ASSOC);

    $reqPage = $mysqlClient->query("SELECT * FROM head");
    $titlePage = $reqPage->fetchAll(PDO::FETCH_ASSOC);
?>
<!--En-tête avec le menu intégré dans chaque page affichée à l'utilisateur avec la fonction "require_once()"!-->
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/miniatureLogoSite.jpg" type="image-miniatureLogoSite">
        <!--Le titre de la page va dépendre de l'URL!-->
        <title>
            <?php foreach ($titlePage as $page) {
                if ($_SERVER['PHP_SELF'] == "/test/leaudelacite/" . $page['url'] && $page['url'] == "productSheet.php") {
                    echo $page['title'] . " " . $product['title'];
                }
                elseif ($_SERVER['PHP_SELF'] == "/test/leaudelacite/" . $page['url']) {
                    echo $page['title'];
                }
            }
            ?>
        </title>
        <link rel="stylesheet" href="stylesheets/style.css" >
    </head>

    <body>
<header>
    <div class="menu-gauche">
        <nav>
            <ul>
                <li class="menu-deroulant">
                    <span><img class="logo-menu" src="images/iconeMenu.png" alt="menu"></span>
                    <ul class="sous-menu">
                        <li><a href="index.php">Accueil</a></li>
                        <li class="menu-deroulant"><a href="catalogue.php">Nos produits</a>
                            <ul class="sous-menu-produits">
                                <!--Vérification des types de produits existants afin de les proposer 
                                dans le sous-menu et de pointer vers l'ancre de la page catalogue.php!-->
                                <?php foreach ($typesList as $typeItem) : ?>
                                <?php $type = $typeItem['type']; ?>
                                <li><a href="catalogue.php#<?php echo $type; ?>">Les <?php echo ucfirst($type); ?></a></li>
                                <?php endforeach; ?>
                            </ul></li>
                        <li><a href="quisommesnous.php">Qui sommes-nous</a></li>
                        <li><a href="ounoustrouver.php">Où nous trouver</a></li>
                        <li><a href="mailto:eaudelacite@gmail.com">Nous contacter</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!--<div class="chercher">
            <form method="get" action="">
                <input class="input-search" type="search" name="chercher" id="chercher" placeholder="chercher">
                <label for="chercher"><a href=""><img class="loupe" src="images/iconeLoupe.png" alt="loupe"></a></label>
            </form>
        </div>!-->
    </div>
    <h1>
        <img class="logo-site" src="images/logoSite.jpg" alt="L'eau de la cité"> 
    </h1>
    <div class="menu-droit">
        <!--Condition qui vérifie qu'il n'y est pas de session active et propose le lien de la page de connection !-->
        <?php if(!isset($_SESSION['LOGGED_USER'])) : ?>
            <div class="section-client">
                <a class="logo-compte" href="login.php"><img class="img-logo-compte" src="images/iconeUtilisateur.png" alt="compte utilisateur">Se connecter</a>
            </div>
            <!--Si une session est active on propose un menu déroulant avec des fonctionnalités selon s'il s'agit d'un utilisateur 
            ou d'un administrateur ce qui sera vérifié un peu plus bas !-->
                <?php elseif(isset($_SESSION['LOGGED_USER'])) : ?>
            <div class="menu-user">        
                <nav>
                    <ul>
                        <li class="menu-deroulant">
                            <span><img class="img-logo-login" src="images/iconeUtilisateur.png" alt="compte utilisateur"><?php echo $surname . ' ' . $name; ?></span>
                            <ul class="sous-menu">
                                <!--Si la session en cours est une session utilisateur un menu déroulant est affiché !-->
                                <?php if ($admin == 0) : ?>
                                    <li><a href="session.php">Mon profil</a></li>
                                    <!--<li><a href="">Mes commandes</a></li>!-->
                                    <li><a href="logout.php">Déconnexion</a></li>
                                <!--Si la session en cours est une session administrateur un autre type de menu déroulant est affiché !-->
                                <?php elseif ($admin == 1) : ?>
                                    <li><a href="products.php">Produits</a></li>
                                    <!--<li><a href="">Commandes</a></li>!-->
                                    <li><a href="logout.php">Déconnexion</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
        <!--<div class="panier">
            <a class="logo-panier" href="panier.php"><img class="img-logo-panier" src="images/iconeSac.png" alt="panier">Panier</a>
        </div>!-->
    </div>
</header>