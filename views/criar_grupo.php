<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
if(!isset($_SESSION['usuario']['id_usuario'])){
    header('Location: /filminhos/views/login.php');
}
?>

<section class="cadastro">
    <form action="/filminhos/controllers/add_grupo_controller.php" method="post">
        <div class="form-item">
            <label for="nome_grupo">Nome</label>
            <input type="text" name="nome_grupo" id="nome_grupo" placeholder="Nome do Grupo" required autofocus>
        </div>

        <div class="form-item">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" id="descricao" cols="30" rows="10" placeholder="Descrição do grupo..."></textarea>
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