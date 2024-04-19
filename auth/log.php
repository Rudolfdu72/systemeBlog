<?php
session_start();
include '../path.php';
include ROOT_PATH . '/components/header.php';
include_once('../tools/functions.php');



if(isset($_POST['submit'])){
  $email_saisi = $_POST['email'];
  $orle_saisi = $_POST['role'];
  $password_saisi = $_POST['password'];
  $error =[];

  if(empty($email_saisi)){
    $error['email'] = 'Veuillez indiquer une adresse mail';
  }
  if(empty($orle_saisi)){
    $error['role'] = 'Veuillez choisir le role';
  }

  if(empty($password_saisi)){
    $error['password'] = 'Veuillez saisir le mot de passe';
  }

  if(empty($error)){
    $pdo = getPdo();
    $req = 'SELECT * FROM users WHERE email= ?';
    $stmt = $pdo->prepare($req);
    $stmt->execute([$email_saisi]);
    $user = $stmt->fetch();
    if($user !==false){
    }
    
    if(password_verify($password_saisi, $user['password'])){
      $_SESSION['user']= $user;
      header('Location:' . BASE_URL . '/admin/admin.php');
    } else{
      echo 'mot de passe incorect';
    }
  }
}
?>

<div class="contact">
  <h1>Connextion</h1>
  <form method="post" action="" class="contact_us">
    <label for="email">Votre email:</label>
    <input type="text" name="email" id="email">
    <?php if(isset($error['email'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['email'];?></p>
    <?php endif; ?>
    <label for="role">Role:</label>
    <select name="role" id="role">
      <option value="" name="role" id="role">Selectionnez un role</option>
      <option value="adminnistrateur">Administrateur</option>
      <option value="rédacteur">Rédacteur</option>
      <option value="visiteur">Lecteur</option>
    </select>
    <?php if(isset($error['role'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['role'];?></p>
    <?php endif; ?>
    <label for="password">Votre mot de passe:</label>
    <input type="password" name="password" id="password">
    <?php if(isset($error['password'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['password'];?></p>
    <?php endif; ?>
    <input type="submit" name="submit" id="submit" value="Se connecter">
  </form>
  <p>Pas encore de compte?</p>
  <a href="<?= BASE_URL?>/pages/inscription.php">Inscrivez-vous</a> 
</div>