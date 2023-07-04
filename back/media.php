<?php require_once '../config/function.php';

$errors = array();

if (!empty($_POST) && !empty($_FILES)) {

    if (empty($_POST['id_page'])) {
        $errors[] = 'Choix de la page obligatoire';
    }

    if (empty($_POST['title_media'])) {
        $errors[] = 'Nom du média obligatoire';
    }

    if (empty($_POST['id_media_type'])) {
        $errors[] = 'Choix du type de média obligatoire';
    }

    if (empty($_FILES['image']['name'])) {
        $errors[] = 'Choix du fichier obligatoire';
    }

    if (empty($errors)) {

        // récuperation du media_type selectionné
        $mt = execute("SELECT * FROM media_type WHERE id_media_type='$_POST[id_media_type]'")->fetch();

        if (!file_exists('upload/')) {
            mkdir('upload/', 777);
        }

        // Créer des sous dossiers en fonction du type média
        if (!file_exists('upload/' . $mt['title_media_type'])) {
            mkdir('upload/' . $mt['title_media_type'], 777);
        }

        $titre_du_media = uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . '_' . $_FILES['image']['name'];
        $alt_du_media = $_POST['title_media'];



        copy($_FILES['image']['tmp_name'], 'upload/' . $mt['title_media_type'] . '/' . $titre_du_media);
        //Fin de création de sous dossier

        execute("INSERT INTO media (id_page, title_media, name_media, id_media_type) VALUES (:id_page, :title_media, :name_media, :id_media_type)", array(
            ':id_page' => $_POST['id_page'],
            ':title_media' => $alt_du_media,
            ':name_media' => $titre_du_media,
            ':id_media_type' => $_POST['id_media_type']
        ));

        $_SESSION['messages']['success'][] = 'Média ajouté';
        header('location:./media.php');
        exit();
    } // fin soumission en insert

} // fin si pas d'erreur

// fin !empty $_POST

