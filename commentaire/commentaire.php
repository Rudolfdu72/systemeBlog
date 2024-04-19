<?php
session_start();
include '../path.php';
include ROOT_PATH . '/components/header.php';
include_once('../tools/functions.php');


$pdo = getPdo();
$stmt = $pdo->prepare('SELECT * FROM commentaires
                       INNER JOIN users ON commentaires.user = users.user_id
                       INNER JOIN articles ON commentaires.article = articles.id_article
                       ORDER BY commentaires.created_at'
                       );
$stmt->execute();
$results = $stmt->fetchAll();

?>
<div class="board">
  <a href="<?= BASE_URL; ?>/admin/admin.php/" id="board"><button>Retour au tableau de bord</button></a>
</div>

<dii class="table_container">
  <h1>Gestion des commentiares</h1>
    <table>
      <thead>
        <tr>
          <th>#id</th>
          <th>E-mail</th>
          <th>Pseudo</th>
          <th>Commentiaires</th>
          <th>Date de publication</th>
          <th colspan="2" >Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($results as $resultat): ?>
          <tr>
            <td><?= $resultat['id_commentaire']?></td>
            <td><?= $resultat['email']?></td>
            <td><?= $resultat['pseudo']?></td>
            <td><?= $resultat['commentaire']?></td>
            <td><?= $resultat['created_at']?></td>
            <td>
              <a href="<?php echo BASE_URL; ?>">
                <button onclick="confirm('Voulez-vous executer cette action?')">Supprimer</button>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
</div>
