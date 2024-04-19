<?php
session_start();
include '../path.php';
include ROOT_PATH . '/components/header.php';
include_once('../tools/functions.php');
isLogin();
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

      $destination = ROOT_PATH . "/public/image/" . $image_name;
      move_uploaded_file($image_tmp_name, $destination);

    }
    


  if (isset($_POST['submit'])) {
        $id = $_GET['id']; 
        $pdo = getPdo();
        $titre =$_POST['titre'];
        $contenu =$_POST['contenu'];
        $image =$_FILES['image']['name'];
        $modif = $pdo->prepare("UPDATE articles SET titre = ?, contenu = ?, image = ?, created_at = now() WHERE id_article = ?");
        $modif->execute(array($titre, $contenu, $image, $id));
        
    }
    
    
    }

    if(isset($_GET['id'])) {
      $pdo = getPdo();
      $stmt = $pdo->prepare('SELECT*FROM articles WHERE id_article = ?');
      $id = $_GET['id']; 
      $stmt->execute(array($id));
      $result = $stmt->fetch();
  }
    
?>
<div class="board">
  <a href="<?= BASE_URL; ?>/admin/admin.php/" id="board"><button>Retour au tableau de bord</button></a>
</div>

<div class="article_container">
  <form action="" method="post" enctype="multipart/form-data">
    <h1 id="article_title" >Modification d'articles</h1>
    <div>
      <input type="file" name="image" id="image">
      <?php if(isset($error['image'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['image'] ?></p>
      <?php endif; ?>
    </div>
    <div>
      <label for="titre">Titre:</label>
      <input type="text" name="titre" id="titre" value="<?= $result['titre'] ?>" placeholder="Entrez le titre de votre article">
      <?php if(isset($error['titre'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['titre'] ?></p>
      <?php endif; ?>
    </div>
    <div>
      <label for="contenu">Ecrivez votre article:</label>
      <textarea name="contenu" id="contenu" value="" cols="30" rows="10"><?= $result['contenu'] ?></textarea>
      <?php if(isset($error['contenu'])):?>
      <p style="color:red; font-size: 1.3rem;"><?= $error['contenu'] ?></p>
      <?php endif; ?>
    </div>
    <input type="submit" name="submit" value="Valider">
  </form>
</div>