<?php
    session_start();
?>

    <?php require_once(__DIR__ . '/header.php'); ?>
        <div class="section">
            <!--Page d'accueil!-->
            <section class="texte-presentation">
                <p class="transbox">
                    L’eau de la Cité est née d’une idée lors d’une 
                    réunion de famille, d’une passion pour un des 
                    plus beaux monuments de France ainsi que d’une 
                    fierté d’être née ici, dans cette merveilleuse 
                    région aux essences méditerranéennes & aux agrumes.
                </p>
            </section>
            <section class="presentation-produits">
                <!--Insertion des images pour le caroussel réalisé en CSS!-->
                <div class="caroussel-produits">
                    <img class="photo-produit-accueil" src="images/eaudelacite.png" alt="Photo de présentation de l'eau de la cité">
                    <img class="photo-produit-accueil" src="images/eaudelacite.png" alt="Photo de présentation de l'eau de la cité">
                    <img class="photo-produit-accueil" src="images/eaudelacite.png" alt="Photo de présentation de l'eau de la cité">
                    <img class="photo-produit-accueil" src="images/eaudelacite.png" alt="Photo de présentation de l'eau de la cité">
                </div>
            </section>
        </div>
        <?php require_once(__DIR__ . '/footer.php'); ?>
    </body>
</php>