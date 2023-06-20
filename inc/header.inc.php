<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.3/lux/bootstrap.min.css" integrity="sha512-+TCHrZDlJaieLxYGAxpR5QgMae/jFXNkrc6sxxYsIVuo/28nknKtf9Qv+J2PqqPXj0vtZo9AKW/SMWXe8i/o6w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style_header.css">
    <link rel="stylesheet" href="assets/css/style_index.css">
    <link rel="stylesheet" href="assets/css/style_gallerie.css">
    <link rel="stylesheet" href="assets/css/style_barre_lien.css">

</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= BASE_PATH; ?>">
                    <img id="logo" src="assets/img/starisland.png" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li>
                            <a class="nav-link active" href="<?= BASE_PATH; ?>"><img id="logo_acceuil" src="assets/icon/accueil.png" alt="Acceuil">
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gallerie.php">GALLERIE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">DEVENIR VIP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">SERVEUR</a>
                        </li>

                    </ul>
                    <div class="right_nav">
                        <a href="#">
                            <img src="assets/icon/tableau-daffichage.png" alt=""><br> TUTORIEL</a>
                        <a href="#" class=>
                            <img src="assets/icon/bulle-de-discussion.png" alt=""><br>EVENT</a>
                    </div>

                </div>
            </div>
        </nav>
    </header>