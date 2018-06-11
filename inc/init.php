<?php
    //Ouverture de la session
    session_start();
    $dsn = 'mysql:host=localhost; dbname=boutique';
    $login = 'root';
    $pwd = '';
    $attribute = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $pdo = new PDO($dsn, $login, $pwd, $attribute);

    // Definition de conatante
    define('URL', 'http://localhost/php/6-boutique/');
    // on définit l'URL du site dans une constante afin de renvoyer automatiquement l'URL partour
    //sans avoir besoin de modifier un à un les liens
    define('RACINE_SITE', $_SERVER['DOCUMENT_ROOT'] . '/php/6-boutique/'); 
    # superglobale $_SERVER définit racine du site

    // Déclaration de variables
    $msg_erreur = '';
    $page = '';
    $contenu = '';

    require_once('fonction.php');

    //debug($_SERVER);

?>

