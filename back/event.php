<?php
require_once '../config/function.php';

$errors = array();

if (!empty($_POST)) {

    if (empty($_POST['title_event'])) {
        $errors[] = 'Titre obligatoire';
    }

    if (empty($_POST['description_event'])) {
        $errors[] = 'Description obligatoire';
    }

    if (empty($_POST['date_debut']) || empty($_POST['date_fin'])) {
        $errors[] = 'Dates obligatoires';
    }

    if (empty($_FILES['image_event']['name'])) {
        $errors[] = 'Choix du fichier obligatoire';
    }

    if (empty($errors)) {


        // INSERTION

        $titre = $_POST['title_event'];
        $description = $_POST['description_event'];
        $image = uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . '_' . $_FILES['image_event']['name'];

        copy($_FILES['image_event']['tmp_name'], 'media-upload/image_event/' . $image);

        $idMt = execute("SELECT * FROM media_type WHERE id_media_type = 15")->fetch(PDO::FETCH_ASSOC);

        $start_date_event = $_POST['date_debut'];
        $end_date_event = $_POST['date_fin'];
        $chemin = $idMt['title_media_type'];
        $id_chemin = $idMt['id_media_type'];

        debug($chemin);
        debug($idMt);


        // Insertion dans la table Event
        $eventId = execute("INSERT INTO event (start_date_event, end_date_event) VALUES (:start_date_event, :end_date_event)", array(
            ':start_date_event' => $start_date_event,
            ':end_date_event' => $end_date_event
        ), true);

        // Insertion dans la table Média
        $mediaId = execute("INSERT INTO media (title_media, name_media, id_media_type) VALUES (:title_media, :name_media, :id_media_type)", array(
            ':title_media' => $chemin,
            ':name_media' => $image,
            ':id_media_type' => $id_chemin

        ), true);

        debug($image);
        debug($mediaId);

        // Insertion table intermédiaire event_media
        execute("INSERT INTO event_media (id_event, id_media) VALUES (:id_event, :id_media)", array(
            ':id_event' => $eventId,
            ':id_media' => $mediaId
        ));

        //Insertion dans la table Content
        $contentId = execute("INSERT INTO content (title_content, description_content) VALUES (:title_content, :description_content)", array(
            ':title_content' => $titre,
            ':description_content' => $description
        ), true);

        // Insertion table intermédiaire event_content
        execute("INSERT INTO event_content (id_event, id_content) VALUES (:id_event, :id_content)", array(
            ':id_event' => $eventId,
            ':id_content' => $contentId
        ));

        $_SESSION['messages']['success'][] = 'Event ajouté';
        header('location:./event.php');
        exit();
    }
}

//FIN INSERTION

// SUPRESSION
if (!empty($_GET) && isset($_GET['id']) && isset($_GET['a']) && $_GET['a'] == 'del') {

    $eventId = $_GET['id'];
    $fileName = execute("SELECT *
    FROM event ev
    JOIN event_media em ON ev.id_event = em.id_event
    JOIN media m ON em.id_media = m.id_media
    JOIN content ct ON m.id_content = ct.id_content
    WHERE ev.id_event=:id_event AND mt.title_media_type=:title_media_type", array(
        ':id_event' => $_GET['id'],
        ':title_media_type' => 'avatar_event'
    ))->fetch(PDO::FETCH_ASSOC);
    debug($fileName);
    $file_path = "./media-upload/avatar_event/" . $fileName['name_media'];


    // Supprimer les infos dans la table "event_media"
    execute("DELETE FROM event_media WHERE id_event = :eventId", array(':eventId' => $eventId));

    // Supprimer les infos dans la table "media"
    execute("DELETE FROM media WHERE id_media IN (SELECT id_media FROM event_media WHERE id_event = :eventId)", array(':eventId' => $eventId));

    // Supprimer les infos dans la table "event_content"
    execute("DELETE FROM event_media WHERE id_event = :eventId", array(':eventId' => $eventId));

    // Supprimer les infos dans la table "content"
    execute("DELETE FROM media WHERE id_media IN (SELECT id_media FROM event_media WHERE id_event = :eventId)", array(':eventId' => $eventId));

    // Supprimer les infos de la table "event"
    $success_database = execute("DELETE FROM event WHERE id_event = :eventId", array(':eventId' => $eventId));


    // Supprimer le profil de l'arborescence
    $success_arborescence = unlink($file_path);


    if ($success_database && $success_arborescence) {
        $_SESSION['messages']['success'][] = 'Profil supprimé';
        header('location:./event.php');
        exit;
    } else {
        $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réitérer';
        header('location:./event.php');
        exit;
    }
}

