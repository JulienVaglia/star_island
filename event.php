<?php
require_once 'config/function.php';
require_once 'inc/header.inc.php';
?>

<main class="main_serveur">
    <link rel="stylesheet" href="assets/css/style_event.scss">

    <div class="timerBloc">

        <h1>TIME REMAINING</h1>

        <div class="timer"></div>

    </div>

    <div class="eventInfo">

        <h2>Titre Event</h2>
        
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium laboriosam exercitationem ab asperiores quibusdam voluptas numquam soluta illum suscipit molestiae odit, quam commodi ullam dolore labore quasi, delectus quae? Exercitationem.
        Magnam velit nostrum illum quos repellat fuga laudantium placeat facilis labore voluptas eos, sit, ea reiciendis consequatur, accusantium omnis explicabo? Odio harum natus optio molestiae autem earum laboriosam, perferendis praesentium.</p>

    </div>

    <img id="event_img" src="assets/img/prison_bus.png" alt="">

<script type="text/javascript">
        var Affiche = document.getElementById("timer");

        function Rebour() {
            var date1 = new Date();
            var date2 = new Date("Jun 30, 2023 00:00:00");
            var sec = (date2 - date1) / 1000;
            var n = 24 * 3600;
            if (sec > 0) {
                j = Math.floor(sec / n);
                h = Math.floor((sec - (j * n)) / 3600);
                mn = Math.floor((sec - ((j * n + h * 3600))) / 60);
                sec = Math.floor(sec - ((j * n + h * 3600 + mn * 60)));
                Affiche.innerHTML = j + "j " + h + "h " + mn + "min " + sec + "s ";
                window.status = "Temps restant : " + j + "j " + h + "h " + mn + "min " + sec + "s ";
            }
            tRebour = setTimeout("Rebour();", 1000);
        }
        Rebour();
    </script>



    <?php
    require_once 'inc/barre_lien.inc.php';
    ?>

</main>

<?php require_once 'inc/footer.inc.php'; ?>