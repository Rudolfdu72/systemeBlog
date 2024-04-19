<?php
include './path.php';
include_once ('./components/header.php');
include_once('./tools/functions.php');

// Jointure de la table articles à la tables users
$pdo = getPdo();
$page = $_GET['page']?? 1;
$start = 3 * ($page - 1);
$stmt = $pdo->prepare('SELECT*FROM articles 
INNER JOIN users ON articles.user = users.user_id ORDER BY created_at DESC LIMIT :start,3');
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll();

// pagination
$statement = $pdo->prepare('SELECT COUNT(*) AS totalarticle FROM articles');
$statement->execute();
$totalarticle = $statement->fetch(PDO::FETCH_ASSOC); 
for ($i = 1; $i <= ceil($totalarticle['totalarticle'] / 3); $i++) {
    echo '<a href="?page=' . $i . '">' . $i . '</a> - ';
}

?>

<div>
  <h1 class="title">Articles</h1>
</div>
<div class="container">
  <?php foreach ($result as $res): ?>
    <div>
      <img src="<?= BASE_URL; ?>/public/image/<?= $res['image'] ?>" class="accueil" alt="">
      <h2 class="small-title">
        <a href="<?= BASE_URL; ?>/template/template.php?id=<?= $res['id_article'] ?>"><?= $res['titre'] ?></a>
      </h2>
      <p><?= date('d F, Y', strtotime($res['created_at'])) ?></p>
      <p><?= $res['pseudo'] ?></p>
    </div>
  <?php endforeach; ?>
</div>

  
