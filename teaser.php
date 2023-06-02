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

        <div id="timer"></div>

        <div id="navLien">

            <button class="button"><a href="" class=""><img class="logoDiscord" src="assets/img/logo discord.png" alt="discord"></a>

            <div class="barre_liens">
                <a href="" class=""><img src="assets/img/logo Instagram.png" alt="instagram"></a>
                <a href="" class=""><img src="assets/img/logo facebook.png" alt="facebook"></a>
                <a href="" class="logo1"><img src="assets/img/logo tiktok.png" alt="tiktok"></a>
                <a href="" class="logo2"><img src="assets/img/logo twitch.png" alt="twitch"></a>
                <a href="" class=""><img src="assets/img/logo twitter.png" alt="twitter"></a>
                <a href="" class=""><img src="assets/img/logo youtube.png" alt="youtube"></a>
            </div>

        </div></button>

      
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
                Affiche.innerHTML = j + " j " + h + " h " + mn + " min " + sec + " s";
                window.status = "Temps restant : " + j + " j " + h + " h " + mn + " min " + sec + " s ";
            }
            tRebour = setTimeout("Rebour();", 1000);
        }
        Rebour();


        const navLien = document.querySelector("#navLien");
        const button = document.querySelector(".button");

        let toggleIndex = 0;

        button.addEventListener ( 'mouseup', () =>{
        // console.log(navLien.scrollWidth); // verifier la largeur du container quand on clique sur discord

            if (toggleIndex === 0 ){
                navLien.style.width = `${navLien.scrollWidth}px`;
                toggleIndex++;
            }
        })

        
    </script>

</body>

</html>