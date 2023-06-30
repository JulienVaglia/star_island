<?php require_once '../config/function.php';


if (!empty($_POST)) {


    if (empty($_POST['title_content']) || empty($_POST['description_content']) || empty($_POST['id_page'])) {

        $error = 'Tous les champs sont obligatoires';
    }

    if (!isset($error)) {

        if (empty($_POST['id_content'])) {

            execute("INSERT INTO content (title_content, id_page, description_content) VALUES (:title_content, :id_page, :description_content)", array(
                ':title_content' => $_POST['title_content'],
                ':id_page' => $_POST['id_page'],
                ':description_content' => $_POST['description_content']
            ));

            $_SESSION['messages']['success'][] = 'Page, titre et description de content ajoutés';
            header('location:./content.php');
            exit();
        } // fin soumission en insert
        else {

            execute("UPDATE content SET title_content=:title, id_page=:page, description_content=:description WHERE id_content=:id", array(
                ':id' => $_POST['id_content'],
                ':title' => $_POST['title_content'],
                ':page' => $_POST['id_page'],
                ':description' => $_POST['description_content']
            ));

            $_SESSION['messages']['success'][] = 'Modification effectuée';
            header('location:./content.php');
            exit();
        } // fin soumission modification

    } // fin si pas d'erreur

} // fin !empty $_POST


$contents = execute("SELECT c.*,p.* FROM content c INNER JOIN page p ON c.id_page = p.id_page ")->fetchAll(PDO::FETCH_ASSOC);


if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'edit') {

    $content = execute("SELECT * FROM content WHERE id_content=:id", array(
        ':id' => $_GET['id']
    ))->fetch(PDO::FETCH_ASSOC);
}

if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'del') {

    $success = execute("DELETE FROM content WHERE id_content=:id", array(
        ':id' => $_GET['id']
    ));

    if ($success) {
        $_SESSION['messages']['success'][] = 'Contenu supprimé';
        header('location:./content.php');
        exit;
    } else {
        $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réitérer';
        header('location:./content.php');
        exit;
    }
}


require_once '../inc/backheader.inc.php';
?>

<!-- Formulaires -->
<form action="" method="post" class="w-75 mx-auto mt-5 mb-5">

    <!-- Titre -->
    <div class="form-group">
        <small class="text-danger">*</small>
        <label for="title_content" class="form-label">Fonction</label>
        <input name="title_content" id="title_content" placeholder="Entrez votre information ici" type="text" value="<?= $content['title_content'] ?? ''; ?>" class="form-control">
        <small class="text-danger"><?= $error ?? ''; ?></small>
    </div>


    <!-- Description -->
    <div class="form-group mt-5">

        <small class="text-danger">*</small>
        <label for="description_content" class="form-label">Description</label>
        <textarea rows="9" name="description_content" id="description_content" placeholder="Entrez votre description ici" value="<?= $content['description_content'] ?? ''; ?>" class="form-control w-100"></textarea>
        <small class="text-danger"><?= $error ?? ''; ?></small>

    </div>

    <!-- Choix de page -->
    <?php
    $pages = execute("SELECT * FROM page")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="form-group mt-5">

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

    <input type="hidden" name="id_content" value="<?= $content['id_content'] ?? ''; ?>">

    <button type="submit" class="btn btn-primary mt-2">Valider</button>

</form>


<!-- Tableau récapitulatif -->

<table class="table table-dark table-striped w-75 mx-auto">

    <thead>
        <tr>
            <th>Page</th>
            <th>Fonction</th>
            <th class="text-center">Description</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($contents as $content) : ?>
            <tr>
                <td><?= $content['title_page']; ?></td>
                <td><?= $content['title_content']; ?></td>
                <td class="text-center"><?= $content['description_content']; ?></td>
                <td class="text-center">
                    <a href="?id=<?= $content['id_content']; ?>&a=edit" class="btn btn-outline-info">Modifier</a>
                    <a href="?id=<?= $content['id_content']; ?>&a=del" onclick="return confirm('Etes-vous sûr?')" class="btn btn-outline-danger">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php require_once '../inc/backfooter.inc.php'; ?>