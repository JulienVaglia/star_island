<?php require_once '../config/function.php';

$errors = array();

if ((!empty($_POST) && !empty($_FILES)) || (!empty($_POST['lien_media']))) {

    if (empty($_POST['id_page'])) {
        $errors[] = 'Choix de la page obligatoire';
    }

    if (empty($_POST['title_media'])) {
        $errors[] = 'Nom du média obligatoire';
    }

    if (empty($_POST['id_media_type'])) {
        $errors[] = 'Choix du type de média obligatoire';
    }

    if (empty($_FILES['image']['name']) && empty($_POST['lien_media'])) {
        $errors[] = 'Choix du fichier obligatoire';
    }

    if (empty($errors)) {

        // récuperation du media_type selectionné
        $mt = execute("SELECT * FROM media_type WHERE id_media_type='$_POST[id_media_type]'")->fetch();

        if (!file_exists('media-upload/')) {
            mkdir('media-upload/', 777);
        }

        // Créer des sous dossiers en fonction du type média
        if (!file_exists('media-upload/' . $mt['title_media_type'])) {
            mkdir('media-upload/' . $mt['title_media_type'], 777);
        }


        if (!empty($_POST['lien_media'])) {

            $titre_du_media = $_POST['lien_media'];
            $alt_du_media = $_POST['title_media'];
        } else {

            $titre_du_media = uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . '_' . $_FILES['image']['name'];
            $alt_du_media = $_POST['title_media'];

            copy($_FILES['image']['tmp_name'], 'media-upload/' . $mt['title_media_type'] . '/' . $titre_du_media);
        }

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


    else {

        execute("UPDATE media SET title_media=:title WHERE id_media=:id", array(
            ':id' => $_POST['id_media'],
            ':title' => $_POST['title_media']
        ));  

        $_SESSION['messages']['success'][] = 'Lien modifié';
        header('location:./media.php');
        exit();
    } // fin soumission modification
} // fin si pas d'erreur

// fin !empty $_POST

//Liaison des tables media_type et page avec la table media
$medias = execute("SELECT m.*, p.*, mt.* FROM media m INNER JOIN page p ON m.id_page = p.id_page INNER JOIN media_type mt ON m.id_media_type = mt.id_media_type")->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'edit') {

    $media = execute("SELECT * FROM media m WHERE id_media=:id", array(
        ':id' => $_GET['id']
    ))->fetch(PDO::FETCH_ASSOC);
}

if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'del') {


    $file_path = execute("SELECT m.*, mt.* FROM media m INNER JOIN media_type mt ON m.id_media_type = mt.id_media_type WHERE id_media=$_GET[id]")->fetch();

    $success_database = false;

    if ($file_path['title_media_type'] === "lien") {
        $success_arborescence = true;
    } else {
        // création du unlink pour suppression du fichier du dossier media/upload

        $file_path = "media-upload/$file_path[title_media_type]/$file_path[name_media]";

        $success_arborescence = unlink($file_path);
    }

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

    //Liste des pages à exclure du choix
    $pages_exclues = array('Serveur');

    ?>
    
    <div class="form-group mx-auto">
        <small class="text-danger">*</small>
        <label for="id_page">Choisir une page</label><br>
        <select name="id_page">
            <option id="id_page" value="<?= $media['id_page'] ?? ''; ?>"> --Choisir une page-- </option>
            <?php
            foreach ($pages as $page) {
                if (!in_array($page['title_page'], $pages_exclues)) {
                    echo "<option value='$page[id_page]'>$page[title_page]</option>";
                }
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
                
                echo "<option class='id_media_type' value='$media_type[id_media_type]'  >$media_type[title_media_type]</option>";
            }
            ?>
        </select><br>
        <small class="text-danger"><?= isset($errors['id_media_type']) ? $errors['id_media_type'] : ''; ?></small><br>
    </div>

    <!-- File du média -->
    <div class="form-group" id="image" style="display: none;">
        <small class="text-danger">*</small>
        <label for="image" class="form-label">Sélectionnez un fichier :</label><br>
        <input type="file" name="image" class="file-input"><br>
        <small class="text-danger"><?= isset($errors['image']) ? $errors['image'] : ''; ?></small>
    </div>

    <!-- Lien du média (pour les types de média "lien") -->
    <div class="form-group" id="lien_media" style="display: none;">
        <small class="text-danger">*</small>
        <label for="lien_media" class="form-label">Entrez le lien :</label><br>
        <input type="text" name="lien_media" placeholder="Entrez le lien ici" value="<?= $media['lien_media'] ?? ''; ?>" class="form-control">
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
            <th class="w-25">Page</th>
            <th class="text-center tri w-25" data-column="type-media">Type de média
                <i class="fas fa-sort tri-icon"></i>
                <div class="dropdown">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-sort="asc">Trier par ordre croissant</a></li>
                        <li><a class="dropdown-item" href="#" data-sort="desc">Trier par ordre décroissant</a></li>
                    </ul>
                </div>
            </th>
            <th class="text-center tri w-25" data-column="nom-media">Nom du média
                <i class="fas fa-sort tri-icon"></i>
                <div class="dropdown">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-sort="asc">Trier par ordre croissant</a></li>
                        <li><a class="dropdown-item" href="#" data-sort="desc">Trier par ordre décroissant</a></li>
                    </ul>
                </div>
            </th>
            <th class="text-center w-50">Aperçu</th>
            <th class="text-center w-25">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medias as $media) :
            if ($media['title_page'] !== 'Serveur') { ?>
                <tr>

                    <td><?= $media['title_page']; ?></td>
                    <td class="text-center tri type-media"><?= $media['title_media_type']; ?></td>
                    <td class="text-center tri nom-media"><?= $media['title_media']; ?></td>

                    <?php if ($media['title_media_type'] === 'lien') { ?>
                        <td class="text-center">
                            <?= $media['name_media'] ?>
                        </td>
                    <?php } else { ?>
                        <td class="text-center">
                            <img src="media-upload/<?= $media['title_media_type'] ?>/<?= $media['name_media'] ?>" alt="<?= $media['title_media'] ?>" width="70" height="70" class="media-preview" data-src="media-upload/<?= $media['title_media_type'] ?>/<?= $media['name_media'] ?>">
                        </td>
                    <?php } ?>

                    <?php


                    if ($media['title_media_type'] == 'lien') { ?>
                        <td>
                            <a href="?id=<?= $media['id_media']; ?>&a=edit" onclick="return confirm('Merci de resaisir toutes les informations')" class="btn btn-outline-info">Modifier</a>
                        </td>

                    <?php } else {
                        echo '<td></td>';
                    }  ?>

                    <td class="text-center">
                        <a href="?id=<?= $media['id_media']; ?>&a=del" onclick="return confirm('Etes-vous sûr?')" class="btn btn-outline-danger">Supprimer</a>
                    </td>
                </tr>
        <?php }
        endforeach; ?>
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


