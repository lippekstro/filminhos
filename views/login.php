<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
?>

<section class="login">
    <?php if (isset($_SESSION['erro'])) : ?>
        <div class="erro">
            <p><?= $_SESSION['erro']; ?></p>
        </div>
        <?php unset($_SESSION['erro']); ?>
    <?php endif; ?>
    <form action="/filminhos/controllers/login_controller.php" method="post">
        <div class="form-item">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Seu Email" required autofocus>
        </div>

        <div class="form-item">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Sua Senha" required>
        </div>

        <div class="form-item">
            <button type="submit">
                Entrar
            </button>

            <a href="/filminhos/views/cadastro.php">
                <button type="button">
                    Cadastrar-se
                </button>
            </a>
        </div>
    </form>
</section>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php"
?>