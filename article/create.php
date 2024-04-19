<?php
session_start();

include '../path.php';
include ROOT_PATH . '/components/header.php';
include_once('../tools/functions.php');
if(isset($_POST['submit']) && isset($_FILES['image'])){
  $titre = htmlspecialchars($_POST['titre']);
  $contenu = htmlspecialchars($_POST['contenu']);
  // récupérer des informations sur notre image
$image_name = $_FILES['image']['name']; // nom de notre fichier
$image_tmp_name = $_FILES['image']['tmp_name']; // dossier temporaire

$image_error = $_FILES['image']['error']; // valeur d'erreur de notre image
$error =[];

  if(empty($titre)){
    $error['titre'] ='Veuillez indiquer le titre';
    
  }

  if(empty($image_name)){
    $error['image'] ='Veuillez télécharger une image';
    
  }
  
  if(empty($contenu)){
    $error['contenu'] = 'veuillez écrire l\'article';
  }
    if(empty($error) && ($image_error === 0 )){

      $destination = ROOT_PATH . "/public/image/" . $image_name; // uploads/1.png
      move_uploaded_file($image_tmp_name, $destination);
    $pdo = getPdo();
    $req = 'INSERT INTO articles(titre,image, contenu, created_at, user)VALUES(:titre, :image, :contenu, now(),:auteur)';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':titre', $titre);
     $stmt->bindValue(':image', $image_name);
    $stmt->bindValue(':contenu', $contenu);
    $stmt->bindValue(':auteur', $_SESSION['user']['user_id']);
    $stmt->execute();
    }
  
    
    }
?>
<div class="board">
  <a href="<?= BASE_URL; ?>/admin/admin.php/" id="board"><button>Retour au tableau de bord</button></a>
</div>

<div class="article_container">
   
  <form action="" method="post" enctype="multipart/form-data">
    <h1 id="article_title" >Ajout d'articles</h1>
    <div>
      <input type="file" name="image" id="image">
      <?php if(isset($error['image'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['image'] ?></p>
      <?php endif; ?>
    </div>
    <div>
      <label for="titre">Titre:</label>
      <input type="text" name="titre" id="titre" placeholder="Entrez le titre de votre article">
      <?php if(isset($error['titre'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['titre'] ?></p>
      <?php endif; ?>
    </div>
    <div>
      <label for="contenu">Ecrivez votre article:</label>
      <textarea name="contenu" id="contenu" cols="30" rows="10"></textarea>
      <?php if(isset($error['contenu'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['contenu'] ?></p>
      <?php endif; ?>
    </div>
    <input type="submit" name="submit" value="Valider">
  </form>
</div>