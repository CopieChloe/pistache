<?php 

require_once('inc/header.php');

if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $req = "SELECT * FROM membre WHERE id_membre = :id";
    $resultat = $pdo->prepare($req);
    $resultat->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat->execute();

    if($resultat->rowCount() > 0) {
        $membre = $resultat->fetch();
        $req2 = "DELETE FROM membre WHERE id_membre = $membre[id_membre]";
        $resultat2 = $pdo->exec($req2);

        if($resultat !== FALSE) {
            $chemin_photoProfil_suppression = RACINE_SITE . 'assets/uploads/img/' . $membre['photoProfil'];

            if(file_exists($chemin_photoProfil_suppression) && $membre['photoProfil'] != 'default.png') {
                unlink($chemin_photoProfil_suppression);
            }

            header('location:' . URL . 'admin/gestion_membres.php');
        }
    } 
    else {
        header('location:' . URL . 'admin/gestion_membres.php');
    }
} 
else {
    header('location:' . URL . 'admin/gestion_membres.php');
}


?>