    <?php
    require_once 'config/function.php';
    require_once 'inc/header.inc.php'; ?>

    <main class="main_gallerie">

        <div class="affichage"></div>

        <div class="container2_gallerie">

            <div class="view_image"></div>

            <input type="radio" name="slider" id="item-1" checked>
            <input type="radio" name="slider" id="item-2">
            <input type="radio" name="slider" id="item-3">
            <div class="cards">
                <label class="card" for="item-1" id="song-1">
                    <img src="https://images.unsplash.com/photo-1530651788726-1dbf58eeef1f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=882&q=80" alt="song">
                </label>
                <label class="card" for="item-2" id="song-2">
                    <img src="https://images.unsplash.com/photo-1559386484-97dfc0e15539?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1234&q=80" alt="song">
                </label>
                <label class="card" for="item-3" id="song-3">
                    <img src="https://images.unsplash.com/photo-1533461502717-83546f485d24?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60" alt="song">
                </label>
            </div>

        </div>

        <?php
        require_once 'inc/barre_lien.inc.php';
        ?>

    </main>

    <?php require_once 'inc/footer.inc.php'; ?>