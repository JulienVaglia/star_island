<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.3/lux/bootstrap.min.css" integrity="sha512-+TCHrZDlJaieLxYGAxpR5QgMae/jFXNkrc6sxxYsIVuo/28nknKtf9Qv+J2PqqPXj0vtZo9AKW/SMWXe8i/o6w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/style_barre_lien.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
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
                            <a class="nav-link" href="gallerie.php" target="_blank">GALLERIE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="vip.php">DEVENIR VIP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="serveur.php">SERVEUR</a>
                        </li>
                        <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->

                    </ul>
                    <div class="right_nav">
                        <a href="rules.html" target="_blank">
                            <img src="assets/icon/tableau-daffichage.png" alt=""><br> Règlement</a>
                        <a href="event.php">
                            <img src="assets/icon/bulle-de-discussion.png" alt=""><br>EVENT</a>
                    </div>

                </div>
            </div>
        </nav>
    </header>

