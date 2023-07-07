<?php require_once '../config/function.php';
require_once '../inc/backheader.inc.php';


if ((!empty($_POST) && !empty($_FILES))) {

    if (empty($_POST['nickname_team'])) {
        $errors[] = 'Choix du pseudo obligatoire';
    }

    if (empty($_POST['role_team'])) {
        $errors[] = 'Choix du rôle obligatoire';
    }

    if (empty($_FILES['image']['name']) && empty($_POST['lien_media'])) {
        $errors[] = "Choix de l'avatar obligatoire";
    }

    if (empty($errors)) {

        $lastNickname_team = execute("SELECT m.*, p.*, mt.* FROM media m INNER JOIN page p ON m.id_page = p.id_page INNER JOIN media_type mt ON m.id_media_type = mt.id_media_type")->fetchAll(PDO::FETCH_ASSOC);

        $last_team = execute("SELECT m.*, p.*, mt.* FROM media m INNER JOIN page p ON m.id_page = p.id_page INNER JOIN media_type mt ON m.id_media_type = mt.id_media_type")->fetchAll(PDO::FETCH_ASSOC);
    }
}




?>

<div class="container team w-75 ">
    <!-- Formulaires -->
    <form action="" method="post" enctype="multipart/form-data" class="w-25 mt-5 mb-5 form-container">

        <!-- Nickname -->
        <div class="form-group mx-4">
            <small class="text-danger">*</small>
            <label for="nickname_team" class="form-label">Nickname</label>
            <input name="nickname_team" id="nickname_team" placeholder="Entrez le nickname ici" type="text" value="<?= $media['nickname_team'] ?? ''; ?>" class="form-control">
            <small class="text-danger"><?= isset($errors['nickname_team']) ? $errors['nickname_team'] : ''; ?></small>
        </div>

        <!-- Rôle -->
        <div class="form-group mx-4">
            <small class="text-danger">*</small>
            <label for="role_team" class="mt-3">Rôle</label><br>
            <select id="role_team" name="role_team">
                <option value="<?= $team['role_team'] ?? ''; ?>"> --Choisir un rôle-- </option>
                <option value="<?= $team['role_team'] ?? ''; ?>"> Admin </option>
                <option value="<?= $team['role_team'] ?? ''; ?>"> Staff - Modérateurs </option>
                <option value="<?= $team['role_team'] ?? ''; ?>"> Développeurs </option>
                <option value="<?= $team['role_team'] ?? ''; ?>"> Mappers </option>
                <option value="<?= $team['role_team'] ?? ''; ?>"> Helpers </option>
            </select><br>
            <small class="text-danger"><?= isset($errors['role_team']) ? $errors['role_team'] : ''; ?></small><br>
        </div>

        <!-- File du média -->
        <div class="form-group mx-4 my-3" id="image">
            <small class="text-danger">*</small>
            <label for="image" class="form-label">Sélectionnez un avatar :</label><br>
            <input type="file" name="image" class="file-input"><br>
            <small class="text-danger"><?= isset($errors['image']) ? $errors['image'] : ''; ?></small>
        </div>

        <form>
            <label class="mx-4" for="choix1"><input type="checkbox" id="choix1" name="selection[]" value="choix1"> &nbsp<img src="../assets/icon/logo discord.png" alt="Discord"> Discord</label>
            <label class="mx-4" for="choix2"><input type="checkbox" id="choix2" name="selection[]" value="choix2"> &nbsp<img src="../assets/icon/twitch.png" alt="twitch"> twitch </label>
            <label class="mx-4" for="choix3"><input type="checkbox" id="choix3" name="selection[]" value="choix3"> &nbsp<img src="../assets/icon/youtube.png" alt="Youtube"> Youtube</label>
            <label class="mx-4" for="choix4"><input type="checkbox" id="choix4" name="selection[]" value="choix2"> &nbsp<img src="../assets/icon/tiktok.png" alt="Tiktok"> Tiktok</label>
            <style>
                label img {
                    width: 1.5vw;
                    height: auto;
                }
            </style>
        </form>
        <!-- Fin Formulaires -->


        <input type="hidden" name="id_media" value="<?= $media['id_media'] ?? ''; ?>">
        <input type="hidden" name="media_type" value="<?= $media['nickname_team_type'] ?? ''; ?>">

        <button type="submit" class="btn btn-primary mx-5">Créer le profil
            <style>
                button {
                    margin-top: 23vh;
                }
            </style>
        </button>

    </form>


    <!-- Apercu -->
    <div class="preview-container">
        <h2 class="mt-4 mb-5">Aperçu</h2>
        <div class="img_ligne1 mx-auto">
            <img src="../assets/img/ellios.png" alt="">
            <h4 class="text-center">Keyser Soze</h4>
        </div>
        <style>
            .img_ligne1 {
                width: 15vw;
            }

            h4 {
                position: relative;
                font-size: 25px;
                color: black;
            }

            h2 {
                text-align: center;
            }

            .img_ligne1 img {
                -webkit-clip-path: polygon(50% 0%, 91% 75%, 50% 100%, 9% 75%);
                clip-path: polygon(50% 0%, 91% 75%, 50% 100%, 9% 75%);
                width: 15vw;
            }
        </style>
    </div>
    <!-- Fin Apercu -->

</div>

<input type="hidden" name="nickname_team" value="<?= $team['nickname_team'] ?? ''; ?>">
<input type="hidden" name="role_team" value="<?= $team['role_team'] ?? ''; ?>">


<!-- Tableau récapitulatif -->
<table class="table mt-5 table-dark table-striped w-75 mx-auto">
    <thead>
        <tr>
            <th class="text-center tri w-25" data-column="type-media">Nickname
                <i class="fas fa-sort tri-icon"></i>
                <div class="dropdown">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-sort="asc">Trier par ordre croissant</a></li>
                        <li><a class="dropdown-item" href="#" data-sort="desc">Trier par ordre décroissant</a></li>
                    </ul>
                </div>
            </th>
            <th class="text-center tri w-25" data-column="nom-media">Rôle
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
        <?php foreach ($medias as $media) : ?>

            <tr>
                <td class="text-center tri type-media"><?= $team['nickname_team']; ?></td>
                <td class="text-center tri nom-media"><?= $team['role_team']; ?></td>
                <td class="text-center">
                    <img src="media-upload/<?= $media['nickname_team_type'] ?>/<?= $media['name_media'] ?>" alt="<?= $media['nickname_team'] ?>" width="70" height="70" class="media-preview" data-src="media-upload/<?= $media['nickname_team_type'] ?>/<?= $media['name_media'] ?>">
                </td>

                <!-- Btn Modifier -->
                <td>
                    <a href="?id=<?= $team['id_team']; ?>&a=edit" class="btn btn-outline-info">Modifier</a>
                </td>

                <!-- Btn Supprimer -->
                <td class="text-center">
                    <a href="?id=<?= $team['id_team']; ?>&a=del" onclick="return confirm('Etes-vous sûr?')" class="btn btn-outline-danger">Supprimer</a>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>




<style>
    .team {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .form-container {
        width: 50%;
    }

    .preview-container {
        width: 50%;
    }
</style>