<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/convite.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/nota.php";

if (!isset($_SESSION['usuario']['id_usuario'])) {
    header('Location: /filminhos/views/login.php');
}

try {
    $convites = Convite::listarMeusConvites($_SESSION['usuario']['id_usuario']);
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $usuario = new Usuario($_SESSION['usuario']['id_usuario']);
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $ultimas = Nota::listarUltimasNotas($_SESSION['usuario']['id_usuario']);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<section>
    <?php foreach ($convites as $convite) : ?>
        <p><?= Convite::obterNomeGrupo($convite['id_grupo']) ?></p>
        <a href="/filminhos/controllers/confirma_convite_controller.php?id_grupo=<?= $convite['id_grupo'] ?>&id_convite=<?= $convite['id_convite'] ?>">
            <div class="btn-convite">
                <span class="material-symbols-outlined">done</span>
            </div>
        </a>
        <a href="/filminhos/controllers/del_convite_controller.php?id_convite=<?= $convite['id_convite'] ?>">
            <div class="btn-convite">
                <span class="material-symbols-outlined">close</span>
            </div>
        </a>
    <?php endforeach; ?>
</section>

<section class="perfil">
    <div class="foto-perfil">
        <img src="data:image/jpg;charset=utf8;base64,<?= base64_encode($usuario->foto); ?>">
        <a href="/filminhos/views/mudaFoto.php">
            <button>
                Alterar Imagem
            </button>
        </a>
    </div>
    <div>
        <div class="form-item">
            <input type="text" name="" id="" value="<?= $usuario->nome ?>" disabled>
        </div>
        <div class="form-item">
            <input type="text" name="" id="" value="<?= $usuario->email ?>" disabled>
        </div>

        <div class="form-item">
            <a href="/filminhos/views/edita_perfil.php">
                <button>
                    Editar Perfil
                </button>
            </a>
            <a href="/filminhos/views/edita_senha.php">
                <button>
                    Editar Senha
                </button>
            </a>
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