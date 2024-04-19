<?php
include '../path.php';
include ROOT_PATH . '/components/header.php';

include_once('../tools/functions.php');


if(isset($_POST['submit'])){
  $name = htmlspecialchars($_POST['nom']);
  $prenom = htmlspecialchars($_POST['prenom']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);
  $error =[];

  if(empty($name)){
    $error['nom'] = "Veuillez entrer votre nom";
    
  }


  if(empty($prenom)){
    $error['prenom'] = 'Veuillez entrer votre prénon';
    
  }

  if(empty($email)){
    $error['email'] = "L'email doit etre saisi";
  }

  if(empty($message)){
    $error['message'] = 'Veuillez saisir votre message';
  }

  if(empty($error)){
    $pdo = getPdo();
    $req = "INSERT INTO contact(nom, prenom, email, message)VALUES(:nom, :prenom, :email, :message)";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':nom', $name);
    $stmt->bindValue(':prenom', $prenom);
    $stmt->bindValue(':email',$email);
    $stmt->bindValue(':message',$message);
    $stmt->execute();
  }
}
?>

<div class="contact">
  <h1>Contactez-nous</h1>
  <form method="post" action="" class="contact_us">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" id="nom">
    <?php if(isset($error['nom'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['nom'];?></p>
    <?php endif; ?>
    <label for="prenom">Votre prénom:</label>
    <input type="text" name="prenom" id="prenom">
    <?php if(isset($error['prenom'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['prenom'];?></p>
    <?php endif; ?>
    <label for="email">Votre email:</label>
    <input type="text" name="email" id="email">
    <?php if(isset($error['email'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['email'];?></p>
    <?php endif; ?>
    <textarea name="message" id="message" cols="30" rows="10"></textarea>
    <?php if(isset($error['message'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['message'];?></p>
    <?php endif; ?>
    <input type="submit" name="submit" id="submit" value="Envoyer">
  </form>
</div>