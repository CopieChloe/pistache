<?php require_once("inc/header.php"); 

$page ='Connexion';

if ($_POST) {
  // debug($_POST);
  $req = "SELECT * FROM membre WHERE pseudo = :pseudo";

  $resultat = $pdo->prepare($req);
  $resultat->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
  $resultat->execute();

  if($resultat->rowCount() > 0) {
    $membre = $resultat->fetch();

    // debug($membre);

    if (password_verify($_POST['mdp'], $membre['mdp'])) {
      # liée à password_hash, permet de vérif la correspondance
      # prend 2 arguments : mdp venant du formulaire, mdp en bdd


        foreach ($membre as $key => $value) {
          if($key != "mdp") {
            $_SESSION['membre'][$key] = $value;

            header('location:profil.php');
          }
        }
        // debug($_SESSION);
    } else {
      $msg_erreur .= "<div class='alert alert-danger'>Erreur d'identification, veuillez réessayer.</div>";
    }
  }
  else {
    $msg_erreur .= "<div class='alert alert-danger'>Erreur d'identification, veuillez réessayer.</div>";

}
}
?>

        
<h1><?= $page ?></h1>
<p class="lead">Super e-commerce</p>

<form method="post">
<?= $msg_erreur ?>
  <div class="form-group">
    <label for="pseudo">Pseudo</label>
    <input name="pseudo" type="text" class="form-control" id="pseudo">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="password">Mot de passe</label>
    <input name="mdp" type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-info">Connexion</button>
</form>
   

<?php require_once("inc/footer.php"); ?>