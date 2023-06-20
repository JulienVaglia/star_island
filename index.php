<?php
require_once 'config/function.php';
require_once 'inc/header.inc.php';
?>

<main>

    <div class="Bloc1">

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
    </div>
    <?php
    require_once 'inc/barre_lien.inc.php';
    ?>
    <!-- Notation etoiles -->

    <div class="avis_client">
        <div class="bloc_commentaire">

            <div class="bulle_gauche">
            </div>

            <div class="bulle_droite">
            </div>

            <div class="bulle_gauche">
            </div>

            <div class="bulle_droite">
            </div>
        </div>
    </div>

    <div class="bloc_avis">

        <h2 id="titre_commentaire">Votre avis nous intéresse</h2>

        <textarea name="commentaire" id="commentaire" rows="10" placeholder="Ecrire votre commentaire"></textarea>
        <button class="publier" > Publier </button>
    </div>



</main>
<?php require_once 'inc/footer.inc.php';          ?>