<?php require_once '../config/function.php';


if (!empty($_POST)) {

    if (empty($_POST['title_media_type'])) {
        $error = 'Ce champs est obligatoire';
    }

    if (!isset($error)) {
        execute("INSERT INTO media_type (title_media_type) VALUES (:title_media_type)", array('title_media_type' =>$_POST['title_media_type']));
        $_SESSION['messages']['success'][]='Média type ajouté'; header('location:./media_type.php');
        exit();
    }
}
require_once '../inc/backheader.inc.php';
?>


<form action="" method="post" class="w-75 mx-auto mt-5 mb-5">
    <div class="form-group">
        <small class="text-danger">*</small>
        <label for="media_type" class="form-label">Nom du type de média</label>
        <input name="title_media_type" id="media_type" type="text" class="form-control" placeholder="Nom du type de média">
        <small class="text-danger"><?= $error ?? ''; ?></small>
    </div>
    <button type="submit" class="btn btn-primary mt-2">VALIDER</button>
</form>

<table class="table table-dark table-striped w-75 mx-auto">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td></td>
            <td>
                <a href="" class="btn btn-outline-info">Modifier</a>
                <a href="" onclick="return confirm('Êtes-vous sûr ?')" class="btn btn-outline-danger">Supprimer</a>
            </td>
        </tr>

    </tbody>
</table>























<?php require_once '../inc/backfooter.inc.php';           ?>