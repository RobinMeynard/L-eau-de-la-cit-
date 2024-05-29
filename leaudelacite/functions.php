<?php
/*La fonction pour renvoyer sur une URL particulière après une action*/
function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}
?>