<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario_grupo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/grupo_filme.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/grupo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/nota.php";

if (!isset($_SESSION['usuario']['id_usuario'])) {
    header('Location: /filminhos/views/login.php');
}

if (isset($_GET['busca'])) {
    $query = $_GET['busca'];
    $url = "https://api.themoviedb.org/3/search/movie?api_key=$api_key&language=$lang&query=$query&page=1&include_adult=false";
    $data_nome = file_get_contents($url);
    $result = json_decode($data_nome);
}

try {
    $grupo = new Grupo($_GET['id_grupo']);
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $filmes = GrupoFilme::listaFilmesDoGrupo($grupo->id_grupo);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_GET['busca_usr'])) {
    try {
        $query = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':email', $_GET['busca_usr']);
        $stmt->execute();
        $convidado = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<section>
    <h1><?= $grupo->nome ?></h1>
</section>

<section>
    <form action="/filminhos/views/detalhes_grupo.php">
        <input type="hidden" name="id_grupo" value="<?= $grupo->id_grupo ?>">
        <input type="search" name="busca" id="busca">
        <button type="submit">
            Buscar
        </button>
    </form>

    <?php if (isset($result) && count($result->results) > 0) : ?>
        <section>
            <?php foreach ($result->results as $filme) : ?>
                <a href="/filminhos/views/detalhes.php?id_filme=<?= $filme->id ?>">
                    <div class="card">
                        <div class="card-img">
                            <figure>
                                <img src="https://image.tmdb.org/t/p/w500<?= $filme->poster_path ?>">
                            </figure>
                            <div class="adicionar-icon">
                                <a href="/filminhos/controllers/add_filme_grupo_controller.php?id_filme=<?= $filme->id ?>&id_grupo=<?= $grupo->id_grupo ?>" title="adicionar ao grupo">
                                    <span class="material-symbols-outlined">add</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="ratings">
                                <span class="material-symbols-outlined preenchido">star</span><?= round($filme->vote_average, 1) ?>/10
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
</section>

<?php if (isset($filmes) && count($filmes) > 0) : ?>
    <section class="filmes_assistidos">
        <aside>
            <form action="/filminhos/views/detalhes_grupo.php">
                <input type="hidden" name="id_grupo" value="<?= $grupo->id_grupo ?>">
                <input type="email" name="busca_usr" id="busca_usr" placeholder="Buscar Usuario">
                <button type="submit">
                    Buscar
                </button>
            </form>
            <?php if (isset($_GET['busca_usr']) && count($convidado) > 0) : ?>
                <div class="convite">
                    <img src="data:image/jpg;charset=utf8;base64,<?= base64_encode($convidado[0]['foto']); ?>">
                    <a href="/filminhos/controllers/add_convite_controller.php?id_convidado=<?= $convidado[0]['id_usuario'] ?>&id_grupo=<?= $grupo->id_grupo ?>">
                        <div class="btn-convite">
                            <span class="material-symbols-outlined">add</span>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <h1>Integrantes</h1>
            <div>
                <?php $usuarios = UsuarioGrupo::listarUsuariosDoGrupo($grupo->id_grupo) ?>
                <?php foreach ($usuarios as $usuario) : ?>
                    <a href="/filminhos/views/visitar.php?id_usuario=<?= $usuario['id_usuario'] ?>">
                        <img src="data:image/jpg;charset=utf8;base64,<?= base64_encode($usuario['foto']); ?>">
                    </a>
                <?php endforeach; ?>
            </div>

        </aside>
        <h1>Filmes Assistidos</h1>
        <div class="container-cards">
            <?php foreach ($filmes as $filme) : ?>
                <?php
                $id_filme = $filme['id_filme_api'];
                $url = "https://api.themoviedb.org/3/movie/$id_filme?api_key=$api_key&language=$lang";
                $data_nome = file_get_contents($url);
                $result = json_decode($data_nome);
                ?>
                <a href="/filminhos/views/detalhes.php?id_filme=<?= $result->id ?>">
                    <div class="card">
                        <div class="card-img">
                            <figure>
                                <img src="https://image.tmdb.org/t/p/w500<?= $result->poster_path ?>">
                            </figure>
                            <div class="adicionar-icon">
                                <a href="/filminhos/controllers/del_filme_grupo_controller.php?id_grupo_filme=<?= $filme['id_grupo_filme'] ?>&id_grupo=<?= $grupo->id_grupo ?>" title="remover do grupo">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="ratings">
                                <div class="alinha">
                                    <span class="material-symbols-outlined preenchido">star</span><?= round($result->vote_average, 1) ?>/10
                                </div>
                                <div class="alinha" title="Avaliação média do grupo">
                                    <span class="material-symbols-outlined preenchido">award_star</span><?= round(Nota::calcularMediaPorGrupo($id_filme, $grupo->id_grupo), 1) ?>/5
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
<?php else : ?>
    <section>
        Nenhum filme adicionado ao grupo!
    </section>
<?php endif; ?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php"
?>