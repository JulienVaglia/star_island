<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star'Island</title>
    <link rel="stylesheet" href="assets/css/teaser.css">
</head>

<body>

    <main class="">

        <a href="https://discord.gg/starisland" target="_blank" class=""><img id="logo" src="assets/img/starisland.png" alt="logo"></a>

        <div class="texte">

            <h1>Star'Island</h1>


            <p class="presentation">Bienvenue sur notre serveur de jeux vidéo, l'endroit idéal pour les passionnés de RolePlay.<br>
                Rejoignez une communauté dynamique et conviviale où vous pourrez rencontrer des joueurs du monde entier et partager votre passion commune pour les jeux vidéo.</p>


        </div>

        <div id="timer"></div>

        <!-- Barre des liens -->

        <div id="navLien">

            <div class="barre_liens">
                <a href="https://www.instagram.com/starisland.fr/" target="_blank" class="reseauSociaux" id="instagram"><img src="assets/img/logo Instagram.png" alt="instagram"></a>
                <a href="https://www.facebook.com/StarIslandfr-108004258577047" target="_blank" class="reseauSociaux" id="facebook"><img src="assets/img/logo facebook.png" alt="facebook"></a>
                <a href="https://www.tiktok.com/@star.island?lang=fr" target="_blank" class="reseauSociaux" id="tiktok"><img src="assets/img/logo tiktok.png" alt="tiktok"></a>
                  <a href="https://discord.gg/starisland" target="_blank" class="reseauSociaux discord"><img src="assets/img/logo discord.png" alt="discord"></a>
                <a href="" class="reseauSociaux" target="_blank" id="twitch"><img src="assets/img/logo twitch.png" alt="twitch"></a>
                <a href="https://twitter.com/StarIslandfr" target="_blank" class="reseauSociaux" id="twitter"><img src="assets/img/logo twitter.png" alt="twitter"></a>
                <a href="https://www.youtube.com/channel/UCI7G6fNN-17g1_tOVMKRCpQ" target="_blank" class="reseauSociaux" id="youtube"><img src="assets/img/logo youtube.png" alt="youtube"></a>
              
            </div>

        </div>


    </main>
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


</body>

</html>