//Liaison des tables media_type et page avec la table media
$medias = execute("SELECT m.*, p.*, mt.* FROM media m INNER JOIN page p ON m.id_page = p.id_page INNER JOIN media_type mt ON m.id_media_type = mt.id_media_type")->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'del') {



    $file_path = execute("SELECT m.*, mt.* FROM media m INNER JOIN media_type mt ON m.id_media_type = mt.id_media_type WHERE id_media=$_GET[id]")->fetch();

    $success_database = false;

    // création du unlink pour suppression du fichier du dossier upload

    $file_path = "upload/$file_path[title_media_type]/$file_path[name_media]";

    $success_arborescence = unlink($file_path);

    if ($success_arborescence) {
        $success_database = execute("DELETE FROM media WHERE id_media=:id", array(
            ':id' => $_GET['id']

        ));
    }


    if ($success_database) {
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
<form action="" method="post" enctype="multipart/form-data" class="w-75 mx-auto mt-5 mb-5">

    <!-- Choix de page -->
    <?php
    $pages = execute("SELECT * FROM page")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="form-group mx-auto">
        <small class="text-danger">*</small>
        <label for="id_page">Choisir une page</label><br>
        <select name="id_page">
            <option id="id_page" value="<?= $media['id_page'] ?? ''; ?>"> --Choisir une page-- </option>
            <?php
            foreach ($pages as $page) {
                echo "<option value='$page[id_page]'>$page[title_page]</option>";
            }
            ?>
        </select><br>
        <small class="text-danger"><?= isset($errors['id_page']) ? $errors['id_page'] : ''; ?></small>
    </div>

    <!-- Nom du média -->
    <div class="form-group">
        <small class="text-danger">*</small>
        <label for="title_media" class="form-label mt-3">Nom/description du média ( attention de mettre un nom le plus explicite et court possible )</label>
        <input name="title_media" id="title_media" placeholder="Entrez le nom ici" type="text" value="<?= $media['title_media'] ?? ''; ?>" class="form-control">
        <small class="text-danger"><?= isset($errors['title_media']) ? $errors['title_media'] : ''; ?></small>
    </div>

    <!-- Type de média -->
    <?php
    $media_types = execute("SELECT * FROM media_type")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="form-group mx-auto">
        <small class="text-danger">*</small>
        <label for="id_media_type" class="mt-3">Choisir un type de média</label><br>
        <select id="id_media_type" name="id_media_type">
            <option value="<?= $media['id_media_type'] ?? ''; ?>"> --Choisir un type-- </option>
            <?php
            foreach ($media_types as $media_type) {
                echo "<option class='id_media_type' value='$media_type[id_media_type]'>$media_type[title_media_type]</option>";
            }
            ?>
        </select><br>
        <small class="text-danger"><?= isset($errors['id_media_type']) ? $errors['id_media_type'] : ''; ?></small><br>
    </div>

    <!-- File du média -->
    <div class="form-group" id="image" style="display: none;">
        <small class="text-danger">*</small>
        <label for="image" class="form-label">Sélectionnez un fichier :</label><br>
        <input type="file" name="image"  class="file-input"><br>
        <small class="text-danger"><?= isset($errors['image']) ? $errors['image'] : ''; ?></small>
    </div>

    <!-- Lien du média (pour les types de média "lien") -->
    <div class="form-group" id="lien_media" style="display: none;">
        <small class="text-danger">*</small>
        <label for="lien_media" class="form-label">Entrez le lien :</label><br>
        <input type="text" name="lien_media"  placeholder="Entrez le lien ici" value="<?= $media['lien_media'] ?? ''; ?>" class="form-control">
        <small class="text-danger"><?= isset($errors['lien_media']) ? $errors['lien_media'] : ''; ?></small>
    </div>



    <input type="hidden" name="id_media" value="<?= $media['id_media'] ?? ''; ?>">
    <input type="hidden" name="media_type" value="<?= $media['title_media_type'] ?? ''; ?>">

    <button type="submit" class="btn btn-primary mt-2 mx-auto">Valider</button>
</form>

<!-- Tableau récapitulatif -->
<table class="table table-dark table-striped w-75 mx-auto">
    <thead>
        <tr>
            <th>Page</th>
            <th class="text-center">Nom du média</th>
            <th class="text-center">Type de média</th>
            <th class="text-center">Aperçu</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medias as $media) : ?>
            <tr>

                <td><?= $media['title_page']; ?></td>
                <td class="text-center"><?= $media['title_media']; ?></td>
                <td class="text-center"><?= $media['title_media_type']; ?></td>
                <td class="text-center"><img src="upload/<?= $media['title_media_type'] ?>/<?= $media['name_media'] ?>" alt="<?= $media['title_media'] ?>" width="70" height="70" class="media-preview" data-src="upload/<?= $media['title_media_type'] ?>/<?= $media['name_media'] ?>"></td>
                <td class="text-center">
                    <a href="?id=<?= $media['id_media']; ?>&a=del" onclick="return confirm('Etes-vous sûr?')" class="btn btn-outline-danger">Supprimer</a>
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

<!-- JS : Au clic sur la photo => affichage plein ecran / si click hors photo l'apercu se ferme -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mediaPreviews = document.getElementsByClassName('media-preview');

        for (var i = 0; i < mediaPreviews.length; i++) {
            mediaPreviews[i].addEventListener('click', function() {
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


<script>

    // Ciblage de la div choix du media_type
    let select = document.getElementById('id_media_type');

    //Ciblage de la div insertion file
    let file_input = document.getElementById('image');

    //Ciblage de la div insertion lien
    let lien_input = document.getElementById('lien_media');


        select.addEventListener("change", function() {
        console.log(select.options[select.selectedIndex].text);


        let media_type = select.options[select.selectedIndex].text;
        console.log(media_type);

        file_input.style.display = 'none';
        lien_input.style.display = 'none';

        //affichage des input en fonction du choix media_type
        if (media_type === 'lien') {
            lien_input.style.display = 'block';
        } else {
            file_input.style.display = 'block'
        }

    })

</script>

<?php require_once '../inc/backfooter.inc.php'; ?>