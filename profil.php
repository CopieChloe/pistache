<?php require_once("inc/header.php"); 

$page ='Bienvenue ' . $_SESSION['membre']['pseudo'] . ' !';

if(!userConnect()) {
    header('location:connexion.php');
    exit;
}

?>

<h1><?= $page ?></h1>
<p class="lead">Voici vos informations :</p>
<ul>
    <li>Votre nom : <?= $_SESSION['membre']['nom']?></li>
    <li>Votre prénom : <?= $_SESSION['membre']['prenom']?></li>
    <li>Votre email : <?= $_SESSION['membre']['email']?></li>
</ul>



<?php require_once("inc/footer.php"); ?>