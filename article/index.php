<?php
session_start();
include '../path.php';
include ROOT_PATH . '/components/header.php';
include_once('../tools/functions.php');
isLogin();



$pdo = getPdo();
$stmt = $pdo->prepare('SELECT*FROM articles INNER JOIN users ON articles.user = users.user_id ');
$stmt->execute();
$result = $stmt->fetchAll();
?>
<div class="board">
  <a href="<?= BASE_URL; ?>/admin/admin.php/" id="board"><button>Retour au tableau de bord</button></a>
</div>

<dii class="table_container">
  <h1>Gestion des articles</h1>
    <table>
      <thead>
        <tr>
          <th>#id</th>
          <th>Titre</th>
          <th>Article</th>
          <th>Illustration</th>
          <th>auteur</th>
          <th>Date de création</th>
          <th colspan="2" >Action</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $res):?>
          <tr>
            <td><?= $res['user_id'] ?></td>
            <td><?= $res['titre'] ?></td>
            <td><?= $res['contenu'] ?></td>
            <td><?= $res['image'] ?></td>
            <td><?= $res['nom'] ?></td>
            <td><?= $res['created_at'] ?></td>
            <td>
              <a href="<?php echo BASE_URL; ?>/article/edit.php?id=<?=$res['id_article']?>">
                <button>Modifier</button>
              </a>
            </td>
            <td>
              <a href="<?php echo BASE_URL; ?>/article/delete.php?id=<?=$res['id_article']?>">
                <button onclick="confirm('Voulez-vous executer cette action?')">Supprimer</button>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
</div>
