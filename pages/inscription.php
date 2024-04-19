<?php
include '../path.php';
include ROOT_PATH . '/components/header.php';
include_once('../tools/functions.php');

if(isset($_POST['submit'])){
  $nom = htmlspecialchars($_POST['nom']);
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $role = htmlspecialchars($_POST['role']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);
 
  $error =[];

 //  traitement formulaire d'inscription
 if(empty($nom)){
   $error['nom']= 'Ce champs est requis';
 } 

 if(empty($pseudo)){
  $error['pseudo']= 'Ce champs est requis';
} 

if(empty($role)){
  $error['role']= 'Ce champs est requis';
} 

if(empty($email)){
  $error['email']= 'Ce champs est requis';
} elseif(filter_var($email, FILTER_VALIDATE_EMAIL)==false){
  $error['email'] = "Le formail de l'email est incorrecte";
}

if(empty($password)){
  $error['password']= 'Le mot de passe est requis';
} elseif($password != $passwordConfirm)
  

if(empty($passwordConfirm)){
  $error['passwordConfirm']= 'Le mot de passe de confirmation est requis';
} elseif($passwordConfirm != $password){
  $error['passwordConfirm'] = 'les mots de passes doivent etre identique';
}

if(empty($error)){
  $password = password_hash($password, PASSWORD_BCRYPT);

  $pdo = getPdo();
  $req="INSERT INTO users(nom, pseudo, email, password, role)VALUES(:nom, :pseudo, :email, :password, :role)";
  $stmt = $pdo->prepare($req);
  $stmt->bindValue(':nom', $nom);
  $stmt->bindValue(':pseudo', $pseudo);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':password', $password);
  $stmt->bindValue(':role', $role);
  $stmt->execute();
}
  }

?>

<div class="contact">
  <h1>Inscription</h1>
  <form method="post" action="<?= $_SERVER['PHP_SELF']?>" class="contact_us">
    <label for="nom">Votre nom:</label>
    <input type="text" name="nom" id="nom">
    <?php if(isset($error['nom'])):?>
      <p style="color:red; font-size: 1.3rem;"><?=($error['nom']);?></p>
    <?php endif;?>
    <label for="pseudo">Votre pseudo:</label>
    <input type="text" name="pseudo" id="pseudo">
    <?php if(isset($error['pseudo'])):?>
      <p style="color:red; font-size: 1.3rem;"><?=($error['pseudo']);?></p>
    <?php endif;?>
    <label for="role">Role:</label>
    <select name="role" id="role">
      <option value="" name="role" id="role">Selectionnez un role</option>
      <option value="adminnistrateur">Administrateur</option>
      <option value="rédacteur">Rédacteur</option>
      <option value="visiteur">Lecteur</option>
    </select>
    <?php if(isset($error['role'])):?>
      <p style="color:red; font-size: 1.3rem;"><?=($error['role']);?></p>
    <?php endif;?>
    <label for="email">Votre email:</label>
    <input type="text" name="email" id="email">
    <?php if(isset($error['email'])):?>
      <p style="color:red; font-size: 1.3rem;"><?=($error['email']);?></p>
    <?php endif;?>
    <label for="pawword">Votre mot de passe:</label>
    <input type="password" name="password" id="password">
    <?php if(isset($error['password'])):?>
      <p style="color:red; font-size: 1.3rem;"><?=($error['password']);?></p>
    <?php endif;?>
    <label for="pawword">Confirmez votre mot de passe:</label>
    <input type="password" name="passwordConfirm" id="password">
    <?php if(isset($error['passwordConfirm'])):?>
      <p style="color:red; font-size: 1.3rem;"><?=($error['passwordConfirm']);?></p>
    <?php endif;?>
    <input type="submit" name="submit" id="submit" value="Valider">
  </form>
  <p>Avez-vous déjà un compte?</p>
  <a href="<?= BASE_URL?>/pages/log.php">Connectez-vous</a> 
</div>