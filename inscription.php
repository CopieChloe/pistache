<?php require_once("inc/header.php"); 

$page ='Inscription';

if($_POST) {
  debug($_POST, 2);

  if(!empty($_POST['pseudo'])) {
    $verif_pseudo = preg_match('#^[a-zA-Z0-9-._]{3,20}$#', $_POST['pseudo']);
    #définit les caractères autorisés, 
    #attend 2 arguments : regex (expression régulière), str/var à checker
    #bool : true=succès, false=échec

    if(!$verif_pseudo) {
      $msg_erreur .= "<div class='alert alert-danger'>Votre pseudo doit comporter de 3 à 20 caractères (majuscules, minuscules, chiffres et signes (. et _ et - acceptés).</div>";
    }

  } else {
    $msg_erreur .= "<div class='alert alert-danger'>Veuillez saisir un pseudo valide.</div>";
  }

  #vérification mdp 
  if (!empty($_POST['mdp'])) 
  {
      $verif_mdp = preg_match('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*\'\?$@%_])([-+!*\?$\'@%_\w]{6,15})$#', $_POST['mdp']); // le mdp doit contenir: 6 caractère min et 15 max + 1 MAJ + 1 MIN + 1 chiffre + 1 caractère spécial

      if(!$verif_mdp) {
        $msg_erreur .= "<div class='alert alert-danger'>Votre mdp doit comporter entre 6 et 15 caractères dont 1 maj, 1 min, 1 chiffre et 1 caractère spécial.</div>";
      }

  } else {
    $msg_erreur .= "<div class='alert alert-danger'>Veuillez saisir un mdp valide.</div>";
  }

  #vérification mail
  if(!empty($_POST['email'])) {
    $verif_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    #filter_var vérifie une string
    #prend 2 arguments : string, méthode
    #retourne un bool

    $dom_interdit = [
      'mailinator.com',
      'yopmail.com',
      'mail.com'
    ];

    $dom_email = explode('@', $_POST['email']);
    #explose une str/var à partir de l'élément choisi en 1er argument

    if(!$verif_email || in_array($dom_email[1], $dom_interdit)) {
      $msg_erreur .= "<div class='alert alert-danger'>Veuillez saisir un email valide.</div>";
    }
  } 
  else {
    $msg_erreur .= "<div class='alert alert-danger'>Veuillez saisir un email valide.</div>";
  }

  # autres vérifs possibles : 
  
    if(empty($msg_erreur)) {
      # vérif si pseudo libre (possible pour email également) : 
        $resultat = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
        $resultat->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $resultat->execute();

        if($resultat->rowCount() > 0 ) {
          $msg_erreur .= "<div class='alert alert-danger'>Pseudo " . $_POST['pseudo'] . "pas dispo, veuillez en choisir un autre.</div>";
        } else {
          $resultat = $pdo->prepare("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, 0)");
          $mdp_crypte = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
            # password_hash sécurise l'enregistrement du mdp en bdd
            # prend 2 arguments : élt à hacher, méthodologie de hashage
          
          $resultat->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
          $resultat->bindValue(':mdp', $mdp_crypte, PDO::PARAM_STR);
          $resultat->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
          $resultat->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
          $resultat->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
          $resultat->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
          $resultat->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
          $resultat->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);

          $resultat->bindValue(':code_postal', $_POST['code_postal'], PDO::PARAM_INT);

          if($resultat->execute()) {
            header('location: connexion.php');
          }

        }
    }

}

# on veut réafficher les valeurs saisies en cas de rechargement de la page 
# et erreur d'inscription :
# condition : si on reçoit du post, alors variable contient valeur envoyée, sinon variable vide :
$pseudo = (isset($_POST['pseudo'])) ? $_POST['pseudo'] : '';
$nom = (isset($_POST['nom'])) ? $_POST['nom'] : '';
$prenom = (isset($_POST['prenom'])) ? $_POST['prenom'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$ville = (isset($_POST['ville'])) ? $_POST['ville'] : '';
$code_postal = (isset($_POST['code_postal'])) ? $_POST['code_postal'] : '';
$adresse = (isset($_POST['adresse'])) ? $_POST['adresse'] : '';

?>

        
<h1><?= $page ?></h1>
<p class="lead">Super e-commerce</p>

<form method="post">
<?= $msg_erreur ?>
<div class="form-group">
    
    <input name="pseudo" value="<?= $pseudo ?>" type="text" class="form-control" id="pseudo" aria-describedby="PseudoHelp" placeholder="Pseudo">
  </div>
  <div class="form-group">
    <input name="mdp" type="mdp" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
  </div>
  <div class="form-group">
    <input name="nom" value="<?= $nom ?>" type="text" class="form-control" id="nom" placeholder="Nom">
  </div>
  <div class="form-group">
    <input name="prenom" value="<?= $prenom ?>" type="text" class="form-control" id="prenom" placeholder="Prénom">
  </div>
  <div class="form-group">
    <input name="email" value="<?= $email ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
  <select name="civilite" multiple class="form-control" id="civilite">
        <option value="f">Femme</option>
        <option value="m">Homme</option>
        <option value="o">Autre</option>
    </select>
  </div>
  <div class="form-group">
    <input name="ville" value="<?= $ville ?>" type="text" class="form-control" id="ville" placeholder="Ville">
  </div>
  <div class="form-group">
    <input name="code_postal" value="<?= $code_postal ?>" type="text" class="form-control" id="code_postal" placeholder="Code postal">
  </div>
  <div class="form-group">
    <input type="text" name="adresse" value="<?= $adresse ?>" class="form-control" id="adresse" placeholder="Adresse">
    </textarea>
  </div>

  <button type="submit" class="btn btn-info">Inscription</button>
</form>
   

<?php require_once("inc/footer.php"); ?>