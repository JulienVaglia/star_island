    <?php

    require_once 'config/function.php';
    require_once 'inc/header.inc.php';


    if (!empty($_POST)) {
        // debug($_POST);



        execute("INSERT INTO comment (publish_date_comment, nickname_comment, rating_comment, comment_text) VALUES (:publish_date_comment, :nickname_comment, :rating_comment, :comment_text)", array(
            ':publish_date_comment' => date_format(new DateTime(), 'Y-m-d'),
            ':nickname_comment' => $_POST['nickname_comment'],
            ':rating_comment' => $_POST['rating_comment'],
            ':comment_text' => $_POST['comment_text']
        ));

        $_SESSION['comment_success'] = true; // Stocker le succès de la soumission du commentaire
        header('location:./index.php');
        exit();
    }

    //Avatar random pour les commentaires
    $avatar_comment = execute(
        "SELECT *
        FROM media m 
        INNER JOIN media_type mt ON m.id_media_type = mt.id_media_type 
        WHERE title_media_type = 'avatar_comment'")->fetchAll(PDO::FETCH_ASSOC);

    ?>



    <main>

        <link rel="stylesheet" href="assets/css/style_index.scss">
        <link rel="stylesheet" href="assets/css/style_gallerie.scss">

        <section class="bloc1">

            <h1>Bienvenue sur Star'Island</h1>

            <!-- --------- Carroussel principal --------- -->

            <div class="slider">
                <input type="radio" name="toggle" id="btn-1" checked>
                <input type="radio" name="toggle" id="btn-2">
                <input type="radio" name="toggle" id="btn-3">

                <div class="slider-controls">
                    <label for="btn-1"></label>
                    <label for="btn-2"></label>
                    <label for="btn-3"></label>
                </div>

                <ul class="slides">

                    <!-- Slide 1 Texte -->

                    <li class="slide">
                        <p class="slide-image" id="texte">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Et temporibus doloremque, culpa illum quibusdam eum eaque in voluptatibus aperiam blanditiis magni ea atque qui! A culpa corporis fuga eum ipsam.
                            Fugit enim soluta sunt magnam omnis, possimus, porro autem facere necessitatibus distinctio consequuntur impedit, quam laborum hic fugiat mollitia! Distinctio corporis laboriosam velit cum quis labore cupiditate praesentium, tempora ipsam?
                        </p>
                    </li>

                    <!-- Slide 2 Carroussel -->

                    <li class="slide">
                        <p class="slide-image">
                        <div class="container2">
                            <input type="radio" name="slider" id="item-1" checked>
                            <input type="radio" name="slider" id="item-2">
                            <input type="radio" name="slider" id="item-3">
                            <div class="cards">
                                <label class="card" for="item-1" id="song-1">
                                    <img src="assets/img/carrouseelme.jpg" alt="img">
                                </label>
                                <label class="card" for="item-2" id="song-2">
                                    <img src="assets/img/carrouseele 2.jpg" alt="img">
                                </label>
                                <label class="card" for="item-3" id="song-3">
                                    <img src="assets/img/carrousssel 8.jpg" alt="img">
                                </label>
                            </div>

                        </div>
                        </p>
                    </li>

                    <!-- Slide 3 API Top serveur -->

                    <li class="slide">
                        <p class="slide-image" id="api">
                            3 - API Top Serveur
                        </p>
                    </li>
                </ul>
            </div>

            <div class="fondu1"></div>
        </section>


        <?php
        require_once 'inc/barre_lien.inc.php';
        ?>

        <section class="bloc2">

            <!-- Avis client -->

            <?php
            $comments = execute("SELECT * FROM comment WHERE valid_comment = 1 ORDER BY publish_date_comment  DESC LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

            foreach ($comments as $index => $comment) :
                
        $i = rand(0, count($avatar_comment)-1);
                // Utiliser un index permet une incrémentation automatique
            ?>

                <div class=" container  ">

                    <div class="row justify-content-center justify-content-sm-start  <?php echo ($index % 2 == 0) ? 'flex-row' : 'flex-row-reverse'; ?>">
                        <!-- Permet l'affichage en décalé des bulles d'avis selon si l'index de $comment est pair ou impair -->
                       
                        <div class="bulle_avis  col-12 col-sm-5 d-flex align-items-center p-3 <?php echo ($index % 2 == 0) ? 'justify-content-end ' : 'justify-content-end flex-row-reverse ps-5'; ?> ">
                        
                        <img class="w-7" height="auto" src="./back/media-upload/avatar_comment/<?= $avatar_comment[$i]['name_media'] ?>" alt="" >
                            <div class="col-10 ">                               
                                <p><?= $comment['nickname_comment'] ?></p>
                                <div class="rating-stars ">
                                    <?php
                                    $rating = $comment['rating_comment'];

                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fas fa-star text-warning"></i>';
                                        } else {
                                            echo '<i class="fas fa-star text-dark"></i>';
                                        }
                                    }
                                    ?>
                                    <span></span> Publié le : <?= $comment['publish_date_comment'] ?>
                                </div>
                                <p><?= $comment['comment_text'] ?></p>                            
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <form method="post" class="bloc_avis">

                <h2 id="titre_commentaire">Votre avis nous intéresse</h2>

                <!-- Notation etoile -->

                <div class="d-flex justify-content-around mb-3 px-5 rating">
                    <i class="fas fa-star fa-2x star-avis"></i>
                    <i class="fas fa-star fa-2x star-avis"></i>
                    <i class="fas fa-star fa-2x star-avis"></i>
                    <i class="fas fa-star fa-2x star-avis"></i>
                    <i class="fas fa-star fa-2x star-avis"></i>
                </div>
                <input type="hidden" name="rating_comment" id="rating_comment">

                <input class="form-control w-50 mx-auto" type="text" name="nickname_comment" placeholder="Pseudo">

                <!-- Fin Notation etoile -->

                <textarea name="comment_text" id="comment_text" rows="10" placeholder="Ecrire votre commentaire"></textarea>
                <button type="submit" class="publier"> Publier </button>
            </form>

            <div class="fondu2"></div>

        </section>

    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Gestion des étoiles dans "votre avis nous interesse"
            const stars = document.querySelectorAll(".fas.fa-star.star-avis");

            for (let index = 0; index < stars.length; index++) {
                stars[index].classList.add('text-dark');

                stars[index].addEventListener('click', () => {
                    console.log(stars[index]);
                    for (let i = 0; i < stars.length; i++) {
                        if (i <= index) {
                            stars[i].classList.remove('text-dark');
                            stars[i].classList.add('text-warning');
                            document.getElementById('rating_comment').value = i + 1;
                        } else {
                            stars[i].classList.remove('text-warning');
                            stars[i].classList.add('text-dark');
                        }
                    }
                });
            }
        })
    </script>

    <?php
    // Vérifiez si la variable de session est définie et affichez le message de soumission
    if (isset($_SESSION['comment_success']) && $_SESSION['comment_success']) {
        echo '<script>setTimeout(function(){ alert("Votre commentaire a été soumis avec succès !"); }, 150);</script>'; // Affichez le message pendant 3 secondes (150 millisecondes)
        unset($_SESSION['comment_success']);
    }

    require_once 'inc/footer.inc.php';
    ?>