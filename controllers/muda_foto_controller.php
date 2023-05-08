<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario.php";
session_start();

try {
    $id_usuario = $_SESSION['usuario']['id_usuario'];
    if (!empty($_FILES['foto']['tmp_name'])) {
        $imagem = file_get_contents($_FILES['foto']['tmp_name']);
    } else {
        $_SESSION['msg'] = 'Foto Não Enviada';
        header("Location: /filminhos/views/perfil.php");
        exit();
    }

    $usuario = new Usuario($id_usuario);
    $usuario->foto = $imagem;
    $usuario->editaFoto();

    $_SESSION['msg'] = 'Editado com Sucesso';
    header("Location: /filminhos/views/perfil.php");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}
