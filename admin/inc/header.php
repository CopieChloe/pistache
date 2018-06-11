<?php 

require_once("../inc/init.php");

if(!userAdmin()) {
    header('location:' . URL . 'index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Backoffice maboutique.com</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <!-- CSS PERSO -->
    <link href="assets/css/style.css" rel="stylesheet">

  </head>
  </head>

  <body>
    <nav class="navbar navbar-toggleable-md navbar-dark bg-dark fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">Backoffice Maboutique.com</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="<?= URL ?>admin/">Statistiques<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= URL ?>">Accès au site</a>
          </li>
          <li class="nav-item">
          <!-- URL à faire évoluer!!! -->
            <a class="nav-link" href="<?= URL ?>index.php?a=deconnect">Déconnexion</a>
          </li>
        </ul>
      </div>
    </nav>        
    
<div class="container-fluid">
<div class="row">
<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
    <ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link active" href="<?= URL ?>admin/gestion_produit.php">Gestion produit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="<?= URL ?>admin/liste_produit.php">Liste des produits</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="<?= URL ?>admin/gestion_membres.php">Gestion des membres</a>
    </li>
    </ul>
</nav>

<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">