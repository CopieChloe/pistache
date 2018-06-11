<?php require_once("inc/header.php");

// debug($_POST);
// debug($_FILES);

if($_POST)
{
    if(!empty($_FILES['photo']['name'])) // je regarde si une photo est uploadée
    {
        // je donne une référence aléatoire unique au nom de ma photo
        $nom_photo = $_POST['reference'] . '_' . time() . '_' . rand(1,999) . '_' . $_FILES['photo']['name'];

        // on enregistre dans cette variable le chemin definitif de ma photo
        $chemin_photo = RACINE_SITE . 'assets/uploads/img/' . $nom_photo;

        //Vérification de la taille de ma photo
        if($_FILES['photo']['size'] > 2000000)
        {
            $msg_erreur .=  "<div class='alert alert-danger'>Veuillez sélectionner un fichier de 2Mo maximum.</div>";
        }

        // Vérification du type de fichier
        $tab_type = ['image/jpeg','image/png','image/gif'];
        if(!in_array($_FILES['photo']['type'],$tab_type)) // on regarde que le type de photo envoyer avec $_FILES est conforme aux types rentrés dans notre ARRAY
        {
             $msg_erreur .=  "<div class='alert alert-danger'>Veuillez sélectionner un fichier JPEG/JPG, PNG ou GIF.</div>";
        }
    }
    else
    {
        $nom_photo = 'default.png';
    }
    // VERIFICATIONS DES AUTRES CHAMPS : champs remplis, nom de caractères, informations numérique en stock/prix ...

    if(empty($msg_erreur))
    {
        if(!empty($_POST['id_produit'])) // on enregistre la modif
        {
            $resultat = $pdo->prepare("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)");

            $resultat->bindValue(':id_produit', $_POST['id_produit'], PDO::PARAM_INT);

            $nom_photo = (isset($_POST['photo_actuelle'])) ? $_POST['photo_actuelle'] : '';
            
        }
        else // on enregistre en BDD pour la première fois
        {
                $resultat = $pdo->prepare("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES (:reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)");
        }

        $resultat->bindValue(':reference', $_POST['reference'], PDO::PARAM_STR);
        $resultat->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
        $resultat->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $resultat->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $resultat->bindValue(':couleur', $_POST['couleur'], PDO::PARAM_STR);
        $resultat->bindValue(':taille', $_POST['taille'], PDO::PARAM_STR);
        $resultat->bindValue(':public', $_POST['public'], PDO::PARAM_STR);
        $resultat->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
        $resultat->bindValue(':stock', $_POST['stock'], PDO::PARAM_INT);
        $resultat->bindValue(':photo', $nom_photo, PDO::PARAM_STR);

        if($resultat->execute()) // si la requête est bien enregistré en BDD
        {
            if(!empty($_FILES['photo']['name']))
            {
                copy($_FILES['photo']['tmp_name'], $chemin_photo);
            }
            
        }
    }
}

if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET["id"]))
// Vérification si il existe le GET 'id' + il est rempli + c est un chiffre
{
    $req = "SELECT * FROM produit WHERE id_produit = :id";
    $resultat = $pdo->prepare($req);
    $resultat->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat->execute();

    if($resultat->rowCount() > 0)
    {
        $produit_actuel = $resultat->fetch();
    }
}

$reference = (isset($produit_actuel)) ? $produit_actuel['reference'] : '';
$categorie = (isset($produit_actuel)) ? $produit_actuel['categorie'] : '';
$titre = (isset($produit_actuel)) ? $produit_actuel['titre'] : '';
$description = (isset($produit_actuel)) ? $produit_actuel['description'] : '';
$couleur = (isset($produit_actuel)) ? $produit_actuel['couleur'] : '';
$taille = (isset($produit_actuel)) ? $produit_actuel['taille'] : '';
$public = (isset($produit_actuel)) ? $produit_actuel['public'] : '';
$photo = (isset($produit_actuel)) ? $produit_actuel['photo'] : '';
$prix = (isset($produit_actuel)) ? $produit_actuel['prix'] : '';
$stock = (isset($produit_actuel)) ? $produit_actuel['stock'] : '';

