<?php
    session_start();
    require_once(__DIR__ . '/functions.php');
    require_once(__DIR__ . '/settings/databaseconnect.php');

    if(!isset($_SESSION['LOGGED_USER']['admin'])){
        redirectToUrl('index.php');
    }
    $req = $mysqlClient->query("SELECT product_id FROM products");
    $targetList = $req->fetchAll(PDO::FETCH_ASSOC);

    /*La super globale $_POST est stockée dans la variable $postData puis les valeurs sont controlées */
    $postData = $_POST;
    $target = $postData['target'];

    if (
        empty($postData['qte'])
        || empty($postData['title'])
        || empty($postData['description'])
        || empty($postData['price'])
        || trim(strip_tags($postData['qte'])) === ''
        || trim(strip_tags($postData['title'])) === ''
        || trim(strip_tags($postData['description'])) === ''
        || trim(strip_tags($postData['price'])) === ''
    ){
        echo '<p style = "color:#FF0000">Un champ est incorrect !</p>';
        return;
    }

    if (isset($_FILES['imgProduct']) && $_FILES['imgProduct']['error'] == 0)
    {
        if ($_FILES['imgProduct']['size'] > 1000000) {
            echo "L'envoi n'a pas pu être effectué, erreur ou image trop volumineuse";
            return;
        }
        $fileInfo = pathinfo($_FILES['imgProduct']['name']);
        $extension = $fileInfo['extension'];
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        if (!in_array($extension, $allowedExtensions)) {
            echo "L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée";
            return;
        }

        $path = __DIR__ . '/uploads/';
        if (!is_dir($path)) {
            echo "L'envoi n'a pas pu être effectué, le dossier uploads est manquant";
            return;
        }

        move_uploaded_file($_FILES['imgProduct']['tmp_name'], $path . basename($_FILES['imgProduct']['name']));
    }

    $qte = trim(strip_tags($postData['qte']));
    $title = trim(strip_tags($postData['title']));
    $description = trim(strip_tags($postData['description']));
    $price = trim(strip_tags($postData['price']));
    $type = $postData['type'];
    $imgProduct = $_FILES['imgProduct']['name'];
    $enabled = $postData['enable'];

    /*S'il s'agit d'un nouveau produit, il va être ajouté à la base de donnée */
    if($target == "new"){
        $addProduct = $mysqlClient->prepare('INSERT INTO products(qteStock, title, description, price, type, imgProduct, is_enabled) VALUES (:qteStock, :title, :description, :price, :type, :imgProduct, :is_enabled)');
        $addProduct->execute([
            'qteStock' => $qte,
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'type' => $type,
            'imgProduct' => $imgProduct,
            'is_enabled' => $enabled
        ]);
    } else{
        /*Si c'est un produit déjà existant qui a été selectionné, dans ce cas ses valeurs sont mises à jour dans la BDD */
        $changeProduct = $mysqlClient->prepare("UPDATE products 
            SET qteStock = :qteStock, title = :title, description = :description, price = :price, type = :type, imgProduct = :imgProduct, is_enabled = :is_enabled 
            WHERE product_id = :product_id");
        $changeProduct->execute([
            'qteStock' => $qte,
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'type' => $type,
            'imgProduct' => $imgProduct,
            'is_enabled' => $enabled,
            'product_id' => $target
        ]);
    }
    redirectToUrl('products.php');
?>