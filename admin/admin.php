<?php
session_start();
include '../path.php';
include ROOT_PATH . '/components/header.php';
include_once ('../tools/functions.php');

isLogin();

$pdo = getPdo();
$results = null;
$stmt = null;

if (isRedactor()) {
  $stmt = $pdo->prepare("SELECT articles.*, users.nom 
                      FROM articles 
                      INNER JOIN users ON articles.user = users.user_id
                      WHERE articles.user = " . $_SESSION['user']['user_id']);
} else {
  $stmt = $pdo->prepare("SELECT articles.*, users.nom 
                      FROM articles 
                      INNER JOIN users ON articles.user = users.user_id");
}
$stmt->execute();
$results = $stmt->fetchAll();

?>
<div class="admin_container">
  <div>
    <a href="<?= BASE_URL; ?>/article/create.php"><button class="article_button">Ajouter un article</button></a>
    <?php if (isAdmin($_SESSION['user'])): ?>
      <a href="<?= BASE_URL; ?>/commentaire/commentaire.php"><button class="article_button">Gérer les
          commentaires</button></a>
    <?php endif; ?>
    <a href="<?= BASE_URL; ?>/index.php/" target="_blank"><button class="article_button">Aller sur le Blog</button></a>
  </div>
  <div><a href="<?= BASE_URL ?>/auth/logout.php"><button class="article_button"
        id="deconnexion">Déconnexion</button></a></div>
</div>
<dii class="table_container">
  <h1 id="account_title">Bienvenue
    <?= $_SESSION['user']['pseudo'] ?> sur votre espace
    <?= isAdmin($_SESSION['user']) ? ' administrateur' : ' redacteur' ?>
  </h1>
  <table>
    <thead>

      <tr>
        <th>#id</th>
        <th>Titre</th>
        <th>Article</th>
        <th>Illustration</th>
        <th>Date de création</th>
        <th>Auteur</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($results as $result): ?>
        <tr>
        <td><?= $result['id_article'] ?></td>
          <td><?= $result['titre'] ?></td>
          <td><?= $result['contenu'] ?></td>
          <td><?= $result['image'] ?></td>
          <td><?= $result['nom'] ?></td>
          <td><?= $result['created_at'] ?></td>
          <td>
            <a href="<?php echo BASE_URL; ?>/article/edit.php?id=<?= $result['id_article'] ?>">
              <button>Modifier</button>
            </a>
          </td>
          <td>
            <a href="<?php echo BASE_URL; ?>/article/delete.php">
              <button onclick="confirm('Voulez-vous enrgegistrer cette cette Modification?')">Supprimer</button>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  </div>