$action = (isset($produit_actuel)) ? 'Modifier' : 'Ajouter';
$id_produit = (isset($produit_actuel)) ?  $produit_actuel['id_produit'] : '';

?>

<h1><?= $action ?> un produit</h1>

<form method="post" enctype="multipart/form-data">

    <?= $msg_erreur ?>

    <input type="hidden" name="id_produit" value="<?= $id_produit?>">

    <div class="form-group">
        <input type="text" class="form-control" name= "reference" placeholder="Réference produit" value='<?= $reference ?>'>
    </div>
    <div class="form-group">
    <input type="text" class='form-control' name='categorie' placeholder='Catégorie produit' value='<?= $categorie ?>'>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name= "titre" placeholder="Titre du produit" value='<?= $titre ?>'>
    </div>
    <div class="form-group">
        <textarea class="form-control" name="description" placeholder="Description du produit" cols="30" rows="10" ><?= $description ?></textarea>
    </div>
    <div class="form-group">
        <label for="couleur">Couleur</label>
          <select class="form-control" id='couleur' name="couleur">
            <option <?php if($couleur == 'Noir'){echo 'selected';}?> >Noir</option>
            <option <?php if($couleur == 'Blanc'){echo 'selected';}?>>Blanc</option>
            <option <?php if($couleur == 'Bleu'){echo 'selected';}?>>Bleu</option>
            <option <?php if($couleur == 'Rouge'){echo 'selected';}?>>Rouge</option>
            <option <?php if($couleur == 'Jaune'){echo 'selected';}?>>Jaune</option>
            <option <?php if($couleur == 'Vert'){echo 'selected';}?>>Vert</option>
            <option <?php if($couleur == 'Violet'){echo 'selected';}?>>Violet</option>
            <option <?php if($couleur == 'Moutarde'){echo 'selected';}?>>Moutarde</option>
            <option <?php if($couleur == 'Rose'){echo 'selected';}?>>Rose</option>
            <option <?php if($couleur == 'Saumon'){echo 'selected';}?>>Saumon</option>
    </select>
    </div>
    <div class="form-group">
        <label for="taille">Taille</label>
          <select class="form-control" id="taille" name="taille">
            <option <?php if($taille == 'XS'){echo 'selected';}?>>XS</option>
            <option <?php if($taille == 'S'){echo 'selected';}?>>S</option>
            <option <?php if($taille == 'M'){echo 'selected';}?>>M</option>
            <option <?php if($taille == 'L'){echo 'selected';}?>>L</option>
            <option <?php if($taille == 'XL'){echo 'selected';}?>>XL</option>
    </select>
    </div>
    <div class="form-group">
        <label for="public">Public</label>
          <select class="form-control" id="public" name="public" value='<?= $public ?>'>
            <option <?php if($public == 'homme'){echo 'selected';}?> value="homme">Homme</option>
            <option <?php if($public == 'femme'){echo 'selected';}?> value="femme">Femme</option>
            <option <?php if($public == 'mixte'){echo 'selected';}?> value="mixte">Mixte</option>
    </select>
    </div>
    <div class="form-group">
        <label for="photo">Photo produit</label>
        <input type="file" class="form-control-file" id="photo" name="photo">
        <?php
            if(isset($produit_actuel)) // si je modifie un produit
            {
                echo "<input name='photo_actuelle' value=" . $photo ."type='hidden'>";

                echo "<img style='width:25%;' src='" .URL . "assets/uploads/img/" . $photo . "'>";
            }
        ?>
    </div>
    <div class="form-group">
    <input type="text" class='form-control' name='prix' placeholder='Prix du produit' value='<?= $prix ?>'>
    <!-- ALERTE : si FLOAT en BDD , alors le type est texte -->
    </div>
    <div class="form-group">
    <input type="text" class='form-control' name='stock' placeholder='Stock du produit'value='<?= $stock ?>'>
    </div>
   
    <input class="btn btn-primary" type="submit" value=<?= $action ?>>
</form>

<?php require_once("inc/footer.php"); ?>