<?php
    session_start();
    require_once(__DIR__ . '/settings/databaseconnect.php');
    require_once(__DIR__ . '/functions.php');

    /*Récupération du 'title' dans l'URL envoyé depuis le catalogue et à partir du 'title', 
    récupération des informations du produit dans la BDD */
    if(isset($_GET['title'])) {
        $title = $_GET['title'];
        $req = $mysqlClient->prepare("SELECT * FROM products WHERE title = ?");
        $req->execute([$title]);
        $product = $req->fetch();
        $productid = $product['product_id'];
    } else {
        redirectToUrl('catalogue.php');
    }

    if(isset($_POST['delete_product'])) {
        $del = $mysqlClient->prepare("DELETE FROM products WHERE product_id = ?");
        $del->execute([$productid]);
        redirectToUrl("catalogue.php");
    }
?>

<?php require_once(__DIR__ . '/header.php'); ?>
<!--Création de la page de présentation du produit en fonction des données correspondantes au 'title' passé dans l'URL!-->
<h3 class="titre-fiche"><?php echo $product['title']; ?></h3></br>
<section class="fiche-produit">
    <div class="fiche-text">
        <p class="description-fiche">
            <?php echo $product['description']; ?>
        </p>
    </div>
    <div class="fiche-img">
        <img class="imgcat" src="uploads/<?php echo $product['imgProduct']; ?>" alt="<?php echo $product['title']; ?>"></br>
        <div>
            <?php echo $product['price'] . ' €'; ?>
            <!--Dans la partie ci-dessous, j'intègre un bouton qui permet 
            de supprimer le produit de la BDD et qui n'apparaît uniquement qu'à un administrateur!-->
            <?php if(isset($_SESSION['LOGGED_USER']['admin'])) : ?>
                <form action="" method="POST">
                    <input type="hidden" name="delete_product" value="1">
                    <input type="submit" value="Supprimer">
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once(__DIR__ . '/footer.php'); ?>