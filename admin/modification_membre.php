<!-- 
Afficher tous les membres 
Possibilité de supprimer les membres
Possibilité d'ajouter d'autre     -->

<?php 

require_once('inc/header.php');

$resultat = $pdo->query("SELECT * FROM membre");
$membres = $resultat->fetchAll();

$contenu .= "<table class='table'>";
$contenu .= "<thead><tr>";

for ($i = 0; $i < $resultat->columnCount(); $i++) {
    $champs = $resultat->getColumnMeta($i);
    $contenu .= "<th>" . $champs['name'] . "</th>";
}
$contenu .= "</tr></thead><tbody>";
$contenu .= "</tr></thead><tbody>";
foreach ($membres as $membre) {
    $contenu .= "<tr>";
    foreach ($membre as $key => $value) {
        if ($key == 'photoProfil') {
            $contenu .= '<td><img height="100" src="' . URL . 'assets/uploads/img/' . $membre['photoProfil'] . '"/></td>';
        }  else {
            $contenu .= "<td>" . $value . "</td>";
        }
    }

    $contenu .= "<td><a href='" . URL . "admin/make_admin.php?id=" . $membre['id_membre'] . "' class='btn btn-success'>Donner statut admin</a></td>";
    $contenu .= "<td><a href='" . URL . "admin/unmake_admin.php?id=" . $membre['id_membre'] . "' class='btn btn-warning'>Retirer statut admin</a></td>";
    $contenu .= "<td><a href='" . URL . "admin/suppression_membre.php?id=" . $membre['id_membre'] . "' class='btn btn-danger'>Supprimer</a></td>";
    $contenu .= "</tr>";
}   

$contenu .= "</tbody></table>";

// debug($champs);
?>


<h1>Liste des membres</h1>

<?= $contenu ?>

<?php 

require_once('inc/footer.php');

?>