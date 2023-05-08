<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
?>

<section class="cadastro">
    <form action="/filminhos/controllers/cadastro_controller.php" method="post" enctype="multipart/form-data">
        <div class="form-item">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" placeholder="Seu Nome" required autofocus>
        </div>

        <div class="form-item">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Seu Email" required>
        </div>

        <div class="form-item">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Sua Senha" required>
        </div>

        <div class="form-item">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto">
        </div>

        <div class="form-item">
            <button type="submit">
                Cadastrar
            </button>
        </div>
    </form>
</section>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php"
?>