<?php
require_once '../config/function.php';
require_once '../inc/backheader.inc.php';

$errors = array();

if (!empty($_POST)) {

    if (empty($_POST['nickname_team'])) {
        $errors[] = 'Choix du pseudo obligatoire';
    }

    if (empty($_POST['role_team'])) {
        $errors[] = 'Choix du rôle obligatoire';
    }

    if (empty($errors)) {

        // Insertion des données dans la table "team"
        $nickname_team = $_POST['nickname_team'];
        $role_team = $_POST['role_team'];

        $teamId = execute("INSERT INTO team (nickname_team, role_team) VALUES (:nickname_team, :role_team)", array(
            ':nickname_team' => $nickname_team,
            ':role_team' => $role_team
        ), true);


        // Insertion des données dans la table "media"
        $title_media = $nickname_team;
        $name_media = $_POST['role_team'];

        $mediaId = execute("INSERT INTO media (title_media, name_media) VALUES (:title_media, :name_media)", array(
            ':title_media' => $title_media,
            ':name_media' => $name_media
        ), true);

        // Insertion des données dans la table intermédiaire "team_media"
        execute("INSERT INTO team_media (id_team, id_media) VALUES (:id_team, :id_media)", array(
            ':id_team' => $teamId,
            ':id_media' => $mediaId
        ));

        $_SESSION['messages']['success'][] = 'Profil ajouté';
        header('location:./team.php');
        exit();
    }
}

// Requête avec jointure pour récupérer les données de team avec leurs médias associés ( media )
$profils = execute("
    SELECT team.nickname_team, team.role_team, media.title_media, media.name_media
    FROM team
    JOIN team_media ON team.id_team = team_media.id_team
    JOIN media ON media.id_media = team_media.id_media
")->fetchAll(PDO::FETCH_ASSOC);

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


        <!-- Avatar -->
        <div class="form-group mx-4 my-3" id="avatar">
            <small class="text-danger">*</small>
            <label for="avatar" class="form-label">Sélectionnez un avatar :</label><br>
            <input type="file" name="avatar" class="file-input"><br>
            <small class="text-danger"><?= isset($errors['avatar']) ? $errors['avatar'] : ''; ?></small>
        </div>

        <br>


        <!-- Réseaux sociaux -->
        <div class="mx-4" id="reseaux_sociaux">
            <small class="text-danger">*</small>
            <label class="mb-3" for="reseaux">Sélectionnez les réseaux :</label>

            <label class="mx-4 my-1" for="discord">
                <input type="checkbox" id="discord" value="discord" onclick="champs_reseau('discord')"> &nbsp;
                <img src="../assets/icon/logo discord.png" alt="Discord"> Discord
            </label>
            <input class="input_reseaux" type="text" id="input_discord" name="selection['discord']" placeholder="Saisir l'adresse Discord">

            <label class="mx-4 my-1" for="twitch">
                <input type="checkbox" id="twitch" value="twitch" onclick="champs_reseau('twitch')"> &nbsp;
                <img src="../assets/icon/twitch.png" alt="Twitch"> Twitch
            </label>
            <input class="input_reseaux" type="text" id="input_twitch" name="selection['twitch']" placeholder="Saisir l'adresse Twitch">

            <label class="mx-4 my-1" for="youtube">
                <input type="checkbox" id="youtube" value="youtube" onclick="champs_reseau('youtube')"> &nbsp;
                <img src="../assets/icon/youtube.png" alt="Youtube"> Youtube
            </label>
            <input class="input_reseaux" type="text" id="input_youtube" name="selection['Youtube']" placeholder="Saisir l'adresse Youtube">

            <label class="mx-4 my-1" for="tiktok">
                <input type="checkbox" id="tiktok" value="tiktok" onclick="champs_reseau('tiktok')"> &nbsp;
                <img src="../assets/icon/tiktok.png" alt="Tiktok"> Tiktok
            </label>
            <input class="input_reseaux" type="text" id="input_tiktok" name="selection['Tiktok']" placeholder="Saisir l'adresse Tiktok">

            <label class="mx-4 my-1" for="facebook">
                <input type="checkbox" id="facebook" value="facebook" onclick="champs_reseau('facebook')"> &nbsp;
                <img src="../assets/icon/facebook.png" alt="Facebook"> Facebook
            </label>
            <input class="input_reseaux" type="text" id="input_facebook" name="selection['Facebook']" placeholder="Saisir l'adresse Facebook">

            <label class="mx-4 my-1" for="instagram">
                <input type="checkbox" id="instagram" value="instagram" onclick="champs_reseau('instagram')"> &nbsp;
                <img src="../assets/icon/instagram.png" alt="Instagram"> Instagram
            </label>
            <input class="input_reseaux" type="text" id="input_instagram" name="selection['Instagram']" placeholder="Saisir l'adresse Instagram">

            <label class="mx-4 my-1" for="twitter">
                <input type="checkbox" id="twitter" value="twitter" onclick="champs_reseau('twitter')"> &nbsp;
                <img src="../assets/icon/twitter.png" alt="Twitter"> Twitter
            </label>
            <input class="input_reseaux" type="text" id="input_twitter" name="selection['Twitter']" placeholder="Saisir l'adresse Twitter">

            <small class="text-danger"><?= isset($errors['reseau']) ? $errors['reseau'] : ''; ?></small>
        </div>

    
        <button type="submit" class="mt-3 ms-5 btn btn-primary mx-5">Créer le profil
        </button>

    </form>
    <!-- Fin Formulaires -->


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
        <?php foreach ($profils as $profil) : ?>

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



<!-- Javascript -->
<script>
                function champs_reseau(checkboxId) {
                    let checkbox = document.getElementById(checkboxId);
                    let input = document.getElementById('input_' + checkboxId);

                    if (checkbox.checked) {
                        input.style.display = 'block';
                    } else {
                        input.style.display = 'none';
                    }
                }
            </script>



<!-- CSS -->
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

    button {
        position: relative;
        left: 23vw;
        bottom: 34vh;
    }

    ::placeholder {
        padding-left: 0.5vw;
        margin-bottom: 0.5vh;
    }

    #reseaux_sociaux input {
        margin-bottom: 0.8vh;
    }

    .input_reseaux {
        display: none;
    }

    .input_reseaux {
        display: none;
    }

    label img {
        width: 1.5vw;
        height: auto;
    }
</style>