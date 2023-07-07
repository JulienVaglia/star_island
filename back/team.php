<?php require_once '../config/function.php';



?>
<?php require_once '../inc/backheader.inc.php';
?>

<div class="container">
    <!-- Formulaires -->
    <form action="" method="post" enctype="multipart/form-data" class="w-25  mt-5 mb-5 form-container">

        <!-- Nickname -->
        <div class="form-group">
            <small class="text-danger">*</small>
            <label for="title_media" class="form-label mt-3">Nickname</label>
            <input name="title_media" id="title_media" placeholder="Entrez le nickname ici" type="text" value="<?= $media['title_media'] ?? ''; ?>" class="form-control">
            <small class="text-danger"><?= isset($errors['title_media']) ? $errors['title_media'] : ''; ?></small>
        </div>

        <!-- Rôle -->
        <div class="form-group mx-auto">
            <small class="text-danger">*</small>
            <label for="id_media_type" class="mt-3">Rôle</label><br>
            <select id="id_media_type" name="id_media_type">
                <option value="<?= $media['id_media_type'] ?? ''; ?>"> --Choisir un rôle-- </option>
                <option value="<?= $media['id_media_type'] ?? ''; ?>"> Admin </option>
                <option value="<?= $media['id_media_type'] ?? ''; ?>"> Staff - Modérateurs </option>
                <option value="<?= $media['id_media_type'] ?? ''; ?>"> Développeurs </option>
                <option value="<?= $media['id_media_type'] ?? ''; ?>"> Mappers </option>
                <option value="<?= $media['id_media_type'] ?? ''; ?>"> Helpers </option>
            </select><br>
            <small class="text-danger"><?= isset($errors['id_media_type']) ? $errors['id_media_type'] : ''; ?></small><br>
        </div>

        <!-- File du média -->
        <div class="form-group" id="image">
            <small class="text-danger">*</small>
            <label for="image" class="form-label">Sélectionnez un fichier :</label><br>
            <input type="file" name="image" class="file-input"><br>
            <small class="text-danger"><?= isset($errors['image']) ? $errors['image'] : ''; ?></small>
        </div>

        <input type="hidden" name="id_media" value="<?= $media['id_media'] ?? ''; ?>">
        <input type="hidden" name="media_type" value="<?= $media['title_media_type'] ?? ''; ?>">

        <button type="submit" class="btn btn-primary mt-2 mx-auto">Créer votre profil</button>
    </form>


    <div class="preview-container">
        <h2 class="mb-10wh">Aperçu</h2>

        <div class="col-2 img_ligne1">
            <img src="../assets/img/ellios.png" alt="">
            <h4>Keyser Soze</h4>
        </div>
    </div>

</div>
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
                            <a href="?id=<?= $media['id_media']; ?>&a=edit" class="btn btn-outline-info">Modifier</a>
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




<style>
    .img_ligne1 {
        width: 15vw;
    }

    h4 {
        position: relative;
        left: 20vw;
        bottom: 50vh;
        font-size: 45px;
        color: white;
    }

    h2{
        text-align: center;
    
    }

    .img_ligne1 img {
        -webkit-clip-path: polygon(50% 0%, 91% 75%, 50% 100%, 9% 75%);
        clip-path: polygon(50% 0%, 91% 75%, 50% 100%, 9% 75%);
        width: 15vw;
    }

    .container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .form-container {
        width: 50%;
    }

    .preview-container {
        width: 50%;
    }
</style>