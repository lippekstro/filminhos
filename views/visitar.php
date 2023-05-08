<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/convite.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/nota.php";

if (!isset($_SESSION['usuario']['id_usuario'])) {
    header('Location: /filminhos/views/login.php');
}

try {
    $usuario = new Usuario($_GET['id_usuario']);
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $ultimas = Nota::listarUltimasNotas($_GET['id_usuario']);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<section class="perfil">
    <div class="foto-perfil">
        <img src="data:image/jpg;charset=utf8;base64,<?= base64_encode($usuario->foto); ?>">
    </div>
    <div>
        <div class="form-item">
            <input type="text" name="" id="" value="<?= $usuario->nome ?>" disabled>
        </div>
        <div class="form-item">
            <input type="text" name="" id="" value="<?= $usuario->email ?>" disabled>
        </div>
    </div>
</section>

<section class="filmes_assistidos">
    <h1>Ultimas Avaliações</h1>
    <div class="container-cards">
        <?php foreach ($ultimas as $filme) : ?>
            <?php
            $id_filme = $filme['id_filme_api'];
            $url = "https://api.themoviedb.org/3/movie/$id_filme?api_key=$api_key&language=$lang";
            $data_nome = file_get_contents($url);
            $result = json_decode($data_nome);
            ?>
            <a href="/filminhos/views/detalhes.php?id_filme=<?= $filme['id_filme_api'] ?>">
                <div class="card">
                    <div class="card-img">
                        <figure>
                            <img src="https://image.tmdb.org/t/p/w500<?= $result->poster_path ?>">
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="ratings">
                            <div class="alinha">
                                <span class="material-symbols-outlined preenchido">star</span><?= round($result->vote_average, 1) ?>/10
                            </div>
                            <div class="alinha" title="Sua Nota">
                                <span class="material-symbols-outlined preenchido">award_star</span><?= $filme['nota'] ?>/5
                            </div>
                        </div>
                        <p>
                            <?= $result->title ?>
                        </p>

                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php";
?>