<?php

require_once(__DIR__ . '/settings/databaseconnect.php');
require_once(__DIR__ . '/functions.php');

/*La variable $postData récupère les données de la super globale $_POST puis est soumise à 
plusieurs test afin d'éviter les champs vides ou les injections de code dans les inputs */
$postData = $_POST;

if (
    empty($postData['name'])
    || empty($postData['prenom'])
    || empty($postData['email'])
    || empty($postData['password'])
    || empty($postData['confpassword'])
    || empty($postData['tel'])
    || empty($postData['adresse'])
    || empty($postData['ville'])
    || empty($postData['code-postal'])
    || empty($postData['pays'])
    || trim(strip_tags($postData['name'])) === ''
    || trim(strip_tags($postData['prenom'])) === ''
    || trim(strip_tags($postData['email'])) === ''
    || trim(strip_tags($postData['password'])) === ''
    || trim(strip_tags($postData['confpassword'])) === ''
    || trim(strip_tags($postData['tel'])) === ''
    || trim(strip_tags($postData['adresse'])) === ''
    || trim(strip_tags($postData['ville'])) === ''
    || trim(strip_tags($postData['code-postal'])) === ''
    || trim(strip_tags($postData['pays'])) === ''
    || $postData['password'] !== $postData['confpassword']
){
    echo '<p style = "color:#FF0000">Un champ est incorrect !</p>';
    return;
}

$name = trim(strip_tags($postData['name']));
$prenom = trim(strip_tags($postData['prenom']));
$mail = trim(strip_tags($postData['email']));
$password = trim(strip_tags($postData['password']));
$tel = trim(strip_tags($postData['tel']));
$adresse = trim(strip_tags($postData['adresse']));
$adressecomp = trim(strip_tags($postData['complement-adresse']));
$pays = trim(strip_tags($postData['pays']));
$gender = trim(strip_tags($postData['civilite']));
$city = trim(strip_tags($postData['ville']));
$cp = trim(strip_tags($postData['code-postal']));

/*Maintenant que les données ont été vérifiées elles peuvent être stockées dans la BDD */
$addUser = $mysqlClient->prepare('INSERT INTO users(name, surname, gender, email, password, tel, address, addresscomp, country, city, cp) VALUES (:name, :surname, :gender, :email, :password, :tel, :address, :addresscomp, :country, :city, :cp)');
$addUser->execute([
    'name' => $name,
    'surname' => $prenom,
    'gender' => $gender,
    'email' => $mail,
    'password' => $password,
    'tel' => $tel,
    'address' => $adresse,
    'addresscomp' => $adressecomp,
    'country' => $pays,
    'city' => $city,
    'cp' => $cp
]);

redirectToUrl('login.php');