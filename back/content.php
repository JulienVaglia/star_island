<?php require_once '../config/function.php';


if (!empty($_POST)) {


    if (empty($_POST['title_content']) || empty($_POST['description_content'])) {

        $error = 'Les deux champs sont obligatoires';
    }

    if (!isset($error)) {

        if (empty($_POST['id_content'])) {

            execute("INSERT INTO content (title_content, description_content) VALUES (:title_content, :description_content)", array(
                ':title_content' => $_POST['title_content'],
                ':description_content' => $_POST['description_content']
            ));

            $_SESSION['messages']['success'][] = 'Titre et description de content ajoutés';
            header('location:./content.php');
            exit();
        } // fin soumission en insert
        else {

            execute("UPDATE content SET title_content=:title, description_content=:description WHERE id_content=:id", array(
                ':id' => $_POST['id_content'],
                ':title' => $_POST['title_content'],
                ':description' => $_POST['description_content']
            ));

            $_SESSION['messages']['success'][] = 'Modification effectuée';
            header('location:./content.php');
            exit();
        } // fin soumission modification
    } // fin si pas d'erreur

} // fin !empty $_POST

$contents = execute("SELECT * FROM content")->fetchAll(PDO::FETCH_ASSOC);


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
        $_SESSION['messages']['success'][] = 'Titre et description de content supprimés';
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


<form action="" method="post" class="w-75 mx-auto mt-5 mb-5">

    <div class="form-group">
        <small class="text-danger">*</small>
        <label for="title_content" class="form-label">Titre</label>
        <input name="title_content" id="title_content" placeholder="Entrez votre titre ici" type="text" value="<?= $content['title_content'] ?? ''; ?>" class="form-control">
        <small class="text-danger"><?= $error ?? ''; ?></small>
    </div>
    <input type="hidden" name="id_content" value="<?= $content['id_content'] ?? ''; ?>">


    <div class="form-group mt-5">

        <small class="text-danger">*</small>
        <label for="description_content" class="form-label">Description</label>
        <textarea rows="9" name="description_content" id="description_content" placeholder="Entrez votre description ici" value="<?= $content['description_content'] ?? ''; ?>" class="form-control w-100"></textarea>
        <small class="text-danger"><?= $error ?? ''; ?></small>

    </div>
    <input type="hidden" name="id_content" value="<?= $content['id_content'] ?? ''; ?>">

    <div class="form-group mt-5">

        <label for="page-select">Chosir une page</label>

        <select id="page-select">
            <option value="">--Choisir une page--</option>
            <option value="Acceuil"></option>
            <option value="cat"></option>
            <option value="hamster">Hamster</option>
            <option value="parrot">Parrot</option>
            <option value="spider">Spider</option>
            <option value="goldfish">Goldfish</option>
        </select>

    </div>
    <input type="hidden" name="id_content" value="<?= $content['id_content'] ?? ''; ?>">

    <button type="submit" class="btn btn-primary mt-2">Valider</button>

</form>

<table class="table table-dark table-striped w-75 mx-auto">
    <thead>
        <tr>
            <th>Titre</th>
            <th class="text-center">Titre</th>
            <th class="text-center">Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contents as $content) : ?>
            <tr>
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