<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario.php";

if (!isset($_SESSION['usuario']['id_usuario'])) {
    header('Location: /filminhos/views/login.php');
}

try {
    $usuario = new Usuario($_SESSION['usuario']['id_usuario']);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<section class="cadastro">
    <form action="/filminhos/controllers/edt_cadastro_controller.php" method="post" enctype="multipart/form-data">
        <div class="form-item">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" placeholder="Seu Nome" value="<?= $usuario->nome ?>" required autofocus>
        </div>

        <div class="form-item">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Seu Email" value="<?= $usuario->email ?>" required>
        </div>

        <div class="form-item">
            <button type="submit">
                Atualizar
            </button>
        </div>
    </form>
</section>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php"
?>