<?php require_once '../config/function.php';


if (!empty($_POST)) {


    if (empty($_POST['title_media']) || empty($_POST['description_content']) || empty($_POST['id_page']) || empty($_POST['id_media_type']) ) {

        $error = 'Tous les champs sont obligatoires';
    }

    if (!isset($error)) {

        if (empty($_POST['id_content'])) {

            execute("INSERT INTO content (title_media, id_page, id_media_type, description_content) VALUES (:title_media, :id_page, :id_media_type, :description_content)", array(
                ':id_page' => $_POST['id_page'],
                ':title_media' => $_POST['title_media'],
                ':id_media_type' => $_POST['id_media_type'],
                ':description_content' => $_POST['description_content']
            ));

            $_SESSION['messages']['success'][] = 'Média ajouté';
            header('location:./media.php');
            exit();
        } // fin soumission en insert

    } // fin si pas d'erreur

} // fin !empty $_POST


//Liaison des tables media_type et page avec la table media
$contents = execute("SELECT m.*, p.*, mt.* FROM media m INNER JOIN page p ON m.id_page = p.id_page INNER JOIN media_type mt ON m.id_media_type = mt.id_media_type")->fetchAll(PDO::FETCH_ASSOC);


if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'del') {

    $success = execute("DELETE FROM media WHERE id_media=:id", array(
        ':id' => $_GET['id']
    ));

    if ($success) {
        $_SESSION['messages']['success'][] = 'Contenu supprimé';
        header('location:./media.php');
        exit;
    } else {
        $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réitérer';
        header('location:./media.php');
        exit;
    }
}


require_once '../inc/backheader.inc.php';
?>



<!-- Formulaires -->
<form action="" method="post" class="w-75 mx-auto mt-5 mb-5">


    <!-- Choix de page -->
    <?php
    $pages = execute("SELECT * FROM page")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="form-group mx-auto">

        <small class="text-danger">*</small>
        <label for="id_page">Choisir une page</label><br>
        <select id="" name="id_page">

            <option id="id_page" value="<?= $content['id_page'] ?? ''; ?>"> --Choisir une page-- </option>
            <?php
            foreach ($pages as $page) {
                echo "<option value='$page[id_page]'>$page[title_page]</option>";
            }
            ?>
        </select><br>
        <small class="text-danger"><?= $error ?? ''; ?></small>

    </div>

    <!-- Nom du média -->
    <div class="form-group">
        <small class="text-danger">*</small>
        <label for="title_media" class="form-label mt-3">Nom du média ( attention de mettre un nom le plus explicite et court possible )</label>
        <input name="title_media" id="title_media" placeholder="Entrez le nom ici" type="text" value="<?= $content['title_media'] ?? ''; ?>" class="form-control">
        <small class="text-danger"><?= $error ?? ''; ?></small>
    </div>


    <!-- Type de média -->
    <?php
    $media_types = execute("SELECT * FROM media_type")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="form-group mx-auto">

        <small class="text-danger">*</small>
        <label for="id_media_type" class="mt-3">Choisir un type de média</label><br>
        <select id="" name="id_media_type">

            <option id="id_media_type" value="<?= $content['id_media_type'] ?? ''; ?>"> --Choisir un type-- </option>
            <?php
            foreach ($media_types as $media_type) {
                echo "<option value='$media_type[id_media_type]'>$media_type[title_media_type]</option>";
            }
            ?>
        </select><br>
        <small class="text-danger"><?= $error ?? ''; ?></small>

    </div>

    <!-- Lien du média -->
    <div class="form-group">

        <small class="text-danger">*</small>
        <label for="image" class="form-label mt-3" >Sélectionnez un fichier :</label><br>
        <input type="file" name="image" id="image" class="">
        <small class="text-danger"><?= $error ?? ''; ?></small>

    </div>


    <input type="hidden" name="id_content" value="<?= $content['id_content'] ?? ''; ?>">

    <button type="submit" class="btn btn-primary mt-2 mx-auto">Valider</button>

</form>


<!-- Tableau récapitulatif -->

<table class="table table-dark table-striped w-75 mx-auto">

    <thead>
        <tr>
            <th>Page</th>
            <th>Nom du média</th>
            <th class="text-center">Type de média</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($contents as $content) : ?>
            <tr>
                <td><?= $content['title_page']; ?></td>
                <td><?= $content['title_media']; ?></td>
                <td class="text-center"><?= $content['description_content']; ?></td>
                <td class="text-center">
                    <a href="?id=<?= $content['id_content']; ?>&a=del" onclick="return confirm('Etes-vous sûr?')" class="btn btn-outline-danger">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php require_once '../inc/backfooter.inc.php'; ?>