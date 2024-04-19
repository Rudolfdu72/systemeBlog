<?php
include_once '../path.php';
include_once '../components/header.php';
include_once '../tools/functions.php';

if (isset($_POST['submit'])) {

  $commentaire = $_POST['commentaire'];
  $email = $_POST['email'];
  $article = intval($_GET['id']);
  $error = [];

  if (empty($commentaire)) {
    $error['commentaire'] = 'Veuillez écrire un commentaire';
  }

  if (empty($email)) {
    $error['email'] = 'Veuillez indiquer une adresse mail';
  } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $error['email'] = 'Veuillez indiquer une adresse mail valide';
  }
  if (count($error) === 0) {
    $pdo = getPdo();
    $requete = 'INSERT INTO commentaires(user, commentaire, article, created_at) 
                    VALUES(:idUser, :commentaire, :idArticle, now())';
    $stmt = $pdo->prepare($requete);
    $stmt->bindValue(':idUser', 2);
    $stmt->bindValue(':commentaire', $commentaire);
    $stmt->bindValue(":idArticle", $article);
    $stmt->execute();

  }

}

$id ='';
if(isset($_GET['id'])){
  $id = intval($_GET['id']);
if(empty($id)){
  die('cet article n\'existe pas');
}

$pdo = getPdo();
$stmt = $pdo->prepare('SELECT * FROM commentaires
                       INNER JOIN users ON commentaires.user = users.user_id 
                        WHERE commentaires.article = :idArticle
                       ORDER BY commentaires.created_at'
                       );
                       
$stmt->bindValue(':idArticle',$_GET['id']);
$stmt->execute();
$results = $stmt->fetchAll();

}
$pdo = getpdo();
    $req = 'SELECT*FROM articles WHERE id_article = ?';
    $stmt = $pdo->prepare($req);
    $stmt->execute([$id]);
    $art = $stmt->fetch();
?>
<article class="article_template">
    <div>
      <img src="<?= BASE_URL; ?>/public/image/<?= $art['image'];?>" class="image" alt="">
      <h1><?= $art['titre'];?></h1>
      <p><?= $art['contenu'];?></p>
      <p><?= date('d F, Y', strtotime($art['created_at'])) ?></p>
    </div>
</article>

<div class="comments" >
  <h1>Commentaires</h1>
  <div>
  <?php foreach($results as $result): ?>
    <p><?= $result['commentaire'];?></p>
    <p>Par <?= $result['pseudo'];?> le <?= date('d F, Y', strtotime($result['created_at'])) ?></p>
  <?php endforeach;?>
    
  </div>
</div>
<div class="commentaire">
  <form action="" method="post" class="form_flex">
    <div>
      <h2>Laisser un commentaire</h2>
      <label for="commentaire">Commentaire</label>
      <textarea name="commentaire" id="commentaire" cols="30" rows="10"></textarea>
      <?php if (isset($error['commentaire'])): ?>
        <p style="color:red;"><?= $error['commentaire'] ?></p>
      <?php endif ?>
    </div>
    <div>
      <label for="email">E-mail:</label>
      <input type="email" name="email" id="email">
      <?php if (isset($error['email'])): ?>
        <p style="color:red;"><?= $error['email'] ?></p>
      <?php endif ?>
    </div>
    <div>
      <input type="submit" name="submit" value="Laissez un commentaire">
    </div>
  </form>
</div>

