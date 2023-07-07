<?php require_once '../config/function.php'; ?>
<?php 

$comments = execute("SELECT * FROM comment");

// Poster le message
if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'edit') {

    $valid_comment = 1;
    $success = execute("UPDATE comment SET valid_comment=:valid_comment WHERE id_comment=:id", array(
        ':id' => $_GET['id'],
        ':valid_comment' => $valid_comment));

    $_SESSION['messages']['success'][] = 'Message validé pour le bloc avis';
    header('location:./comment.php');
    exit;
    }

    // Cacher le message
if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'hide') {

    $valid_comment = 0;
    $success = execute("UPDATE comment SET valid_comment=:valid_comment WHERE id_comment=:id", array(
        ':id' => $_GET['id'],
        ':valid_comment' => $valid_comment));

    $_SESSION['messages']['success'][] = 'Message caché';
    header('location:./comment.php');
    exit;
    }

    //Supression du message
if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'del')    {

    $success = execute("DELETE FROM comment WHERE id_comment=:id", array(
        ':id' => $_GET['id']
    ));

    if ($success) {
        $_SESSION['messages']['success'][] = 'Commentaire supprimé';
        header('location:./comment.php');
        exit;

    } else {
        $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réitérer';
        header('location:./comment.php');
        exit;
    }
    }  

if (!empty($avatar_comment)) {
    $imagePath = "media-upload/avatar_comment/" . $avatar_comment[$i];
        debug($imagePath); die;
}


    


require_once '../inc/backheader.inc.php';

 ?>

<!-- Tableau récapitulatif -->
<table class="table table-dark table-striped w-75 mx-auto">
    <thead>
        <tr>
            <th>Date de publication <i class="fas fa-sort tri"></i></th>
            <th class="text-center" data-column="type-comment">Pseudo</th>
            <th class="text-center" data-column="nom-comment">Note <i class="fas fa-sort tri"></i></th>
            <th class="text-center w-50">Commentaire</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($comments as $comment) : ?>

        <tr>
            <td class="tri"><?= strftime('%e %B %Y', strtotime($comment['publish_date_comment'])); ?></td>
            <td class="text-center type-comment"><?= $comment['nickname_comment']; ?></td>
            <td class="text-center tri nom-comment"><?= $comment['rating_comment']; ?></td>
            <td class="text-center"><?= $comment['comment_text'] ?></td>
            <td class="text-center">
                <a href="?id=<?= $comment['id_comment']; ?>&a=edit" onclick="return confirm('Etes-vous sûr de vouloir poster ?')" class="btn btn-outline-info">Publier</a>
                <a href="?id=<?= $comment['id_comment']; ?>&a=hide" onclick="return confirm('Etes-vous sûr de vouloir cacher le post ?')" class="btn btn-outline-info">Cacher</a>
                <a href="?id=<?= $comment['id_comment']; ?>&a=del" onclick="return confirm('Etes-vous sûr ?')" class="btn btn-outline-danger">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>




<!-- CSS -->


<!-- CSS : apercu plein écran -->

<style>
    .preview-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10;
    }

    .preview-modal img {
        max-width: 90%;
        max-height: 90%;
    }
</style>


<!-- SCRIPT -->


<!-- JS : Au clic sur le commentaire => affichage plein ecran / si click hors photo l'apercu se ferme -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var commentPreviews = document.getElementsByClassName('comment-preview');

        for (var i = 0; i < commentPreviews.length; i++) {
            commentPreviews[i].addEventListener('click', function() {
                var src = this.getAttribute('data-src');
                var previewModal = document.createElement('div');
                previewModal.className = 'preview-modal';
                previewModal.innerHTML = '<img src="' + src + '">';

                document.body.appendChild(previewModal);
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('preview-modal')) {
                e.target.parentNode.removeChild(e.target);
            }
        });
    });
</script>


<?php require_once '../inc/backfooter.inc.php'; ?>