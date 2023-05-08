<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario_grupo.php";

if(!isset($_SESSION['usuario']['id_usuario'])){
    header('Location: /filminhos/views/login.php');
}

try {
    $grupos = UsuarioGrupo::listarMeusGrupos($_SESSION['usuario']['id_usuario']);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<section>
    <a href="/filminhos/views/criar_grupo.php">
        <button>
            Criar Grupo
        </button>
    </a>
</section>

<section>
    <?php foreach ($grupos as $grupo) : ?>
        <a href="/filminhos/views/detalhes_grupo.php?id_grupo=<?= $grupo['id_grupo'] ?>">
            <div class="card largo">
                <div class="container-fotos-perfil-card">
                    <?php $usuarios = UsuarioGrupo::listarUsuariosDoGrupo($grupo['id_grupo']) ?>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <img src="data:image/jpg;charset=utf8;base64,<?= base64_encode($usuario['foto']); ?>">
                    <?php endforeach; ?>
                </div>
                <div class="card-content">
                    <h1><?= $grupo['nome'] ?></h1>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</section>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php"
?>