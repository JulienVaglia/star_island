<?php
require_once '../config/function.php';


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


        // traitement de l'avatar complet if photo soumise else random 
        if (!empty($_FILES['avatar']['name'])) {

            // Créer des sous dossiers en fonction du type média
            if (!file_exists('media-upload/avatar_team')) {
                mkdir('media-upload/avatar_team', 777);
            }

            $chemin = uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . '_' . $_FILES['avatar']['name'];

            copy($_FILES['avatar']['tmp_name'], 'media-upload/avatar_team' . '/' . $chemin);


            $idMt = 13;
        } else {



            $avatars = array_diff(scandir("./media-upload/avatar_random"), array('..', '.'));
            $randomIndex = array_rand($avatars, 1);

            $chemin  = $avatars[$randomIndex];

            $idMt = 14;
        }
        //  fin avatar

        $mediaId = execute("INSERT INTO media (title_media, name_media, id_media_type) VALUES (:title_media, :name_media, :id_media_type)", array(
            ':title_media' => 'avatar-' . $_POST['nickname_team'],
            ':name_media' => $chemin,
            ':id_media_type' => $idMt
        ), true);

        execute("INSERT INTO team_media (id_team, id_media) VALUES (:id_team, :id_media)", array(
            ':id_team' => $teamId,
            ':id_media' => $mediaId
        ));

        $profils = execute("SELECT * FROM team")->fetchAll(PDO::FETCH_ASSOC);



        foreach ($_POST['selection'] as $reseau => $lien) {

            if (!empty($lien)) {
                $mediaId = execute("INSERT INTO media (title_media, name_media, id_media_type) VALUES (:title_media, :name_media, :id_media_type)", array(
                    ':title_media' => 'lien-' . $reseau . '-' . $_POST['nickname_team'],
                    ':name_media' => $lien,
                    'id_media_type' => 11
                ), true);


                execute("INSERT INTO team_media (id_team, id_media) VALUES (:id_team, :id_media)", array(
                    ':id_team' => $teamId,
                    ':id_media' => $mediaId
                ));
            }
        }

        $_SESSION['messages']['success'][] = 'Profil ajouté';
        header('location:./team.php');
        exit();
    }
}



// Suppression
if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'del') {

    $teamId = $_GET['id'];
    $fileName = execute("SELECT *
    FROM team t
    JOIN team_media tm ON t.id_team = tm.id_team
    JOIN media m ON tm.id_media = m.id_media
    JOIN media_type mt ON m.id_media_type = mt.id_media_type
    WHERE t.id_team=:id_team AND mt.title_media_type=:title_media_type", array(
        ':id_team' => $_GET['id'],
        ':title_media_type' => 'avatar_team'
    ))->fetch(PDO::FETCH_ASSOC);
    debug($fileName);
    $file_path = "./media-upload/avatar_team/" . $fileName['name_media'];



    // Supprimer les enregistrements dans la table "team_media" liés à l'équipe
    execute("DELETE FROM team_media WHERE id_team = :teamId", array(':teamId' => $teamId));

    // Supprimer les enregistrements dans la table "media" liés à l'équipe
    execute("DELETE FROM media WHERE id_media IN (SELECT id_media FROM team_media WHERE id_team = :teamId)", array(':teamId' => $teamId));

    // Supprimer le profil de la table "team"
    $success_database = execute("DELETE FROM team WHERE id_team = :teamId", array(':teamId' => $teamId));

    // Supprimer le profil de l'arborescence
    $success_arborescence = unlink($file_path);


    if ($success_database && $success_arborescence) {
        $_SESSION['messages']['success'][] = 'Profil supprimé';
        header('location:./team.php');
        exit;
    } else {
        $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réitérer';
        header('location:./team.php');
        exit;
    }
}

require_once '../inc/backheader.inc.php';

// Requête avec jointure pour récupérer les données de team avec leurs médias associés ( media )
$profils = execute(
    "SELECT DISTINCT team.id_team, team.nickname_team, team.role_team
        FROM team"
)->fetchAll(PDO::FETCH_ASSOC);
?>



