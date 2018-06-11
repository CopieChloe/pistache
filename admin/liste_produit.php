<?php 

require_once('inc/header.php');

$resultat = $pdo->query("SELECT * FROM produit");
$produits = $resultat->fetchAll();

$contenu .= "<table class='table'>";
$contenu .= "<thead><tr>";

for ($i = 0; $i < $resultat->columnCount(); $i++) {
    $champs = $resultat->getColumnMeta($i);
    $contenu .= "<th>" . $champs['name'] . "</th>";
}
$contenu .= "</tr></thead><tbody>";
$contenu .= "</tr></thead><tbody>";
foreach ($produits as $produit) {
    $contenu .= "<tr>";
    foreach ($produit as $key => $value) {
        if ($key == 'photo') {
            $contenu .= '<td><img height="100" src="' . URL . 'assets/uploads/img/' . $produit['photo'] . '"/></td>';
        } else {
            $contenu .= "<td>" . $value . "</td>";
        }
    }
    $contenu .= "<td><a href='" . URL . "admin/gestion_produit.php?id=" . $produit['id_produit'] . "'>Modifier</a></td>";
    $contenu .= "<td><a href='" . URL . "admin/suppression_produit.php?id=" . $produit['id_produit'] . "'>Supprimer</a></td>";
    $contenu .= "</tr>";
}
$contenu .= "</tbody></table>";

// debug($champs);

?>

<h1>Liste des produits</h1>

<?= $contenu ?>

<?php 

require_once('inc/footer.php');

?>