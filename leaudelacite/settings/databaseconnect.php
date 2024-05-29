<?php
/*paramètres de connexion à la base de donnée*/
    $servername = 'localhost';
    $dbname = 'leaudelacitetest';
    $username = 'root';
    $password = '';

    try{
        $mysqlClient = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
    }
?>