<div class="container team w-75 rounded ">
    <!-- Formulaires -->
    <form action="" method="post" enctype="multipart/form-data" class="w-25 mt-5 mb-5 form-container">


        <!-- Nickname -->
        <div class="form-group mx-4">
            <small class="text-danger">*</small>
            <label for="nickname_team" class="form-label">Nickname</label>
            <input name="nickname_team" id="nickname_team" placeholder="Entrez le nickname ici" type="text" value="<?= $team['nickname_team'] ?? ''; ?>" class="form-control">
            <small class="text-danger"><?= isset($errors['nickname_team']) ? $errors['nickname_team'] : ''; ?></small>
        </div>


        <!-- Rôle -->
        <div class="form-group mx-4">
            <small class="text-danger">*</small>
            <label for="role_team" class="mt-3">Rôle</label><br>
            <select id="role_team" name="role_team">
                <option selected disabled> --Choisir un rôle-- </option>
                <option value="Admin"> Admin </option>
                <option value="Staff - Modérateurs"> Staff - Modérateurs </option>
                <option value="Développeurs"> Développeurs </option>
                <option value="Mappers"> Mappers </option>
                <option value="Helpers"> Helpers </option>

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
                <img src="../assets/icon/logo discord.png" alt="discord"> discord
            </label>
            <input class="input_reseaux" type="text" id="input_discord" name="selection[discord]" placeholder="Saisir l'adresse discord">

            <label class="mx-4 my-1" for="twitch">
                <input type="checkbox" id="twitch" value="twitch" onclick="champs_reseau('twitch')"> &nbsp;
                <img src="../assets/icon/twitch.png" alt="twitch"> Twitch
            </label>
            <input class="input_reseaux" type="text" id="input_twitch" name="selection[twitch]" placeholder="Saisir l'adresse Twitch">

            <label class="mx-4 my-1" for="youtube">
                <input type="checkbox" id="youtube" value="youtube" onclick="champs_reseau('youtube')"> &nbsp;
                <img src="../assets/icon/youtube.png" alt="youtube"> Youtube
            </label>
            <input class="input_reseaux" type="text" id="input_youtube" name="selection[youtube]" placeholder="Saisir l'adresse Youtube">

            <label class="mx-4 my-1" for="tiktok">
                <input type="checkbox" id="tiktok" value="tiktok" onclick="champs_reseau('tiktok')"> &nbsp;
                <img src="../assets/icon/tiktok.png" alt="tiktok"> Tiktok
            </label>
            <input class="input_reseaux" type="text" id="input_tiktok" name="selection[tiktok]" placeholder="Saisir l'adresse Tiktok">

            <label class="mx-4 my-1" for="facebook">
                <input type="checkbox" id="facebook" value="facebook" onclick="champs_reseau('facebook')"> &nbsp;
                <img src="../assets/icon/facebook.png" alt="facebook"> Facebook
            </label>
            <input class="input_reseaux" type="text" id="input_facebook" name="selection[facebook]" placeholder="Saisir l'adresse Facebook">

            <label class="mx-4 my-1" for="instagram">
                <input type="checkbox" id="instagram" value="instagram" onclick="champs_reseau('instagram')"> &nbsp;
                <img src="../assets/icon/instagram.png" alt="instagram"> Instagram
            </label>
            <input class="input_reseaux" type="text" id="input_instagram" name="selection[instagram]" placeholder="Saisir l'adresse Instagram">

            <label class="mx-4 my-1" for="twitter">
                <input type="checkbox" id="twitter" value="twitter" onclick="champs_reseau('twitter')"> &nbsp;
                <img src="../assets/icon/twitter.png" alt="twitter"> Twitter
            </label>
            <input class="input_reseaux" type="text" id="input_twitter" name="selection[twitter]" placeholder="Saisir l'adresse Twitter">

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

    </div>
    <!-- Fin Apercu -->

</div>

<input type="hidden" name="nickname_team" value="<?= $team['nickname_team'] ?? ''; ?>">
<input type="hidden" name="role_team" value="<?= $team['role_team'] ?? ''; ?>">


