<?php
require_once 'config/function.php';
require_once 'inc/header.inc.php';
?>

<main class="main_serveur">
    <link rel="stylesheet" href="assets/css/style_serveur.scss">

    <h1>Une équipe de passionné à votre service</h1>

    <div class="filterBar">

        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="on" checked>
            <label id="startBtn" class="btn btn-outline-primary" for="btnradio1">Tous</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
            <label id="button" class="btn btn-outline-primary" for="btnradio2">Admins</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
            <label id="button" class="btn btn-outline-primary" for="btnradio3">Staff - Modérateurs</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
            <label id="button" class="btn btn-outline-primary" for="btnradio4">Développeurs</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
            <label id="button" class="btn btn-outline-primary" for="btnradio5">Mappers</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio6" autocomplete="off">
            <label id="endBtn" class="btn btn-outline-primary" for="btnradio6">Helpers</label>

        </div>

    </div>

    <div id="ligne1" class="container text-center">

        <div class="row align-items-start">

            <div class="col">
                <img src="assets/img/ellios.png" alt="">
            </div>

            <div class="col">
            </div>

            <div class="col">
                <img src="assets/img/esmeralda.png" alt="">
            </div>

            <div class="col">
            </div>

            <div class="col">
                <img src="assets/img/geoffroy.png" alt="">
            </div>

            <div class="col">
            </div>

            <div class="col">
                <img src="assets/img/Souen.png" alt="">
            </div>

            <div class="col">
            </div>



            <div class="col" >
                <img class="img_ligne2" src="assets/img/ellios.png" alt="">
            </div>

            <div class="col" class="img_ligne2">
                <img class="img_ligne2" src="assets/img/esmeralda.png" alt="">
            </div>

            <div class="col" class="img_ligne2">
                <img class="img_ligne2" src="assets/img/geoffroy.png" alt="">
            </div>

            <div class="col" class="img_ligne2">
                <img class="img_ligne2" src="assets/img/Souen.png" alt="">
            </div>

            <div class="col" class="img_ligne2">
                <img class="img_ligne2" src="assets/img/tango_wee.png" alt="">
            </div>

            <div class="col" class="img_ligne2">
                <img class="img_ligne2" src="assets/img/charmilia.png" alt="">
            </div>

        </div>


        <?php
        require_once 'inc/barre_lien.inc.php';
        ?>

</main>

<?php require_once 'inc/footer.inc.php'; ?>