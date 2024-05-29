<?php
session_start();
require_once(__DIR__ . '/settings/databaseconnect.php');

$reqTypes = $mysqlClient->query("SELECT DISTINCT type FROM products");
$typesList = $reqTypes->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once(__DIR__ . '/header.php'); ?>
<section class="catalogue">
    <!--Vérification de l'existence de produit dans la base de donnée "products" !-->
    <?php if (!empty($typesList)) : ?>
        <!--La première boucle permet de créer les sous-parties du catalogue en fonction des types de produits enregistrés dans la base de donnée !-->
        <?php foreach ($typesList as $typeItem) : ?>
            <?php $type = $typeItem['type']; ?>
            <h3 id="<?php echo ucfirst($type); ?>">Nos <?php echo ucfirst($type); ?></h3>
            <div class="<?php echo $type; ?>">
                <?php
                    $reqProduct = $mysqlClient->query("SELECT title, imgProduct FROM products WHERE type = '$type' AND is_enabled = 1 GROUP BY title");
                    $products = $reqProduct->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <!--La deuxième boucle affiche chaque produit correspondant à chaque type de produit existant !-->
                <?php foreach ($products as $product) : ?>
                    <!--Le formulaire ci-dessous va permettre de générer la fiche produit en fonction du produit sur lequel l'utilisateur aura cliqué, 
                    la vignette du produit est en fait un boutton qui va envoyer le 'title' du produit dans l'URL pour le récupérer dans la page productSheet.php !-->
                    <form action="productSheet.php" method="POST"></form>
                        <button type="submit" name="fiche-produit" title="Envoyer">
                            <a href="productSheet.php?title=<?php echo urlencode($product['title']); ?>">
                                <img class="imgcat" src="uploads/<?php echo $product['imgProduct']; ?>" alt="<?php echo $product['title']; ?>">
                            </a>
                        </button>
                    </form>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
<?php require_once(__DIR__ . '/footer.php'); ?>