<!-- Input en fonction du média type choisi -->
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
        if (media_type === '--Choisir un type--') {
            lien_input.style.display = 'none';
            file_input.style.display = 'none';
        } else if (media_type === 'lien') {
            lien_input.style.display = 'block';
        } else {
            file_input.style.display = 'block';
        }

    })
</script>

<!-- Possibilité de tri du tableau récap par thême -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let triHeaders = document.querySelectorAll('.tri');

        for (var i = 0; i < triHeaders.length; i++) {
            let column = triHeaders[i].getAttribute('data-column');
            let sortIcon = triHeaders[i].querySelector('.tri-icon');
            let dropdownMenu = triHeaders[i].querySelector('.dropdown-menu');

            sortIcon.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.style.display = 'block';
            });

            dropdownMenu.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            dropdownMenu.addEventListener('mouseleave', function() {
                dropdownMenu.style.display = 'none';
            });

            let dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
            for (var j = 0; j < dropdownItems.length; j++) {
                dropdownItems[j].addEventListener('click', function() {
                    let sortType = this.getAttribute('data-sort');
                    dropdownMenu.style.display = 'none';
                    sortTable(column, sortType);
                });
            }
        }

        function sortTable(column, sortType) {
            var table = document.getElementsByTagName('table')[0];
            var rows = Array.from(table.getElementsByTagName('tr')).slice(1);

            rows.sort(function(a, b) {
                var cellA = a.querySelector('td.' + column);
                var cellB = b.querySelector('td.' + column);

                if (cellA && cellB) {
                    var valueA = cellA.textContent.toLowerCase();
                    var valueB = cellB.textContent.toLowerCase();

                    if (valueA < valueB) {
                        return sortType === 'asc' ? -1 : 1;
                    } else if (valueA > valueB) {
                        return sortType === 'asc' ? 1 : -1;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            });

            for (var i = 0; i < rows.length; i++) {
                table.tBodies[0].appendChild(rows[i]);
            }

            // Mettre à jour l'icône de tri
            var sortIconClass = sortType === 'asc' ? 'fa-sort-up' : 'fa-sort-down';
            for (var i = 0; i < triHeaders.length; i++) {
                let currentSortIcon = triHeaders[i].querySelector('.tri-icon');
                currentSortIcon.classList.remove('fa-sort-up', 'fa-sort-down');
            }
            sortIcon.classList.add(sortIconClass);
        }
    });
</script>

<?php require_once '../inc/backfooter.inc.php'; ?>