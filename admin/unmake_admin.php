<?php 

require_once('inc/header.php');

// au clic, la bdd est updatée : 
// membre > statut = 0

$sql ='UPDATE membre SET statut=0 WHERE id_membre = :id';


$resultat = $pdo->prepare($sql);
$resultat->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$resultat->execute();

?>

<div>Member has been removed admin status - not very nice of you :/</div>

<div><a href="gestion_membres.php" class="btn btn-info">Back to members list</a></div>


<?php 

require_once('inc/footer.php');

?>