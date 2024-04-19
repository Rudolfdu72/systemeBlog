<?php
include '../path.php';
include ROOT_PATH . '/components/header.php';
include_once ('../tools/functions.php');

// Récupération de l'id passé dans l'URL avec la methode GET sur page de suppression
if (isset($_GET["id"])) {
  $id = intval($_GET['id']);
  $pdo = getPdo();

  // Selection du commentaires à supprimer en fonction de son id.
  $stmt = $pdo->prepare('DELETE FROM commentaires WHERE id_commentaire =?');
  $sup = $stmt->execute([$id]);
}
?>

<div class="admin_container">
<div class="board">
  <a href="<?= BASE_URL; ?>/admin/admin.php/" id="board"><button>Retour au tableau de bord</button></a>
</div>

</div>

<p style="color:green; text-align:center; padding-top: 10rem; font-size: 2rem" >Le à été supprimer avec succèes</p>