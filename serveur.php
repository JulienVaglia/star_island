<?php
require_once 'config/function.php';
require_once 'inc/header.inc.php';
?>

<main class="main_serveur">
    <link rel="stylesheet" href="assets/css/style_serveur.scss">

    <h1>Une équipe de passionné à votre service</h1>

    <div class="filterBar">

        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

            <input type="radio" class="btn-check" name="btnradio" autocomplete="off" id="btnradio1" check>
            <label class="btn btn-outline-primary startBtn" for="btnradio1">Tous</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
            <label class="btn btn-outline-primary mid_btn" for="btnradio2">Admins</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
            <label class="btn btn-outline-primary mid_btn" for="btnradio3">Staff - Modérateurs</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
            <label class="btn btn-outline-primary mid_btn" for="btnradio4">Développeurs</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
            <label class="btn btn-outline-primary mid_btn" for="btnradio5">Mappers</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio6" autocomplete="off">
            <label class="btn btn-outline-primary endBtn" for="btnradio6">Helpers</label>

        </div>

    </div>

    <div class="container text-center ">

        <div class="row align-items-start">

            <div class="col">
            </div>

            <div class="col-2 img_ligne1 img_ligne1">
                <img src="assets/img/Souen.png" alt="">
                c
            </div>

            <div class="col-2 img_ligne1">
                <img src="assets/img/ellios.png" alt="">
                <h4>Keyser Soze</h4>
            </div>

            <div class="col-2 img_ligne1">
                <img src="assets/img/charmilia.png" alt="">
                <h4>Lokkim_07</h4>
            </div>

            <div class="col-2 img_ligne1">
                <img src="assets/img/geoffroy.png" alt="">
                <h4>Le Corse</h4>
            </div>

            <div class="col-2 img_ligne1">
                <img src="assets/img/esmeralda.png" alt="">
                <h4>Keyser Soze</h4>
            </div>

            <div class="col">
            </div>
           
            <div class="col-2 img_ligne2">
                <img src="assets/img/ellios.png" alt="">
                <h4>Lokkim_07</h4>
            </div>

            <div class="col-2 img_ligne2">
                <img src="assets/img/esmeralda.png" alt="">
                <h4>Lokkim_07</h4>
            </div>

            <div class="col-2 img_ligne2">
                <img src="assets/img/geoffroy.png" alt="">
                <h4>Keyser Soze</h4>
            </div>

            <div class="col-2 img_ligne2">
                <img src="assets/img/Souen.png" alt="">
                <h4>Keyser Soze</h4>
            </div>

            <div class="col-2 img_ligne2">
                <img src="assets/img/tango_wee.png" alt="">
                <h4>Le Corse</h4>
            </div>

            <div class="col-2 img_ligne2">
                <img src="assets/img/charmilia.png" alt="">
                <h4>Le Corse</h4>
            </div>

            

        </div>


        <?php
        require_once 'inc/barre_lien.inc.php';
        ?>

</main>

<?php require_once 'inc/footer.inc.php'; ?>