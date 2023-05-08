<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";

if (isset($_GET['busca'])) {
    $query = $_GET['busca'];
    $url = "https://api.themoviedb.org/3/search/movie?api_key=$api_key&language=$lang&query=$query&page=1&include_adult=false";
    $data_nome = file_get_contents($url);
    $result = json_decode($data_nome);
} else {
    $url = "https://api.themoviedb.org/3/trending/movie/day?api_key=$api_key";
    $data_nome = file_get_contents($url);
    $result = json_decode($data_nome);
}

?>



<div class="buscador">
    <form action="index.php" autocomplete="off">
        <input type="search" name="busca" id="busca">
        <button type="submit">
            Buscar
        </button>
    </form>
</div>

<?php if (isset($result) && count($result->results) > 0) : ?>
    <section>
        <?php foreach ($result->results as $filme) : ?>
            <a href="/filminhos/views/detalhes.php?id_filme=<?= $filme->id ?>">
                <div class="card">
                    <div class="card-img">
                        <figure>
                            <img src="https://image.tmdb.org/t/p/w500<?= $filme->poster_path ?>">
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="ratings">
                            <div class="alinha">
                                <span class="material-symbols-outlined preenchido">star</span><?= round($filme->vote_average, 1) ?>/10
                            </div>
                        </div>
                        <p>
                            <?= $filme->title ?>
                        </p>

                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </section>
<?php else : ?>
    <section>
        Nenhum filme encontrado!
    </section>
<?php endif; ?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php"
?>