<?php
    session_start();
    require_once(__DIR__ . '/settings/databaseconnect.php');
    require_once(__DIR__ . '/functions.php');
    
    /*Condition qui vérifie que la personne qui vient sur la page est bien administrateur, 
    dans le cas contraire, c'est un retour à la page index.php*/
    if(!isset($_SESSION['LOGGED_USER']['admin'])){
        redirectToUrl('index.php');
    }
    $req = $mysqlClient->query("SELECT product_id,title FROM products ORDER BY title");
    $targetList = $req->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once(__DIR__ . '/header.php'); ?>
<section>
    <!--Formulaire de création de nouveaux produits!-->
    <form class="inscription" action="submitProduct.php" method="POST" enctype="multipart/form-data">
        <fieldset class="create-product">
            <legend>Ajouter ou modifier un produit :</legend>
            <div>
                <label for="target">Produit : </label>
                <select name="target" id="target">
                    <option value="new">Nouveau produit</option>
                    <?php foreach ($targetList as $target) : ?>
                        <!--Affichage des produits déjà existants ce qui permet de les modifier 
                        avec un UPDATE plutôt que de créer un nouveau produit!-->
                        <option value="<?php echo htmlspecialchars($target['product_id']); ?>">
                            <?php echo htmlspecialchars($target['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="qte">Quantité : </label>
                <input class="qte" type="text" name="qte" id="qte">
            </div>
            <div>
                <label for="title">Nom : </label>
                <input type="text" name="title" id="title">
                <label for="type">Type : </label>
                <select name="type" id="type">
                    <option value="Parfums">Parfum</option>
                    <option value="Laits">Lait</option>
                    <option value="Crèmes">Crème</option>
                    <option value="Huiles">Huile</option>
                    <option value="Bougies">Bougie</option>
                    <option value="Baumes">Baume</option>
                    <option value="Élixirs">Élixir</option>
                </select>
            </div>
            <div class="desc">
                <label for="description">Description de l'article : </label>
                <textarea class="description" name="description" id="description" rows="5"></textarea>
            </div>
            <div>
                <label for="imgProduct">Photo du produit</label>
                <input type="file" id="imgProduct" name="imgProduct" />
            </div>
            <div class="bottom-create">
                <div>
                    <label for="price">Prix en € : </label>
                    <input class="qte" type="text" name="price" id="price">
                </div>
                <div>
                    <label for="enable">disponibilité : </label>
                    <select name="enable" id="enable">
                        <option value="1">Disponible</option>
                        <option value="0">Indisponible</option>
                    </select>
                </div>
            </div>
            <div>
                <input class="submit-sign-up" type="submit" value="Valider">
            </div>
        </fieldset>
    </form>
</section>
    <?php require_once(__DIR__ . '/footer.php'); ?>