<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/convite.php";
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


<section class="alterar-img-perfil">
    <img id="imagem" src="data:image/jpg;charset=utf8;base64,<?= base64_encode($usuario->foto); ?>">
    <form action="/filminhos/controllers/muda_foto_controller.php" method="POST" enctype="multipart/form-data">
        <div class="form-item">
            <label for="foto">Nova Foto</label>
            <input type="file" name="foto" id="foto" onchange="mostrarNovaFoto()">
        </div>

        <div class="form-item">
            <button type="submit">
                Atualizar
            </button>
        </div>
    </form>
</section>

<script>
    function mostrarNovaFoto() {
        const novaFoto = document.getElementById('foto').files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('imagem').setAttribute('src', e.target.result);
        }

        reader.readAsDataURL(novaFoto);
    }
</script>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php";
?>