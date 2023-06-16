<?php require_once 'config/function.php';
require_once 'inc/header.inc.php';


?>

<main>

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
                    Fugit enim soluta sunt magnam omnis, possimus, porro autem facere necessitatibus distinctio consequuntur impedit, quam laborum hic fugiat mollitia! Distinctio corporis laboriosam velit cum quis labore cupiditate praesentium, tempora ipsam?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni ipsa voluptas quos repellat odio eos saepe, maxime at temporibus neque impedit odit nisi excepturi accusamus placeat mollitia omnis quae quam!
                    Optio ratione eligendi dignissimos, exercitationem quasi ex culpa expedita deserunt! Ipsam ea hic illum doloribus odio quibusdam, incidunt eius consequuntur distinctio ratione? Necessitatibus impedit aspernatur quae id officiis illum tempora?
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
                </p>
            </li>

            <!-- Slide 3 API Top serveur -->

            <li class="slide">
                <p class="slide-image" id="api">
                    3 - Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa, quam consequuntur voluptas ut non illum aut! Sapiente fugit enim ipsa dolor quibusdam, maxime voluptatum molestiae deleniti ipsam. Enim, vel qui.
                    Corrupti repellat sequi debitis, distinctio neque veritatis ex. Iure molestias officiis rem cupiditate repellat? Officiis ad molestias, dolore delectus aliquid laborum veniam! Ipsam reprehenderit sequi suscipit magnam, consequatur nulla tempore.
                </p>
            </li>
        </ul>
    </div>

</main>
</div>
<?php require_once 'inc/footer.inc.php';          ?>