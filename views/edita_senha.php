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

<?php if (isset($_SESSION['erro'])) : ?>
    <section class="erro">
        <p><?= $_SESSION['erro']; ?></p>
    </section>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<section class="cadastro">

    <form action="/filminhos/controllers/edt_senha_controller.php" method="post" enctype="multipart/form-data">
        <div class="form-item">
            <label for="antiga_senha">Senha Atual</label>
            <input type="password" name="antiga_senha" id="antiga_senha" placeholder="Senha Antiga" required autofocus>
        </div>

        <div class="form-item">
            <label for="senha">Nova Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Senha Nova" required>
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