require_once '../inc/backheader.inc.php';
?>



<div class="container event pb-4 w-50 rounded">
    <!-- Formulaires -->
    <form action="" method="post" enctype="multipart/form-data" class="w-100  pb-2 form-container">


        <!-- Titre -->
        <div class="form-group mb-4">
            <small class="text-danger">*</small>
            <label for="title_event" class="form-label mt-3">Titre de l'EVENT</label>
            <input name="title_event" id="title_event" placeholder="Entrez le nom ici" type="text" value="<?= $event['title_event'] ?? ''; ?>" class="form-control">
            <small class="text-danger"><?= isset($errors['title_event']) ? $errors['title_event'] : ''; ?></small>
        </div>

        <!-- Description -->
        <div class="form-group">

            <small class="text-danger">*</small>
            <label for="description_event" class="form-label">Description</label>
            <textarea rows="5" name="description_event" id="description_event" placeholder="Entrez votre description ici" value="<?= $event['description_event'] ?? ''; ?>" class="form-control w-100"></textarea>
            <small class="text-danger"><?= isset($errors['description_event']) ? $errors['description_event'] : ''; ?></small>

        </div>

        <!-- Dates -->
        <div action="traitement.php" method="post" class="mt-3">
            <small class="text-danger">*</small>
            <label for="date_debut">Date de début :</label>
            <input type="date" id="date_debut" name="date_debut" class="mr-5" value="<?= $event['date_debut'] ?? ''; ?>">
            <small class="text-danger"><?= isset($errors['date_debut']) ? $errors['date_debut'] : ''; ?></small>

            <small class="text-danger">*</small>
            <label for="date_fin">Date de fin :</label>
            <input type="date" id="date_fin" name="date_fin" value="<?= $event['date_fin'] ?? ''; ?>">
            <small class="text-danger"><?= isset($errors['date_fin']) ? $errors['date_fin'] : ''; ?></small>

        </div>


        <!-- Photo -->
        <div class="form-group mt-3 mb-3" id="image_event">
            <small class="text-danger">*</small>
            <label for="image_event" class="form-label mt-4">Sélectionnez une image :</label><br>
            <input type="file" name="image_event" class="file-input"><br>
            <small class="text-danger"><?= isset($errors['image_event']) ? $errors['image_event'] : ''; ?></small>
        </div>

        <br>

        <button type="submit" class="mt-3 ms-5 btn btn-primary w-100">Créer l'EVENT</button>

    </form>
    <!-- Fin Formulaires -->

</div>

<input type="hidden" name="title_event" value="<?= $event['title_event'] ?? ''; ?>">
<input type="hidden" name="date_debut" value="<?= $event['description_event'] ?? ''; ?>">
<input type="hidden" name="date_debut" value="<?= $event['date_debut'] ?? ''; ?>">
<input type="hidden" name="date_fin" value="<?= $event['date_fin'] ?? ''; ?>">



<!-- Tableau récapitulatif -->
<table class="table mt-5 table-dark table-striped w-75 mx-auto">
    <thead>
        <tr>

            <th class="text-center tri w-25" data-column="nickname-event">Titre</th>

            <th class="text-center tri w-25" data-column="role-event">Dates</th>

            <th class="text-center tri w-25" data-column="reseaux-event">Photo</th>

            <th class="text-center w-25">Titre et description</th>

            <th class="text-center w-25">Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center tri nickname-event"></td>
            <td class="text-center tri role-event"></td>
            <td class="text-center tri reseaux-event"></td>
            <td class="text-center apercu"></td>

            <!-- Btn Modifier -->
            <td>
                <a href="?id=<?= $profil['id_event']; ?>&a=edit" class="btn btn-outline-info">Modifier</a>
            </td>


            <!-- Btn Supprimer  -->
            <td class="text-center">
                <a href="?id=<?= $profil['id_event']; ?>&a=del" onclick="return confirm('Êtes-vous sûr(e) ?')" class="btn btn-outline-danger">Supprimer</a>
            </td>
        </tr>
    </tbody>
</table>

<!-- CSS -->
<style>
    .event {
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .preview-container {
        width: 40%;
    }

    ::placeholder {
        padding-left: 0.5vw;
        margin-bottom: 0.5vh;
    }

    label img {
        width: 1.5vw;
        height: auto;
    }

    .apercu img {
        width: 5vw;
        height: auto;
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
</style>