<?php
require_once '../config/function.php';
require_once '../inc/backheader.inc.php';

if ((!empty($_POST) && !empty($_FILES))) {
    die('coucou');
    if (empty($_POST['nickname_team'])) {
        $errors[] = 'Choix du pseudo obligatoire';
    }

    if (empty($_POST['role_team'])) {
        $errors[] = 'Choix du rôle obligatoire';
    }

    if (empty($_FILES['avatar']['name'])) {
        $errors[] = "Choix de l'avatar obligatoire";
    }

    if (empty($errors)) {
        $lastNickname_team = $pdo->lastInsertId();

        // Exécution de la requête d'insertion pour la table media
        $lastMediaId = $pdo->lastInsertId();

        $avatar_team = $pdo->execute("INSERT INTO media (id_media, title_media, name_media, id_media_type) VALUES (:id_media, :title_media, :name_media, :id_media_type)", array(
            ':id_media' => $lastMediaId,
            ':title_media' => $_POST['nickname_team'],
            ':name_media' => $_POST['role_team'],
            ':id_media_type' => $_POST['id_media_type']
        ));
        debug($avatar_team);

        // Récupérer l'ID du média inséré
        $id_media = $pdo->lastInsertId();

        // Insérer les données dans la table intermédiaire "team_media"
        $pdo->execute("INSERT INTO team_media (id_team, id_media) VALUES (:id_team, :id_media)", array(
            ':id_team' => $id_team,
            ':id_media' => $id_media
        ));
    }
}

//Jointure team et media par table intermédiaire team_media
$medias = $pdo->execute("
    SELECT team.nickname_team, team.role_team, media.title_media, media.name_media
    FROM team
    JOIN team_media ON team.id_team = team_media.id_team
    JOIN media ON media.id_media = team_media.id_media
")->fetchAll(PDO::FETCH_ASSOC);
debug($medias);
?>

<div class="container team w-75 rounded ">
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
        <div class="form-group mx-4 my-3" id="avatar">
            <small class="text-danger">*</small>
            <label for="avatar" class="form-label">Sélectionnez un avatar :</label><br>
            <input type="file" name="avatar" class="file-input"><br>
            <small class="text-danger"><?= isset($errors['avatar']) ? $errors['avatar'] : ''; ?></small>
        </div>

        <br>

        <div class="mx-4">
            <small class="text-danger">*</small>
            <label class="mb-3" for="reseaux">Sélectionnez les réseaux :</label>
            <form>
                <label class="mx-4 my-1" for="choix1"><input type="checkbox" id="choix1" name="selection[]" value="choix1"> &nbsp<img src="../assets/icon/logo discord.png" alt="Discord"> Discord</label>
                <label class="mx-4 my-1" for="choix2"><input type="checkbox" id="choix2" name="selection[]" value="choix2"> &nbsp<img src="../assets/icon/twitch.png" alt="twitch"> twitch </label>
                <label class="mx-4 my-1" for="choix3"><input type="checkbox" id="choix3" name="selection[]" value="choix3"> &nbsp<img src="../assets/icon/youtube.png" alt="Youtube"> Youtube</label>
                <label class="mx-4 my-1" for="choix4"><input type="checkbox" id="choix4" name="selection[]" value="choix4"> &nbsp<img src="../assets/icon/tiktok.png" alt="Tiktok"> Tiktok</label>
                <label class="mx-4 my-1" for="choix5"><input type="checkbox" id="choix5" name="selection[]" value="choix5"> &nbsp<img src="../assets/icon/facebook.png" alt="Facebook"> Facebook</label>
                <label class="mx-4 my-1" for="choix6"><input type="checkbox" id="choix6" name="selection[]" value="choix6"> &nbsp<img src="../assets/icon/instagram.png" alt="Instagram"> Instagram</label>
                <label class="mx-4 my-1" for="choix7"><input type="checkbox" id="choix7" name="selection[]" value="choix7"> &nbsp<img src="../assets/icon/twitter.png" alt="Instagram"> Twitter</label>
                <style>
                    label img {
                        width: 1.5vw;
                        height: auto;
                    }
                </style>
            </form>
            <small class="text-danger"><?= isset($errors['reseau']) ? $errors['reseau'] : ''; ?></small>
        </div>
        <!-- Fin Formulaires -->

        <button type="submit" class="btn btn-primary mx-5">Créer le profil
            <style>
                button {
                    position: relative;
                    margin-top: 35vh;
                    left: 4vw;
                }
            </style>
        </button>

    </form>


    <!-- Apercu -->
    <div class="preview-container mt-5">
        <h2 class="mt-5 mb-5">Aperçu</h2>
        <div class="img_ligne1 mx-auto">
            <img src="../assets/img/ellios.png" alt="">
            <h4 class="text-center">Keyser Soze</h4>
        </div>
        <style>
            .img_ligne1 {
                position: relative;
                top: 5vh;
                width: 15vw;
            }

            h4 {
                position: relative;
                bottom: 12vh;
                font-size: 25px;
                color: white;
                text-shadow: 1px 0 0 rgb(0, 0, 0), 1px 1px 0 rgb(0, 0, 0), 0 1px 0 rgb(0, 0, 0), -1px 1px 0 rgb(0, 0, 0), -1px 0 0 rgb(0, 0, 0), -1px -1px 0 rgb(0, 0, 0), 0 -1px 0 rgb(0, 0, 0), 1px -1px 0 rgb(0, 0, 0);
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
            <th class="text-center tri w-25" data-column="reseaux-media">Réseaux
                <i class="fas fa-sort tri-icon"></i>
                <div class="dropdown">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-sort="asc">Trier par ordre croissant</a></li>
                        <li><a class="dropdown-item" href="#" data-sort="desc">Trier par ordre décroissant</a></li>
                    </ul>
                </div>
            </th>
            <th class="text-center w-50">Avatar</th>
            <th class="text-center w-25">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medias as $media) : ?>

            <tr>
                <td class="text-center tri type-media"><?= $team['nickname_team']; ?></td>
                <td class="text-center tri nom-media"><?= $team['role_team']; ?></td>
                <td class="text-center">

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
        width: 60%;
    }

    .preview-container {
        width: 40%;
    }
</style>