<!-- Tableau récapitulatif -->
<table class="table mt-5 table-dark table-striped w-75 mx-auto">
    <thead>
        <tr>
            <th class="text-center tri w-25" data-column="nickname-team">
                Pseudo
                <i class="fas fa-sort tri-icon"></i>
            </th>
            <th class="text-center tri w-25" data-column="role-team">
                Rôle
                <i class="fas fa-sort tri-icon"></i>
            </th>
            <th class="text-center tri w-25" data-column="reseaux-team">Réseaux</th>
            <th class="text-center w-25">Avatar</th>
            <th class="text-center w-25">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($profils as $profil) : ?>
            <?php

            $id_team = $profil['id_team'];
            $reseaux = execute("SELECT mt.*, m.*
        FROM team t
        JOIN team_media tm ON t.id_team = tm.id_team
        JOIN media m ON tm.id_media = m.id_media
        JOIN media_type mt ON m.id_media_type = mt.id_media_type
        WHERE t.id_team = :id_team AND mt.title_media_type='lien'", array(':id_team' => $id_team))->fetchAll(PDO::FETCH_ASSOC);

            $reseauxHtml = '';
            $reseauxFinal = '';
            foreach ($reseaux as $reseau) {

                $reseauxHtml .= $reseau['title_media'];
                $names_reseau = explode(',', $reseau['title_media']);
                $lien = explode('-', $reseau['title_media']);

                foreach ($names_reseau as $index => $name_reseau) {
                    $reseauxFinal .= $lien[1] . ' <br> ';
                }
            }
            ?>
            <?php ?>

            <tr>
                <td class="text-center tri nickname-team"><?= $profil['nickname_team']; ?></td>
                <td class="text-center tri role-team"><?= $profil['role_team']; ?></td>
                <td class="text-center tri reseaux-team"><?= $reseauxFinal; ?></td>
                <td class="text-center apercu">
                    <?php
                    $avatar = execute("SELECT * FROM team t
        JOIN team_media tm ON t.id_team = tm.id_team
        JOIN media m ON tm.id_media = m.id_media
        JOIN media_type mt ON m.id_media_type = mt.id_media_type
        WHERE t.id_team = :id_team AND mt.title_media_type=:title_media_type OR mt.title_media_type=:title_media_type_other", array(
                        ':id_team' => $id_team,
                        ':title_media_type' => 'avatar_team',
                        ':title_media_type_other' => 'avatar_random'
                    ))->fetch(PDO::FETCH_ASSOC);

                    if ($avatar['id_media_type'] == 14) {
                        echo "<img class='media-preview' src='media-upload/avatar_random/{$avatar['name_media']}' alt='prout'>";
                    } else {
                        echo "<img class='media-preview' src='media-upload/avatar_team/{$avatar['name_media']}' alt='Avatar'>";
                    }

                    ?>
                </td>

                <!-- Btn Modifier -->
                <!-- <td>
                    <a href="?id=<?= $profil['id_team']; ?>&a=edit" class="btn btn-outline-info">Modifier</a>
                </td> -->


                <!-- Btn Supprimer -->
                <td class="text-center">
                    <a href="?id=<?= $profil['id_team']; ?>&a=del" onclick="return confirm('Êtes-vous sûr(e) ?')" class="btn btn-outline-danger">Supprimer</a>
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

<script>
    // Fonction pour récupérer les liens des réseaux sociaux sélectionnés
    function getSelectedReseaux() {
        const selectedReseaux = document.querySelectorAll('input.input_reseaux:checked');
        const reseauxLogos = {};

        selectedReseaux.forEach((reseau) => {
            const reseauName = reseau.value;
            const inputId = `input_${reseauName}`;
            const inputElement = document.getElementById(inputId);

            if (inputElement) {
                const reseauLien = inputElement.value.trim();
                if (reseauLien) {
                    reseauxLogos[reseauName] = reseauLien;
                }
            }
        });

        return reseauxLogos;
    }

    function updateReseauxLogos() {
        const elementsReseau = document.querySelectorAll('.reseaux-team');

        elementsReseau.forEach((elementReseau) => {
            const reseauxHtml = elementReseau.innerHTML;
            const lignesReseaux = reseauxHtml.split('<br>');
            let reseauxFinal = '';

            lignesReseaux.forEach((ligneReseau) => {
                const nomReseau = ligneReseau.trim();
                const iconeReseau = getReseauIcon(nomReseau);

                if (iconeReseau) {
                    reseauxFinal += `<img src="../assets/icon/${iconeReseau}" class="reseau-icon" alt="${nomReseau}">`;
                } else {
                    reseauxFinal += `${ligneReseau}<br>`;
                }
            });

            elementReseau.innerHTML = reseauxFinal;
        });
    }

    // Exécute la fonction au chargement de la page
    window.addEventListener('DOMContentLoaded', updateReseauxLogos);


    // Exécuter la fonction au chargement de la page
    window.addEventListener('DOMContentLoaded', updateReseauxLogos);
</script>


<script>
    function getReseauIcon(reseauName) {
        switch (reseauName) {
            case 'discord':
                return 'logo discord.png';
            case 'twitch':
                return 'twitch.png';
            case 'youtube':
                return 'youtube.png';
            case 'tiktok':
                return 'tiktok.png';
            case 'facebook':
                return 'facebook.png';
            case 'instagram':
                return 'instagram.png';
            case 'twitter':
                return 'twitter.png';
            default:
                return '';
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

    .apercu img {
        width: 5vw;
        height: auto;
    }

    /* CSS : apercu icone réseaux sociaux  */
    .reseau-icon {
        width: 30px;
        height: auto;
        vertical-align: middle;
        margin-right: 5px;
    }

    /* CSS : apercu plein écran  */
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


<!-- SCRIPT -->